<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class MigrateAndGenerate extends Command
{
    protected $signature = 'migrate:generate';
    protected $description = 'Run migrations and update model and request files';

    public function handle(): void
    {
        // Get pending migrations
        $pendingMigrations = $this->getPendingMigrations();

        // Execute the migrations
        $this->info('Running migrations...');
        Artisan::call('migrate');

        foreach ($pendingMigrations as $migration) {
            $this->updateModelAndRequests($migration);
        }

        $this->info('Models and requests updated successfully.');
    }

    private function getPendingMigrations(): array
    {
        // Get the list of already run migrations from the database
        $ranMigrations = DB::table('migrations')->pluck('migration')->toArray();

        // Get all migration files from the migrations directory
        $migrationFiles = File::files(database_path('migrations'));

        // Extract the names of the migration files
        $allMigrations = array_map(function ($file) {
            return pathinfo($file, PATHINFO_FILENAME);
        }, $migrationFiles);

        // Find the migrations that are pending
        $pendingMigrations = array_diff($allMigrations, $ranMigrations);

        return $pendingMigrations; // Return only pending migrations
    }

    protected function updateModelAndRequests($migration): void
    {
        $pattern   = '/create_(.*?)_table/';
        preg_match($pattern, $migration,$matches);
        $modelName = Str::studly(Str::singular($matches[1]));
        $this->info("Updating model and request files for $modelName...");
        $modelNameWithNameSpace = 'App\Models\\' . $modelName;
        $dataColumns            = $modelNameWithNameSpace::getDataColumns();

        $columnsTable = [];
        foreach ($dataColumns['items'] as $item) {
            $columnsTable[] = $item['field'];
        }

        $columns          = array_diff($columnsTable, ['deleted_at', 'created_at', 'updated_at']);
        $columnsWithoutId = array_diff($columns, ['id']);

        $modelPath         = app_path("Models/{$modelName}.php");
        $requestStorePath  = app_path("Http/Requests/{$modelName}/Store{$modelName}Request.php");
        $requestUpdatePath = app_path("Http/Requests/{$modelName}/Update{$modelName}Request.php");

        if (File::exists($modelPath)) {
            $content = File::get($modelPath);

            $fillableContent         = implode(",\n        ", array_map(fn($col) => "'$col'", $columns));
            $datatableColumnsContent = implode(",\n        ", array_map(fn($col) => "'$col'", $columns));
            $formColumnsContent      = implode(",\n        ", array_map(fn($col) => "'$col'", $columnsWithoutId));
            $searchableContent       = implode(",\n        ", array_map(fn($col) => "'$col'", $columnsWithoutId));
            $sortableContent         = implode(",\n        ", array_map(fn($col) => "'$col'", $columns));

            $content = preg_replace('/protected\s+\$fillable\s*=\s*\[\s*\]/', "protected \$fillable = [\n        $fillableContent\n    ]", $content);
            $content = preg_replace('/protected\s+array\s+\$datatableColumns\s*=\s*\[\s*\]/', "protected array \$datatableColumns = [\n        $datatableColumnsContent\n    ]", $content);
            $content = preg_replace('/protected\s+array\s+\$formColumns\s*=\s*\[\s*\]/', "protected array \$formColumns = [\n        $formColumnsContent\n    ]", $content);
            $content = preg_replace('/protected\s+array\s+\$searchable\s*=\s*\[\s*\]/', "protected array \$searchable = [\n        $searchableContent\n    ]", $content);
            $content = preg_replace('/protected\s+array\s+\$sortable\s*=\s*\[\s*\]/', "protected array \$sortable = [\n        $sortableContent\n    ]", $content);

            // add relationships hasOne and BelongsTo

            File::put($modelPath, $content);
        }

        if (File::exists($requestStorePath)) {
            $content = File::get($requestStorePath);
            // here you can add the logic to update the Store Request
            File::put($requestStorePath, $content);
        }

        if (File::exists($requestUpdatePath)) {
            $content = File::get($requestUpdatePath);
            // here you can add the logic to update the Update Request
            File::put($requestUpdatePath, $content);
        }
    }
}

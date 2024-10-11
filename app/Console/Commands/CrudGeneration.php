<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CrudGeneration extends Command
{
    protected $signature = 'crud:generate {names*}';
    protected $description = 'Generate CRUD components for a given model name';

    public function handle(): void
    {
        $names = $this->argument('names');

        foreach ($names as $name) {
            $this->generateMigration($name);
            $this->generateModel($name);
            $this->generateSeeder($name);
            $this->generateFactory($name);
            $this->generatePolicy($name);
            $this->generateController($name);
            $this->generateRequests($name);
            $this->generateVueComponent($name);
            $this->addRoutes($name);
            // $this->>generateNavlingSeeder($name);
            // $this->>generateROleHasPermissionsSeeder($name);
        }

        $this->info("CRUD components for $name generated successfully.");
    }

    protected function generateMigration($name): void
    {
        $tableName     = Str::snake(Str::plural($name));
        $migrationName = "create_{$tableName}_table";

        $migrationFilePattern = database_path("migrations/") . "*_{$migrationName}.php";

        if (glob($migrationFilePattern)) {
            $this->info("Migration file for {$migrationName} already exists. Skipping creation.");
        } else {
            $this->call('make:migration', ['name' => $migrationName]);
            $this->info("Migration for {$migrationName} created successfully.");
        }
    }

    protected function generateModel($name): void
    {
        $modelNameLowerPlural = strtolower(Str::plural($name));

        $modelContent = str_replace(
            ['{ModelName}', '{modelNameLowerPlural}'],
            [$name, $modelNameLowerPlural],
            File::get(resource_path('templates/model-template.txt'))
        );

        File::put(app_path("Models/{$name}.php"), $modelContent);
    }


    protected function generateSeeder($name): void
    {
        $this->call('make:seeder', ['name' => "{$name}Seeder"]);
    }

    protected function generateFactory($name): void
    {
        $this->call('make:factory', ['name' => "{$name}Factory"]);
    }

    protected function generatePolicy($name): void
    {
        $modelNameLower       = strtolower($name);
        $modelNameLowerPlural = strtolower(Str::plural($name));

        $policyContent = str_replace(
            ['{ModelName}', '{modelNameLower}', '{modelNameLowerPlural}'],
            [$name, $modelNameLower, $modelNameLowerPlural],
            File::get(resource_path('templates/policy-template.txt'))
        );

        File::put(app_path("Policies/{$name}Policy.php"), $policyContent);
    }


    protected function generateController($name): void
    {
        $modelNameLowerPlural = strtolower(Str::plural($name));
        $modelNamePlural      = ucfirst($modelNameLowerPlural);

        $controllerContent = str_replace(
            ['{ModelName}', '{modelNameLower}', '{modelNameLowerPlural}', '{modelNamePlural}'],
            [$name, strtolower($name), $modelNameLowerPlural, $modelNamePlural],
            File::get(resource_path('templates/controller-template.txt'))
        );

        File::put(app_path("Http/Controllers/Dashboard/{$name}Controller.php"), $controllerContent);
    }


    protected function generateRequests($name): void
    {
        $requestDir = app_path("Http/Requests/{$name}");

        if (!File::exists($requestDir)) {
            File::makeDirectory($requestDir, 0755, true);
        }

        $storeRequestName    = "{$name}/Store{$name}Request";
        $storeRequestContent = str_replace(
            '{ModelName}',
            $name,
            File::get(resource_path('templates/store-request-template.txt'))
        );
        File::put(app_path("Http/Requests/{$storeRequestName}.php"), $storeRequestContent);

        $updateRequestName    = "{$name}/Update{$name}Request";
        $updateRequestContent = str_replace(
            '{ModelName}',
            $name,
            File::get(resource_path('templates/update-request-template.txt'))
        );

        File::put(app_path("Http/Requests/{$updateRequestName}.php"), $updateRequestContent);
    }


    protected function generateVueComponent($name): void
    {
        $vueDir = resource_path("js/Pages/{$name}");

        if (!File::exists($vueDir)) {
            File::makeDirectory($vueDir, 0755, true);
        }

        $camelCaseName            = Str::camel($name);
        $pluralCamelCaseName      = Str::plural($camelCaseName);
        $firstLetterUpperCaseName = ucfirst($pluralCamelCaseName);


        $templatePath = resource_path('templates/vue-template.txt');
        $vueContent   = File::get($templatePath);

        $vueContent = str_replace('{{camelCaseName}}', $camelCaseName, $vueContent);
        $vueContent = str_replace('{{pluralCamelCaseName}}', $pluralCamelCaseName, $vueContent);
        $vueContent = str_replace('{{firstLetterUpperCaseName}}', $firstLetterUpperCaseName, $vueContent);
        $vueContent = str_replace('{{name}}', $name, $vueContent);

        File::put("{$vueDir}/Index.vue", $vueContent);
    }


    protected function addRoutes($name): void
    {
//        $routeFile = base_path('routes/web.php');
        $routeFile = base_path('routes/dashboard.php');

        $routeContent = "
        Route::post('/" . strtolower(Str::plural($name)) . "/mass-destroy', [" . ucfirst($name) . "Controller::class, 'massDestroy'])->name('" . strtolower(Str::plural($name)) . ".massDestroy');
        Route::resource('" . strtolower(Str::plural($name)) . "', " . ucfirst($name) . "Controller::class)->except(['create', 'edit', 'show']);
        ";

        $existingRoutes = File::get($routeFile);

        if (str_contains($existingRoutes, "Route::post('/" . strtolower(Str::plural($name)) . "/mass-destroy'") &&
            str_contains($existingRoutes, "Route::resource('" . strtolower(Str::plural($name)) . "'")) {
            $this->info("Routes for {$name} already exist. Skipping addition.");
        } else {
            $useStatement = "use App\Http\Controllers\Dashboard\\" . ucfirst($name) . "Controller;\n";

            if (preg_match('/^(use\s+.*?;.*?(\n|$))/m', $existingRoutes, $matches)) {
                $newRoutesContent = str_replace($matches[0], $useStatement . $matches[0], $existingRoutes);
            } else {
                $newRoutesContent = preg_replace('/(<\?php.*?\n)/s', '$1' . "\n" . $useStatement, $existingRoutes);
            }

            File::put($routeFile, $newRoutesContent);

            File::append($routeFile, $routeContent);
            $this->info("Routes for {$name} added successfully.");
        }
    }


}


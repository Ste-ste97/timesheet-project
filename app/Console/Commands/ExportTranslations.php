<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Translation;
use Illuminate\Support\Facades\File;

class ExportTranslations extends Command
{
    protected $signature = 'translation:export';
    protected $description = 'Export translations to JSON files';

    public function handle(): int
    {
        $translations = Translation::all();
        $grouped      = $translations->groupBy('language');

        foreach ($grouped as $language => $items) {
            $data        = $items->pluck('value', 'key')->toArray();
            $jsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            $filePath = resource_path("lang/$language.json");
            File::put($filePath, $jsonContent);

            $this->info("Exported $language translations to $filePath");
        }

        return self::SUCCESS;
    }
}

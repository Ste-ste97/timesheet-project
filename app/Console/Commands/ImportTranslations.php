<?php

namespace App\Console\Commands;

use App\Models\Translation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportTranslations extends Command
{
    protected $signature   = 'translation:import';
    protected $description = 'Import translations from json to db.';

    public function handle(): int
    {
        $languageFiles = File::files(resource_path('lang'));

        foreach ($languageFiles as $file) {
            if ($file->getExtension() === 'json') {
                $language = $file->getBasename('.json');
                $translations = json_decode(File::get($file), true);

                foreach ($translations as $key => $value) {
                    Translation::updateOrCreate(
                        ['key' => $key, 'language' => $language],
                        ['value' => $value]
                    );
                }

                $this->info("Imported translations for '$language' language.");
            }
        }

        return self::SUCCESS;
    }
}

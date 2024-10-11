const fs    = require('fs');
const glob  = require('glob');
const axios = require('axios');
const path  = require('path');
require('dotenv').config();

const apiKey         = process.env.GOOGLE_TRANSLATE_API_KEY;
const targetLanguage = 'el';
const outputFile     = path.join(__dirname, 'resources/lang/gr.json');

function extractPhrases(patterns) {
    const phrases = new Set();

    patterns.forEach((pattern) => {
        const files = glob.sync(pattern);

        files.forEach((file) => {
            const content = fs.readFileSync(file, 'utf8');
            const regex   = /__\(['"`](.*?)['"`]\)/g;
            let match;

            while ((match = regex.exec(content)) !== null) {
                phrases.add(match[1]);
            }
        });
    });

    return Array.from(phrases);
}

async function translatePhrases(phrases, existingTranslations) {
    const newEntries = {};

    for (const phrase of phrases) {
        if (!existingTranslations.hasOwnProperty(phrase)) {
            try {
                const response = await axios.post(
                    'https://translation.googleapis.com/language/translate/v2',
                    {},
                    {
                        params : {
                            q      : phrase,
                            target : targetLanguage,
                            key    : apiKey,
                        },
                    }
                );

                const translation            = response.data.data.translations[0].translatedText;
                newEntries[phrase]           = translation;
                existingTranslations[phrase] = translation;
            } catch (error) {
                console.error(`Error translating the phrase "${phrase}":`, error.message);
            }
        }
    }

    return newEntries;
}

function  formatJson(outputFile, newEntries) {
    // We read gr.json as text
    let grJsonContent = fs.readFileSync(outputFile, 'utf8').trim();

    // Remove the last character '}'
    grJsonContent = grJsonContent.slice(0, -1);

    //remove empty line
    while (grJsonContent.length > 0 && grJsonContent.charAt(grJsonContent.length - 1) === '\n') {
        grJsonContent = grJsonContent.substring(0, grJsonContent.length - 1);
    }

    //If there is no other record, we don't add a comma
    if (!grJsonContent.trim().endsWith('{')) {
        grJsonContent += ',';
    }

    // Add the new records
    const newEntriesJson = JSON.stringify(newEntries, null, 4).slice(1, -1);

    grJsonContent +=  newEntriesJson + '}';

    return grJsonContent;
}

(async () => {
    const filePatterns = [
        'resources/views/**/*.blade.php',
        'app/**/*.php',
        'resources/js/**/*.vue',
    ];

    const phrases = extractPhrases(filePatterns);

    let existingTranslations = {};
    if (fs.existsSync(outputFile)) {
        existingTranslations = fs.readFileSync(outputFile, 'utf8');
        existingTranslations = existingTranslations.trim();

        if (existingTranslations.endsWith('}')) {
            existingTranslations = JSON.parse(existingTranslations);
        } else {
            console.error('The gr.json file is not valid JSON.');
            return;
        }
    }

    const newEntries = await translatePhrases(phrases, existingTranslations);

    if (Object.keys(newEntries).length === 0) {
        console.log('There are no new phrases to add.');
        return;
    }

    const grJsonContent = formatJson(outputFile, newEntries);

    // We write the updates to gr.json
    fs.writeFileSync(outputFile, grJsonContent, 'utf8');

    console.log(`Translations saved in  ${outputFile}`);

})();

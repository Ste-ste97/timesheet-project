<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CityCountrySeeder extends Seeder
{
    public function run(): void {
        $cyprus = Country::firstOrCreate([
            'name'       => 'Cyprus',
            'greek_name' => 'Κύπρος'
        ]);

        $cities = [['Nicosia', 'Λευκωσία'], ['Larnaca', 'Λάρνακα'], ['Limassol', 'Λεμεσός'], ['Paphos', 'Πάφος'], ['Kyrenia', 'Κερύνεια'], ['Famagusta', 'Αμμόχωστος']];

        foreach ($cities as $city) {
            $c = new City(['name' => $city[0], 'greek_name' => $city[1]]);
            $c->country()->associate($cyprus);
            $c->save();
        }
    }
}

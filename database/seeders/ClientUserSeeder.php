<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;

class ClientUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('id', '!=', 1)->get();
        $clients = Client::all();

        foreach ($clients as $client) {
            $client->users()->attach($users->pluck('id')->toArray());
        }
    }
}

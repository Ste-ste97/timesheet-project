<?php

namespace Database\Seeders;


use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $clients = [
            'A.K.Simplex',
            'Adam & Eve Hairdressing',
            'AKK Hair Story Salon Ltd',
        ];

        foreach ($clients as $client) {
            Client::factory()->withName($client)->create();
        }

        $users   = User::where('id', '!=', 1)->get();
        $clients = Client::all();

        // Βεβαιώσου ότι υπάρχουν χρήστες και εταιρίες
        if ($users->isEmpty() || $clients->isEmpty()) {
            $this->command->info('There are no users or clients to associate.');
            return;
        }

        // Για κάθε χρήστη, συσχέτισέ τον με όλες τις εταιρίες
        foreach ($users as $user) {
            $user->clients()->sync($clients->pluck('id'));
        }

        // Για κάθε εταιρία, συσχέτισέ την με όλους τους χρήστες
        foreach ($clients as $client) {
            $client->users()->sync($users->pluck('id'));
        }
    }
}

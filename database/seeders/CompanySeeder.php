<?php

namespace Database\Seeders;


use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run()
    {
        $companies = [
            'A.K.Simplex',
            'Adam & Eve Hairdressing',
            'AKK Hair Story Salon Ltd',
            'Alecos Shoes Ltd',
            'Andreas Kalogerou',
            'Andreas Kyriacou',
            'Ark Surv Ltd',
            'C & A Coffeemasters Ltd',
            'C Asprou Buildings Ltd',
            'CCZ Suppliments Ltd',
            'Christos Panagiotou',
            'D&S Andreou Neophytou Ltd',
            'Emporiki Eteria Ektoros Ltd',
            'G Lab Project 3D Ltd',
            'I.S.K Tomouzi Ltd',
            'Insightin Ltd',
            'Lambros S Lambrou Contracting Ltd',
            'M A Michael Const & Develop Ltd',
            'Maria Costa',
            'Oikodom. Epix. MI.A.MI Ltd',
            'P & I Studio Ltd',
            'PAL Mestaya Futsal Ltd',
            'Panagiotis Lambrou',
            'Peripteron take Away Heaven Ltd',
            'R.A.R All Digital Ltd',
            'S & S Aeroporou Ltd',
            'S.L.R.A. Opportunity Ltd',
            'SKE Menoikou',
            'Solannet Telecommunications Ltd',
            'Spitisia Proionta S.Karaoli & Yioi Ltd',
            'Stymiland Cleaning Ltd',
            'TZ Advance Eng Ltd',
            'Unitpro Business Consultants',
            'Vitsio Atanasov',
            'Xylourgikes Ergas. A. Ioakim Ltd',
            'Yiangos Iacovou Tomouzis'
        ];

        foreach ($companies as $company) {
            Company::create([
                'name' => $company,
            ]);
        }

        $users     = User::where('id', '!=', 1)->get();
        $companies = Company::all();

        // Βεβαιώσου ότι υπάρχουν χρήστες και εταιρίες
        if ($users->isEmpty() || $companies->isEmpty()) {
            $this->command->info('There are no users or companies to associate.');
            return;
        }

        // Για κάθε χρήστη, συσχέτισέ τον με όλες τις εταιρίες
        foreach ($users as $user) {
            $user->companies()->sync($companies->pluck('id'));
        }

        // Για κάθε εταιρία, συσχέτισέ την με όλους τους χρήστες
        foreach ($companies as $company) {
            $company->users()->sync($users->pluck('id'));
        }
    }
}

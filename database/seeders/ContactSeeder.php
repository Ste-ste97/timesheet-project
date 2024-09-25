<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        Contact::create([
            'full_name'      => 'John Doe',
            'mobile_phone'   => '1234567890',
            'landline_phone' => '0987654321',
            'address'        => '1234 Elm St',
            'fax'            => '1234567890',
            'email'          => 'john@gmail.com',
            'postal_code'    => '12345',
        ]);

        Contact::create([
            'full_name'      => 'Jane Smith',
            'mobile_phone'   => '0987654321',
            'landline_phone' => '1234567890',
            'address'        => '5678 Oak Ave',
            'fax'            => '0987654321',
            'email'          => 'jane@gmail.com',
            'postal_code'    => '54321',
        ]);

        Contact::create([
            'full_name'      => 'Michael Johnson',
            'mobile_phone'   => '5556667777',
            'landline_phone' => '1112223333',
            'address'        => '7890 Pine Rd',
            'fax'            => '5556667777',
            'email'          => 'michael@gmail.com',
            'postal_code'    => '67890',
        ]);

        Contact::create([
            'full_name'      => 'Emily Davis',
            'mobile_phone'   => '2223334444',
            'landline_phone' => '4445556666',
            'address'        => '1011 Maple Blvd',
            'fax'            => '2223334444',
            'email'          => 'emily@gmail.com',
            'postal_code'    => '11223',
        ]);

        Contact::create([
            'full_name'      => 'Chris Wilson',
            'mobile_phone'   => '3334445555',
            'landline_phone' => '6667778888',
            'address'        => '1213 Birch Ln',
            'fax'            => '3334445555',
            'email'          => 'chris@gmail.com',
            'postal_code'    => '33445',
        ]);


        Contact::factory(10)->create();

    }
}

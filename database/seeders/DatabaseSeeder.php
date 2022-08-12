<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;
use Database\Seeders\OrganizationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {        
        $faker = Faker::create();

        \App\Models\User::create([
            'slug' => Str::random(20),
            'name' => 'Admin',
            'email' => 'admin',
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'remember_token' => Str::random(10),
            'is_admin' => true,
        ]);
        \App\Models\User::factory(20)->create();

        $this->call([
            OrganizationSeeder::class,
        ]);
    }
}

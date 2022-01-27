<?php

namespace Database\Seeders;

use DateTime;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();


        // $date = new DateTime('2020-01-01');
        $date = now();

        $n = 1;
        // $n = date('Y-m-d', strtotime( $d . " +1 days"));

        for ($i = 1; $i <= 5; $i++) {
            $organizationName = $faker->company();
            if(preg_match_all('/\b(\w)/',strtoupper($organizationName),$m)) {
                $alias = implode('',$m[1]); // membuat Akronim dari $organizationName
            }

            $organization = Organization::create([
                'name' => $organizationName ,
                'alias' => $alias,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $operator = $organization->users()->create([
                'slug' => Str::random(20),
                'name' => 'Operator '.$alias,
                'email' => 'operator'.$alias.$organization->id,
                'password' => bcrypt('operator'),
                'is_operator' => true,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $headOrganizationPosition = $organization->positions()->create([
                'name' => 'Kepala '. $organizationName,
                'alias' => 'Ka'. $alias,
                'can_share_note' => 1,
                'can_view_shared_note' => mt_rand(0,1),
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $headOrganizationPosition->users()->create([
                'slug' => Str::random(50),
                'name' => $faker->name(),
                'email' => $faker->numberBetween(1000000000000, 2000000000000),
                'email_verified_at' => now(),
                'password' => bcrypt('user'),
                'remember_token' => Str::random(10),
                'organization_id' => $organization->id,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            for ($j = 1; $j <= 5; $j++) {
      

                for ($k = 1; $k <= 5; $k++) {
                    $positionName = $faker->jobTitle();
                    if(preg_match_all('/\b(\w)/',strtoupper($positionName),$m)) {
                        $positionAlias = implode('',$m[1]); // $v is now SOQTU
                    }

                    $position = $organization->positions()->create([
                        'name' => 'Bidang '.$positionName,
                        'alias' => 'Bid'. $positionAlias,
                        'organization_id' => $organization->id  ,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);

                    $user = $organization->users()->create([
                        'slug' => Str::random(50),
                        'name' => $faker->name(),
                        'email' => $faker->numberBetween(1000000000000, 2000000000000),
                        'email_verified_at' => now(),
                        'is_plt' => mt_rand(0,1),
                        'password' => bcrypt('user'),
                        'remember_token' => Str::random(10),
                        'organization_id' => $organization->id,
                        'position_id' => $position->id,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);

                    $count = mt_rand(15, 200);

                    for ($k = 1; $k <= $count; $k++) {

                        $contentLength =  mt_rand(30, 50);

                        $note = $user->notes()->create([
                            'slug' => Str::random(60),
                            'title' => $faker->sentence(),
                            'location' => $faker->address(),
                            'description' => $faker->paragraph(3),
                            'date' => now(),
                            // 'division_id' => $division->id,
                            'organization_id' => $organization->id,
                            'position_id' => $position->id,
                            'organizer' => $faker->name(),
                            'content' => $faker->paragraph($contentLength),
                            'created_at' =>  $faker->dateTimeBetween('-1 year', '+1 day'),
                            // 'created_at' => $date,
                            'updated_at' => $date,
                        ]);

                        

                        for ($l=1; $l <= 3; $l++) { 
                            $photo = $note->photos()->create([
                                'note_id' => $note->id,
                                'url' => $faker->imageUrl(640, 480, 'animals', true),
                                'created_at' => $date,
                                'updated_at' => $date,
                            ]);
                        }
                       
                        for ($l=1; $l <= 3; $l++) { 
                            $photo = $note->attendances()->create([
                                'note_id' => $note->id,
                                'name' => $faker->name(),
                                'position' => $faker->jobTitle(),
                                'organization' => $faker->company(),
                                'created_at' => $date,
                                'updated_at' => $date,
                            ]);
                        }

                        
                    }
                    $date->modify('-1 day');


                }
            }
        }
    }
}

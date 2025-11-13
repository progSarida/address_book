<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'mirko',
                'email' => 'mirkopas85@gmail.com',
                'email_verified_at' => NULL,
                'password' => Hash::make('admin'),
                'is_admin' => 1,
                'company' => 'sarida',
                'remember_token' => NULL,
                'created_at' => '2025-04-27 08:37:11',
                'updated_at' => '2025-04-27 08:37:11',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'michele',
                'email' => 'michele.gavazzi@sarida.it',
                'email_verified_at' => NULL,
                'password' => Hash::make('M1chele'),
                'is_admin' => 1,
                'company' => 'sarida',
                'remember_token' => NULL,
                'created_at' => '2025-04-30 12:58:35',
                'updated_at' => '2025-04-30 12:58:35',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'riccardo',
                'email' => 'riccardo.sambuceti@sarida.it',
                'email_verified_at' => NULL,
                'password' => '$2y$12$vGmI72L2XXg0JYPMEB9bDuF0Ce03KQ8qRgpHPkhBqQisbysbaIwi2',
                'is_admin' => 1,
                'company' => 'sarida',
                'remember_token' => NULL,
                'created_at' => '2025-04-30 12:58:35',
                'updated_at' => '2025-04-30 12:58:35',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'paolo',
                'email' => 'andretta46@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$Tr4Z.oPEJJPXcJte.8uRZOiIO4JiIxZy0IdurVyIK/OqwBgrXc8gK',
                'is_admin' => 0,
                'company' => 'stc',
                'remember_token' => NULL,
                'created_at' => '2025-05-15 08:55:22',
                'updated_at' => '2025-05-15 07:07:06',
            ),
        ));
        
        
    }
}
<?php

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company')->insert([[
            'company_name' => "Starbucks",
            'user_name' => 'starbucksuser',
            'email' => "starbuckcompany@gmail.com",
            'password'=>  Hash::make('starbucks'),
            'mernis'=>1
        ],
        [
            'company_name' => "Portal kahve",
            'user_name' => 'portaluser',
            'email' => "portalcoffee@gmail.com",
            'password'=>  Hash::make('portalkahve'),
            'mernis'=>0
        ]]);
    }
}

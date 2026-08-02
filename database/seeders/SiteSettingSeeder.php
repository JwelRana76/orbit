<?php

namespace Database\Seeders;

use App\Models\BloodGroup;
use App\Models\Classes;
use App\Models\Gender;
use App\Models\Religion;
use App\Models\Session;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            'name' => 'Demo Hospital Management',
            'name_short' => 'DHMS',
            'address' => 'Jashore Sadar, Jashore',
            'contact' => '01571-166570',
            'email' => 'jwelranajr8676@gmail.com',
        ]);
        $gender = ['Male','Female','Other'];
        for($i=0;$i<count($gender);$i++){
            Gender::create(['name' => $gender[$i]]);
        }
        BloodGroup::create([
            'name' => "A+"
        ]);
        $religion = ['Islam','Hindu','Kristan','Other'];
        for($i=0;$i<count($religion);$i++){
        Religion::create([
            'name' => $religion[$i]]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'title' => "PREMIUM XXX",
            'cpu_id' => 1,
            'gpu_id' => 1,
            'mbd_id' => 1,
            'ram_id' => 1,
            'drive_id' => 1,
            'pccase_id' => 1,
            'psu_id' => 1,
            'cooling_id' => 1,
            'desc' => "Super config",
            'benchmark' => 7.8,
            'price' => 987,
            'is_verified' => false,
            'user_id' => 1,
            'public' => false,
            'share_url' => "",
        ]);
        DB::table('configs')->insert([
            'title' => "Ol' an' good",
            'cpu_id' => 1,
            'gpu_id' => 2,
            'mbd_id' => 1,
            'ram_id' => 2,
            'drive_id' => 1,
            'pccase_id' => 1,
            'psu_id' => 1,
            'cooling_id' => 1,
            'desc' => "Super config MIX",
            'benchmark' => 3.6,
            'price' => 600,
            'is_verified' => false,
            'user_id' => 1,
            'public' => true,
            'share_url' => "",
        ]);
        DB::table('configs')->insert([
            'title' => "Pretty one",
            'cpu_id' => 3,
            'gpu_id' => 3,
            'mbd_id' => 3,
            'ram_id' => 3,
            'drive_id' => 3,
            'pccase_id' => 3,
            'psu_id' => 3,
            'cooling_id' => 3,
            'desc' => "Super config 3",
            'benchmark' => 7.8,
            'price' => 1234,
            'is_verified' => false,
            'user_id' => 1,
            'public' => true,
            'share_url' => "",
        ]);
        DB::table('configs')->insert([
            'title' => "Sven is HUGE",
            'cpu_id' => 3,
            'gpu_id' => 3,
            'mbd_id' => 3,
            'ram_id' => 3,
            'drive_id' => 3,
            'pccase_id' => 3,
            'psu_id' => 3,
            'cooling_id' => 3,
            'desc' => "Super config 3",
            'benchmark' => 0,
            'price' => 1337,
            'is_verified' => false,
            'user_id' => 1,
            'public' => true,
            'share_url' => "",
        ]);
    }
}

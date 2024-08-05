<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RestTableSeeder::class);
    }
}

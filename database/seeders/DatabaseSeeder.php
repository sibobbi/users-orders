<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(1)->create();
         Product::factory(100)->create();
         Payment::query()->create(['name' => 'Наличные']);
         Payment::query()->create(['name' => 'Безналичные']);
    }
}

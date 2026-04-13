<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Task::factory(5)->pending()->create();
        Task::factory(4)->inProgress()->create();
        Task::factory(6)->completed()->create();
        Task::factory(3)->overdue()->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ids = User::all('id')->pluck('id')->toArray();
        foreach ($ids as $id) {
            Todo::factory()->create(['user_id' => $id]);
        }
    }
}

<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Modules\TaskModule\Models\Task;
use App\Modules\UserModule\Models\User;
use Illuminate\Database\Seeder;

final class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->first() ?? User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Task::factory()->count(5)->for($user, 'user')->create();
        Task::factory()->for($user, 'user')->pending()->create(['title' => 'Tarea ejemplo pendiente']);
        Task::factory()->for($user, 'user')->done()->create(['title' => 'Tarea ejemplo completada']);
    }
}

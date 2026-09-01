<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Modules\TaskModule\Enums\TaskStatus;
use App\Modules\TaskModule\Models\Task;
use App\Modules\UserModule\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
final class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->optional()->paragraph(),
            'status' => fake()->randomElement(TaskStatus::cases())->value,
        ];
    }

    public function pending(): self
    {
        return $this->state(fn (array $attributes): array => [
            'status' => TaskStatus::Pending,
        ]);
    }

    public function done(): self
    {
        return $this->state(fn (array $attributes): array => [
            'status' => TaskStatus::Done,
        ]);
    }
}

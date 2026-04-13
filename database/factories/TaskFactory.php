<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraph(),
            'status'      => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'priority'    => $this->faker->randomElement(['low', 'medium', 'high']),
            'due_date'    => $this->faker->optional()->dateTimeBetween('now', '+30 days'),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    public function inProgress(): static
    {
        return $this->state(['status' => 'in_progress']);
    }

    public function completed(): static
    {
        return $this->state(['status' => 'completed']);
    }

    public function highPriority(): static
    {
        return $this->state(['priority' => 'high']);
    }

    public function overdue(): static
    {
        return $this->state([
            'due_date' => $this->faker->dateTimeBetween('-30 days', '-1 days'),
            'status'   => 'pending',
        ]);
    }
}

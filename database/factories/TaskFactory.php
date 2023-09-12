<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $states = 'parent';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement([TaskStatus::TODO, TaskStatus::DONE]);

        return [
            'status' => $status,
            'priority' => rand(1, 5),
            'title' => $this->faker->text(50),
            'description' => $this->faker->text(),
            'completed_at' => $status === TaskStatus::DONE ? now() : null,
            'parent_id' => $this->getParentId()
        ];
    }

    private function getParentId(): ?int
    {
        if (rand(0, 1) && Task::first()) { //rand if task will be subtask or not
            return Task::query()->get('id')->random()->id; //if subtask get random parent task
        }

        return null;
    }

}

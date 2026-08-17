<?php

namespace Database\Factories;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Leave>
 */
class LeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $leave_types = LeaveType::all()->pluck('id')->toArray();

        return [
            'leave_type_id' => $this->faker->randomElement($leave_types),
            'user_id' => User::factory()->create()->id,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'reason' => $this->faker->text(),
        ];
    }
}

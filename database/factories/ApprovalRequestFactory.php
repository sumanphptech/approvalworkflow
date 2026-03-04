<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ApprovalRequest;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApprovalRequest>
 */
class ApprovalRequestFactory extends Factory
{
    protected $model = ApprovalRequest::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),  
            'title' => $this->faker->sentence(),
            'status' => 'pending',
            'approved_by' => null,
            'approved_at' => null,
        ];
    }
}

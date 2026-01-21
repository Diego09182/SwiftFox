<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            // 必填唯一欄位
            'account' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'cellphone' => '09' . $this->faker->unique()->numerify('########'),

            // 必填欄位
            'name' => $this->faker->name(),
            'password' => Hash::make('password123'),
            'birthday' => $this->faker->date('Y-m-d', '2005-01-01'),

            // 系統欄位
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),

            // 預設值欄位
            'times' => 0,
            'points' => 0,
            'administration' => 0,
            'status' => 1,

            // Nullable 欄位
            'avatar_filename' => null,
            'avatar_path' => null,
            'interest' => null,
            'url' => null,
            'info' => null,
            'club' => null,
            'ip_address' => null,
        ];
    }

    /**
     * 管理員帳號 state
     */
    public function admin(): static
    {
        return $this->state(fn () => [
            'administration' => 1,
        ]);
    }

    /**
     * 未驗證信箱帳號 state
     */
    public function unverified(): static
    {
        return $this->state(fn () => [
            'email_verified_at' => null,
        ]);
    }
}

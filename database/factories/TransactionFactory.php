<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $transactionType = fake()->randomElement(['debit', 'credit']);
        $reason = fake()->randomElement(['stock', 'refund']);

        return [
            'amount' => fake()->numberBetween(1, 1000),
            'currency' => fake()->randomElement(['USD', 'RUB']),
            'reason' => $reason,
            'transaction_type' => $transactionType,
            'wallet_id' => function () {
                return Wallet::factory()->create()->id;
            },
        ];
    }
}

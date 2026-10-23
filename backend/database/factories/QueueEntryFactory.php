<?php
namespace Database\Factories;
use App\Models\QueueEntry;
use App\Models\Terminal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
/** @extends Factory<QueueEntry> */
class QueueEntryFactory extends Factory {
    protected $model=QueueEntry::class;
    public function definition(): array { return ['user_id'=>User::factory(),'terminal_id'=>Terminal::factory(),'status'=>fake()->randomElement(['pending','approved','completed']),'ticket_number'=>strtoupper(fake()->unique()->bothify('???-#####'))]; }
}

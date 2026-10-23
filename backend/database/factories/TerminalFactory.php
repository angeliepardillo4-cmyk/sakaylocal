<?php
namespace Database\Factories;
use App\Models\Terminal;
use Illuminate\Database\Eloquent\Factories\Factory;
/** @extends Factory<Terminal> */
class TerminalFactory extends Factory {
    protected $model=Terminal::class;
    public function definition(): array { return ['name'=>fake()->unique()->city().' Terminal','place'=>fake()->city(), 'status'=>'active','wait_minutes'=>fake()->numberBetween(2,40),'capacity'=>fake()->numberBetween(10,100)]; }
}

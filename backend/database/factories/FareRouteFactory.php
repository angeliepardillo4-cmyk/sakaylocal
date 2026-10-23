<?php
namespace Database\Factories;
use App\Models\FareRoute;
use App\Models\Terminal;
use Illuminate\Database\Eloquent\Factories\Factory;
/** @extends Factory<FareRoute> */
class FareRouteFactory extends Factory {
    protected $model=FareRoute::class;
    public function definition(): array { return ['origin_terminal_id'=>Terminal::factory(),'destination_terminal_id'=>Terminal::factory(),'fare'=>fake()->randomFloat(2,10,100),'status'=>'approved']; }
}

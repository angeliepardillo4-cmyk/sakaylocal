<?php

namespace Database\Seeders;

use App\Models\FareRoute;
use App\Models\QueueEntry;
use App\Models\Terminal;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin=User::updateOrCreate(['email'=>'admin@sakaylocal.test'],['name'=>'SakayLocal Admin','password'=>bcrypt('password'),'role'=>'admin']);
        $user=User::updateOrCreate(['email'=>'user@sakaylocal.test'],['name'=>'Angelie Pardillo','password'=>bcrypt('password'),'role'=>'user']);
        $routeFares=[
            'Anda'=>215,
            'Baybayon'=>245,
            'Mabini'=>225,
            'Talibon via Ubay, Jagna'=>275,
            'B-Unido via Carmen'=>230,
            'Ubay via Biabas, Mabini'=>300,
            'Talibon via Carmen'=>245,
            'Talibon via Tubigon'=>255,
            'Ubay via Sierra Bullones, Carmen'=>260,
            'Tubigon'=>150,
        ];
        $names=collect(['Tagbilaran City',...array_keys($routeFares)])->map(fn($name)=>$name.' Terminal');
        $terminals=$names->map(fn($name,$i)=>Terminal::firstOrCreate(['name'=>$name],['place'=>$i===0?'Tagbilaran City · Downtown':'Bohol, Philippines','status'=>'active','wait_minutes'=>5+($i%5)*3,'capacity'=>30+($i%4)*10]));
        $origin=$terminals->firstWhere('name','Tagbilaran City Terminal');
        foreach($routeFares as $destinationName=>$fare){
            $destination=$terminals->firstWhere('name',$destinationName.' Terminal');
            FareRoute::updateOrCreate(['origin_terminal_id'=>$origin->id,'destination_terminal_id'=>$destination->id],['fare'=>$fare,'status'=>'approved']);
        }
        QueueEntry::firstOrCreate(['ticket_number'=>'DEMO-10001'],['user_id'=>$user->id,'terminal_id'=>$terminals[0]->id,'status'=>'pending']);
        QueueEntry::firstOrCreate(['ticket_number'=>'DEMO-10002'],['user_id'=>$user->id,'terminal_id'=>$terminals[1]->id,'status'=>'approved']);
    }
}

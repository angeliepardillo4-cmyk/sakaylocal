<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Terminal extends Model {
    use HasFactory;
    protected $fillable = ['name','place','status','wait_minutes','capacity'];
    public function queueEntries(){ return $this->hasMany(QueueEntry::class); }
    public function originRoutes(){ return $this->hasMany(FareRoute::class,'origin_terminal_id'); }
    public function destinationRoutes(){ return $this->hasMany(FareRoute::class,'destination_terminal_id'); }
}

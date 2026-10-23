<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class QueueEntry extends Model {
    use HasFactory;
    protected $fillable = ['user_id','terminal_id','status','ticket_number'];
    public function user(){ return $this->belongsTo(User::class); }
    public function terminal(){ return $this->belongsTo(Terminal::class); }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class FareRoute extends Model {
    use HasFactory;
    protected $fillable = ['origin_terminal_id','destination_terminal_id','fare','status'];
    protected $casts = ['fare' => 'decimal:2'];
    public function origin(){ return $this->belongsTo(Terminal::class,'origin_terminal_id'); }
    public function destination(){ return $this->belongsTo(Terminal::class,'destination_terminal_id'); }
}

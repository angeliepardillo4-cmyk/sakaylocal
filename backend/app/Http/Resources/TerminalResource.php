<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class TerminalResource extends JsonResource { public function toArray(Request $request): array { return ['id'=>$this->id,'name'=>$this->name,'place'=>$this->place,'status'=>$this->status,'wait_minutes'=>$this->wait_minutes,'capacity'=>$this->capacity,'queue_count'=>$this->whenCounted('queueEntries'),'created_at'=>$this->created_at]; } }

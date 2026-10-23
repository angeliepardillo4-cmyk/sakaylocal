<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class QueueEntryResource extends JsonResource { public function toArray(Request $request): array { return ['id'=>$this->id,'ticket_number'=>$this->ticket_number,'status'=>$this->status,'terminal'=>new TerminalResource($this->whenLoaded('terminal')),'user'=>$this->whenLoaded('user')?['id'=>$this->user->id,'name'=>$this->user->name,'email'=>$this->user->email]:null,'created_at'=>$this->created_at]; } }

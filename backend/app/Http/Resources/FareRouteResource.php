<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class FareRouteResource extends JsonResource { public function toArray(Request $request): array { return ['id'=>$this->id,'origin_terminal_id'=>$this->origin_terminal_id,'destination_terminal_id'=>$this->destination_terminal_id,'origin'=>new TerminalResource($this->whenLoaded('origin')),'destination'=>new TerminalResource($this->whenLoaded('destination')),'fare'=>$this->fare,'status'=>$this->status]; } }

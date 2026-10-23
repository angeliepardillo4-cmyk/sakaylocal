<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class FareRouteRequest extends FormRequest {
    public function authorize(): bool { return $this->user()?->isAdmin() ?? false; }
    public function rules(): array { return ['origin_terminal_id'=>['required','integer','exists:terminals,id',Rule::notIn([$this->input('destination_terminal_id')])],'destination_terminal_id'=>['required','integer','different:origin_terminal_id','exists:terminals,id'],'fare'=>['required','numeric','min:0','max:99999.99'],'status'=>['required','in:approved,pending']]; }
}

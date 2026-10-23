<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class TerminalRequest extends FormRequest {
    public function authorize(): bool { return $this->user()?->isAdmin() ?? false; }
    public function rules(): array { return ['name'=>['required','string','max:120'],'place'=>['required','string','max:180'],'status'=>['required','in:active,inactive'],'wait_minutes'=>['required','integer','min:0','max:240'],'capacity'=>['required','integer','min:1','max:1000']]; }
}

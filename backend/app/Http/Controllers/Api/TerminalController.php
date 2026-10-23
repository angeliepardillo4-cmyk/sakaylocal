<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\TerminalRequest;
use App\Http\Resources\TerminalResource;
use App\Models\Terminal;
use Illuminate\Http\Request;
class TerminalController extends Controller {
    public function index(Request $request){ $q=Terminal::withCount('queueEntries'); if($request->filled('search')) $q->where(fn($s)=>$s->where('name','like','%'.$request->search.'%')->orWhere('place','like','%'.$request->search.'%')); if($request->filled('status')) $q->where('status',$request->status); return TerminalResource::collection($q->orderByDesc('created_at')->orderByDesc('id')->paginate(min(max((int)$request->input('per_page',8),1),50))); }
    public function store(TerminalRequest $request){ return (new TerminalResource(Terminal::create($request->validated())))->response()->setStatusCode(201); }
    public function show(Terminal $terminal){ return new TerminalResource($terminal->loadCount('queueEntries')); }
    public function update(TerminalRequest $request, Terminal $terminal){ $terminal->update($request->validated()); return new TerminalResource($terminal->fresh()->loadCount('queueEntries')); }
    public function destroy(Terminal $terminal){ $terminal->delete(); return response()->noContent(); }
}

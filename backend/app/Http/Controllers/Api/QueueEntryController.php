<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\QueueEntryRequest;
use App\Http\Requests\QueueStatusRequest;
use App\Http\Resources\QueueEntryResource;
use App\Models\QueueEntry;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class QueueEntryController extends Controller {
    public function index(Request $request){ $q=QueueEntry::with(['terminal','user']); if(!$request->user()->isAdmin()) $q->where('user_id',$request->user()->id); if($request->filled('search')) $q->where(fn($s)=>$s->where('ticket_number','like','%'.$request->search.'%')->orWhereHas('terminal',fn($t)=>$t->where('name','like','%'.$request->search.'%'))); if($request->filled('status')) $q->where('status',$request->status); return QueueEntryResource::collection($q->latest()->paginate(10)); }
    public function store(QueueEntryRequest $request){ $terminal=Terminal::findOrFail($request->validated('terminal_id')); abort_if($terminal->status!=='active',422,'This terminal is not accepting queue entries.'); $entry=QueueEntry::create(['user_id'=>$request->user()->id,'terminal_id'=>$terminal->id,'ticket_number'=>strtoupper(Str::random(3)).'-'.Str::upper(Str::random(5))]); return (new QueueEntryResource($entry->load(['terminal','user'])))->response()->setStatusCode(201); }
    public function show(Request $request,QueueEntry $queueEntry){ abort_unless($request->user()->isAdmin() || $queueEntry->user_id===$request->user()->id,403); return new QueueEntryResource($queueEntry->load(['terminal','user'])); }
    public function update(QueueStatusRequest $request,QueueEntry $queueEntry){ $data=$request->validated(); abort_unless($request->user()->isAdmin() || ($queueEntry->user_id===$request->user()->id && $data['status']==='cancelled' && $queueEntry->status==='pending'),403); $allowed=['pending'=>['approved','cancelled'],'approved'=>['completed','cancelled'],'completed'=>[],'cancelled'=>[]]; abort_unless(in_array($data['status'],$allowed[$queueEntry->status]??[],true),422,'Invalid queue status transition.'); $queueEntry->update(['status'=>$data['status']]); return new QueueEntryResource($queueEntry->fresh()->load(['terminal','user'])); }
    public function destroy(Request $request,QueueEntry $queueEntry){ abort_unless($request->user()->isAdmin() || ($queueEntry->user_id===$request->user()->id && $queueEntry->status==='pending'),403); $queueEntry->delete(); return response()->noContent(); }
}

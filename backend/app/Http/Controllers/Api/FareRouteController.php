<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\FareRouteRequest;
use App\Http\Resources\FareRouteResource;
use App\Models\FareRoute;
use Illuminate\Http\Request;
class FareRouteController extends Controller {
    public function index(Request $request){ $q=FareRoute::with(['origin','destination']); if($request->filled('search')) $q->where(fn($s)=>$s->whereHas('origin',fn($t)=>$t->where('name','like','%'.$request->search.'%'))->orWhereHas('destination',fn($t)=>$t->where('name','like','%'.$request->search.'%'))); if($request->filled('status')) $q->where('status',$request->status); return FareRouteResource::collection($q->orderBy('id','desc')->paginate(min(max((int)$request->input('per_page',8),1),50))); }
    public function store(FareRouteRequest $request){ return (new FareRouteResource(FareRoute::create($request->validated())->load(['origin','destination'])))->response()->setStatusCode(201); }
    public function show(FareRoute $fareRoute){ return new FareRouteResource($fareRoute->load(['origin','destination'])); }
    public function update(FareRouteRequest $request,FareRoute $fareRoute){ $fareRoute->update($request->validated()); return new FareRouteResource($fareRoute->fresh()->load(['origin','destination'])); }
    public function destroy(FareRoute $fareRoute){ $fareRoute->delete(); return response()->noContent(); }
}

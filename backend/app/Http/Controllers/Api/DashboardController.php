<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\FareRoute;
use App\Models\QueueEntry;
use App\Models\Terminal;
use Illuminate\Http\Request;
class DashboardController extends Controller {
    public function __invoke(Request $request){ $q=QueueEntry::query(); if(!$request->user()->isAdmin()) $q->where('user_id',$request->user()->id); return response()->json(['terminals'=>Terminal::where('status','active')->count(),'fare_routes'=>FareRoute::where('status','approved')->count(),'queue_entries'=>(clone $q)->count(),'pending_queue_entries'=>(clone $q)->where('status','pending')->count(),'completed_this_week'=>(clone $q)->where('status','completed')->where('updated_at','>=',now()->startOfWeek())->count()]); }
}

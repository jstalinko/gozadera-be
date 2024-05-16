<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Casts\Json;

class EventController extends Controller
{
    public function eventCategory(Request $request): JsonResponse
    {
        $event = Event::where('type', $request->category)->get();
        $dateNow = date('Y-m-d H:i:s');
        foreach ($event as $key => $value) {
            if ($value->start_date > $dateNow) {
                $event[$key]->status = 'upcoming';
            } else if ($value->start_date <= $dateNow && $value->end_date >= $dateNow) {
                $event[$key]->status = 'ongoing';
            } else {
                $event[$key]->status = 'finished';
            }
        }
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Event list',
            'data' => $event
        ]);
    }

    public function events(): JsonResponse
    {
        $event = Event::all();
        $dateNow = date('Y-m-d H:i:s');
        foreach ($event as $key => $value) {
            if ($value->start_date > $dateNow) {
                $event[$key]->status = 'upcoming';
            } else if ($value->start_date <= $dateNow && $value->end_date >= $dateNow) {
                $event[$key]->status = 'ongoing';
            } else {
                $event[$key]->status = 'finished';
            }
        }
        // skip $status finished
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Event list',
            'data' => $event
        ]);
    }

    public function gallery(Request $request): JsonResponse
    {
        $gallery = Gallery::where('event_id', $request->event_id)->with('event')->get();
        $event = Event::find($request->event_id);
        if ($event) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Gallery',
                'data' => $gallery,
                'event' => $event
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'Gallery not found',
                'data' => []
            ]);
        }
    }
}

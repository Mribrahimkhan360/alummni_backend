<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function latest()
    {
        $events = Event::where('is_active', true)
            ->whereNotNull('event_date')
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $events,
        ]);
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        $event = Event::create([
            'title'         => $data['title'],
            'description'   => $data['description'] ?? null,
            'venue'         => $data['venue'],
            'entertainment' => $data['entertainment'] ?? null,
            'dietary_info'  => $data['dietary_info'] ?? null,
            'ticket_prices' => $data['ticket_prices'] ?? null,
            'image'         => $imagePath,
            'event_date'    => $data['event_date'] ?? null,
            'event_time'    => $data['event_time'] ?? null,
        ]);

        return response()->json([
            'message' => 'Event created Successfully',
            'data'    => $event,
        ], 201);
    }

    public function stats()
    {
        $total = Event::count();
        $active = Event::where('is_active', true)->count();
        $revenue = Event::whereNotNull('ticket_prices')
            ->where('ticket_prices', '!=', '')
            ->where('ticket_prices', '!=', 'Free')
            ->get()->sum(fn($e) => (float) $e->ticket_prices);
        $thisMonth = Event::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_events' => $total,
                'active_events' => $active,
                'total_revenue' => $revenue,
                'this_month_events' => $thisMonth,
            ],
        ]);
    }

    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 10;
        $events = Event::latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $events->items(),
            'meta' => [
                'current_page' => $events->currentPage(),
                'last_page' => $events->lastPage(),
                'per_page' => $events->perPage(),
                'total' => $events->total(),
            ],
        ]);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json([
            'message' => 'Event retrieved successfully',
            'data'    => $event,
        ]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'venue'         => 'required|string',
            'entertainment' => 'nullable',
            'dietary_info'  => 'nullable|string',
            'ticket_prices' => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'     => 'nullable|boolean',
            'event_date'    => 'nullable|date',
            'event_time'    => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->image);
            }
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return response()->json([
            'message' => 'Event updated successfully',
            'data'    => $event,
        ]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully',
        ]);
    }
}

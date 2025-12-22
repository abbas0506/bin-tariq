<?php
// app/Http/Controllers/EventController.php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'detail' => 'nullable|string',
            'event_date' => 'required|date',
            'category' => 'required|in:sports,annual day,prize distribution,competition',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('events', 'public');
            $data['photo'] = $path; // assign to $data array
        }

        Event::create($data);
        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'detail' => 'nullable|string',
            'category' => 'required|in:sports,annual day,prize distribution,competition',
            'event_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($event->photo && Storage::disk('public')->exists($event->photo)) {
                Storage::disk('public')->delete($event->photo);
            }

            $data['photo'] = $request->file('photo')->store('events', 'public');
        }

        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        // Delete photo
        if ($event->photo && Storage::disk('public')->exists($event->photo)) {
            Storage::disk('public')->delete($event->photo);
        }

        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}

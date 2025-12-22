<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::latest()->paginate(10);
        return view('admin.alumni.index', compact('alumni'));
    }

    public function create()
    {
        return view('alumni.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'prefix' => 'nullable|string|max:10',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'session' => 'nullable|string',
            'introduction' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('alumni', 'public');
        }

        Alumni::create($data);
        return redirect()->route('admin.alumni.index')->with('success', 'Alumni added successfully.');
    }

    public function edit($id)

    {
        $alumni = Alumni::findOrFail($id);
        return view('admin.alumni.edit', compact('alumni'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:100',
            'session' => 'nullable|string',
            'introduction' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $alumni = Alumni::findOrFail($id);

        try {
            if ($request->hasFile('photo')) {
                if ($alumni->photo && Storage::disk('public')->exists($alumni->photo)) {
                    Storage::disk('public')->delete($alumni->photo);
                }
                $data['photo'] = $request->file('photo')->store('alumni', 'public');
            }

            $alumni->update($data);
            return redirect()->route('admin.alumni.index')->with('success', 'Alumni updated successfully.');
        } catch (Exception $ex) {
            return back()->with('warning', $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        if ($alumni->photo && Storage::disk('public')->exists($alumni->photo)) {
            Storage::disk('public')->delete($alumni->photo);
        }

        $alumni->delete();
        return redirect()->route('admin.alumni.index')->with('success', 'Alumni deleted.');
    }
}

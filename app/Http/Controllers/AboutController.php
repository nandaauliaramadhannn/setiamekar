<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::orderBy('order')->get();
        return view('backend.about.index', compact('about'));
    }

    public function create()
    {
        return view('backend.about.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title'   => 'required|string|max:255',
        'content' => 'required|string',
        'order'   => 'nullable|integer',
    ]);

    try {
        About::create([
            'title'   => $request->title,
            'content' => $request->content,
            'order'   => $request->order ?? 0,
        ]);

        Alert::toast('Section added successfully!', 'success')->position('top-end');
        return redirect()->route('admin.backend.about.index');
    } catch (\Exception $e) {
        Alert::toast('Failed to save data: ' . $e->getMessage(), 'error')->position('top-end');
        return back()->withInput();
    }
}
public function edit($id)
{
    $data = About::findOrFail($id);
    return view('backend.about.edit', compact('data'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'order' => 'nullable|integer',
    ]);

    try {
        $section = About::findOrFail($id);
        $section->update([
            'title' => $request->title,
            'content' => $request->content,
            'order' => $request->order,
        ]);

        Alert::toast('Section updated successfully!', 'success');
        return redirect()->route('admin.backend.about.index');
    } catch (\Exception $e) {
        Alert::toast('Failed to update section: ' . $e->getMessage(), 'error');
        return back();
    }
}
public function destroy($id)
{
    try {
        $section = About::findOrFail($id);
        $section->delete();

        Alert::toast('Section deleted successfully!', 'success');
        return redirect()->route('admin.backend.about.index');
    } catch (\Exception $e) {
        Alert::toast('Failed to delete section: ' . $e->getMessage(), 'error');
        return back();
    }
}
}

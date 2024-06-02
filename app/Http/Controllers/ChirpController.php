<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChirpRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->paginate(4),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChirpRequest $request): RedirectResponse
{
    $validated = $request->validated();

    // Retrieve the image path from the request
    $imagePath = $request->input('image_path');

    // Construct the message with the image URL
    $message = $validated['message'];
    if ($imagePath) {
        $message .= '<br><img src="' . $imagePath . '">';
    }

    // Truncate the message to fit within the column's length limit
    $message = substr($message, 0, 255); // Adjust the length as per your column definition

    // Store the message and other validated data
    $validated['message'] = $message;

    // Create the chirp
    $request->user()->chirps()->create($validated);

    return redirect(route('chirps.index'))->with('success', 'Chirp created');
}




    /**
     * Handle image upload.
     */
    public function upload(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Store the image
    $path = $request->file('image')->store('public/images');
    $url = Storage::url($path);

    // Get content from the rich text editor
    $content = $request->input('content');

    // Remove OBJECT REPLACEMENT CHARACTER from content
    $content = str_replace('￼', '', $content);

    // Update the content in the request
    $request->merge(['content' => $content]);

    return response()->json(['url' => $url], 200);
}

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        Gate::authorize('update', $chirp);

        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreChirpRequest $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);

        $validated = $request->validated();
        $chirp->update($validated);

        return redirect(route('chirps.index'))->with('success', 'chirp updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'))->with('success', "chirp deleted");
    }
}

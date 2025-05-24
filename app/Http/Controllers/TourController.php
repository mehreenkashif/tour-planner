<?php

namespace App\Http\Controllers;

use App\Http\Requests\TourRequest;
use App\Models\Tour;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        $tours = Tour::with(['images', 'creator'])
            ->when($user->role === 'tour_planner', fn ($q) => $q->where('created_by', $user->id))
            ->get();

        return view('tours.index', compact('tours'));
    }

    public function create()
    {
        $this->authorizeRole(['admin', 'tour_planner']);
        return view('tours.create');
    }

    public function store(TourRequest $request)
    {
        $this->authorizeRole(['admin', 'tour_planner']);
        $tour = Auth::user()->tours()->create($request->validated());
        $this->uploadImages($tour, $request);

        return redirect()->route('tours.index')->with('success', 'Tour created successfully!');
    }

    public function show(string $id)
    {
        $tour = Tour::with('creator')->findOrFail($id);
        return view('tours.show', compact('tour'));
    }

    public function edit(string $id)
    {
        $tour = Tour::with('images')->findOrFail($id);
        $this->authorizeEdit($tour);
        return view('tours.create', compact('tour'));
    }

    public function update(TourRequest $request, string $id)
    {
        $tour = Tour::with('images')->findOrFail($id);
        $this->authorizeEdit($tour);

        $tour->update($request->validated());

        // Delete selected images if any
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $tour->images->find($imageId);
                if ($image) {
                    $image->delete();
                }
            }
        }
        // Upload newly added images
        $this->uploadImages($tour, $request);

        return redirect()->route('tours.index')->with('success', 'Tour updated successfully!');
    }

    public function destroy(string $id)
    {
        $tour = Tour::findOrFail($id);
        $this->authorizeEdit($tour);
        $tour->delete();

        return redirect()->route('tours.index')->with('success', 'Tour deleted successfully!');
    }

    private function authorizeRole(array $roles)
    {
        abort_unless(in_array(Auth::user()->role, $roles), 403);
    }

    private function authorizeEdit(Tour $tour)
    {
        $user = Auth::user();
        abort_unless(
            $user->role === 'admin' || ($user->role === 'tour_planner' && $tour->created_by === $user->id),
            403
        );
    }

    private function uploadImages(Tour $tour, Request $request): void
    {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $tour->images()->create(['image_path' => $path]);
            }
        }
    }
}

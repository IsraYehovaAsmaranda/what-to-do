<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'most_recent');
        $ideas = Idea::withCount('ratings');

        switch ($sort) {
            case "most_recent":
                $ideas = $ideas->orderBy('created_at', 'desc');
                break;
            case "most_ratings":
                $ideas = $ideas->orderBy('ratings_count', 'desc');
                break;
        }
        $ideas = $ideas->paginate(6);
        foreach ($ideas as $idea) {
            $averageRating = $idea->ratings->avg('rating');
            $idea->average_rating = round($averageRating, 1);
        }
        return view('pages.home', compact('ideas', 'sort'));
    }

    public function giveRating(Request $request)
    {
        request()->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

        try {
            $idea = Idea::findOrFail($request->ideaId);

            if ($idea->ratings->where('user_id', Auth::id())->count() > 0) {
                return redirect()->back()->withErrors('You have already rated this idea!');
            }

            $rating = Rating::create([
                'idea_id' => $request->ideaId,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
            ]);

            return redirect()->back()->with('success', 'Rating given successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function deleteIdea(string $id)
    {
        try {
            $idea = Idea::findOrFail($id);

            if ($idea->user_id == Auth::id()) {
                $idea->delete();
                return redirect()->back()->with('success', 'Idea deleted successfully!');
            }

            return redirect()->back()->withErrors('You cannot delete this idea!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Failed to delete idea!');
        }
    }
}

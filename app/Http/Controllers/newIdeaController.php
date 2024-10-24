<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class newIdeaController extends Controller
{
    public function index()
    {
        return view('pages.ideas.postidea');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:2000',
        ]);

        // Save the idea to the database
        try {
            $idea = Idea::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => Auth::id(),
            ]);

            return redirect('/')->with('success', 'Idea posted successfully!');

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('An error occurred while posting your idea. Please try again.');
        }
    }
}

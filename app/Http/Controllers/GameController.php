<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;

class GameController extends Controller
{
    // Get the leaderboard
    public function getLeaderboard()
    {
        $leaderboard = Score::orderBy('score', 'desc')->take(10)->get();
        return response()->json($leaderboard, 200);
    }

    // Save score to the leaderboard
    public function saveScore(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'score' => 'required|integer',
        ]);

        $score = new Score();
        $score->username = $validatedData['username'];
        $score->score = $validatedData['score'];
        $score->save();

        return response()->json(['message' => 'Score saved successfully!'], 201);
    }
}

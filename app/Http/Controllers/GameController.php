<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;

class GameController extends Controller
{
    public function index(User $user)
    {
        $games = $user->games()->get();
        return response()->json([
            'data' => $games
        ]);
    }

    public function store(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'dice1' => 'required|integer|between:1,6',
            'dice2' => 'required|integer|between:1,6',
            'won' => 'required|boolean',
        ]);

        $game = new Game;
        $game->dice1 = $validatedData['dice1'];
        $game->dice2 = $validatedData['dice2'];
        $game->won = $validatedData['won'];
        $game->user_id = $user->id;
        $game->save();

        return response()->json([
            'message' => 'Game created successfully',
            'data' => $game
        ], 201);
    }

    public function show(User $user, Game $game)
    {
        if ($game->user_id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'data' => $game
        ]);
    }

    public function destroy(User $user)
    {
        $user->games()->delete();

        return response()->json([
            'message' => 'Games deleted successfully'
        ]);
    }
}

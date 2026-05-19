<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game; 

class GameController extends Controller
{
    public function collection()
    {
        $games = Game::latest()->paginate(12); 
        return view('games', compact('games'));
    }
    
}
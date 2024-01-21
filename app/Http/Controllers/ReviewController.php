<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|integer',
            'user_id' => 'required|integer',
            'review' => 'required|string',
        ]);

        $review = Review::create([
            'event_id' => $request->input('event_id'),
            'user_id' => $request->input('user_id'),
            'review' => $request->input('review'),
        ]);

        return response()->json(['message' => 'Review added successfully', 'review' => $review], 201);
    }
}

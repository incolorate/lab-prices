<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

use Illuminate\Http\Request;

class Harvest extends Controller
{
    public function index()
    {
        return Inertia::render('Harvest');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'data' => 'required|array',
            // Add more validation rules as needed
        ]);



        // Return a response
        return response()->json(['message' => 'Data received successfully'], 200);
    }
}

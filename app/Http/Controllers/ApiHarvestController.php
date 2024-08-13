<?php

namespace App\Http\Controllers;
use App\Models\Source;
use App\Models\Category;
use Illuminate\Http\Request;

class ApiHarvestController extends Controller
{
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'source' => 'required|string',
            'website' => 'required|url',
            'data' => 'required|array',
            'data.*.test' => 'required|string',
            'data.*.price' => 'required|string',
            'data.*.category' => 'required|string',
        ]);

        
        Source::firstOrCreate(
            ['name' => $validated['source']],
            ['website' => $validated['website']]
        );

        foreach ($validated['data'] as $item) {
            $category = Category::firstOrCreate(
                ['name' => $item['category']]
            );
        
  
        }
dd($validated);
        // Handle the request and return a response
        return response()->json(['message' => 'Harvest data received successfully']);
    }
}
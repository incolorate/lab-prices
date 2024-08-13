<?php

namespace App\Http\Controllers;
use App\Models\Source;
use App\Models\Category;
use App\Models\Test;
use App\Models\Synonym;

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
            'data.*.price' => 'required|numeric',
            'data.*.category' => 'required|string',
        ]);

        $source = Source::firstOrCreate(
            ['name' => $validated['source']],
            ['website' => $validated['website']]
        );

        foreach ($validated['data'] as $item) {
            $category = Category::firstOrCreate(
                ['name' => $item['category']]
            );

            $testExists = Test::where('name', $item['test'])->exists();
            $synonymExists = Synonym::where('name', $item['test'])->exists();

            if ($synonymExists) {
                $synonym = Synonym::where('name', $item['test'])->first();
                $item['test'] = Test::find($synonym->test_id)->name;
            }


            if (!$testExists && !$synonymExists) {
                $test = Test::create([
                    'name' => $item['test'],
                    'category_id' => $category->id
                ]);
                Synonym::create([
                    'name' => $item['test'],
                    'test_id' => $test->id
                ]);
            } else {
                $test = Test::where('name', $item['test'])->first();
                if (!$test) {
                    $synonym = Synonym::where('name', $item['test'])->first();
                    $test = Test::find($synonym->test_id);
                }
            }

            // Check if the test already has the same price for the source
            $existingEntry = $source->tests()->where('test_id', $test->id)->wherePivot('price', $item['price'])->exists();

            if (!$existingEntry) {
                // Create an entry in the pivot table with the new price
                $source->tests()->attach($test->id, ['price' => $item['price']]);
            }
        }

        // Handle the request and return a response
        return response()->json(['message' => 'Harvest data received successfully']);
    }
}
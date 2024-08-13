<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Source;
use Carbon\Carbon; 
class HarvestController extends Controller
{
    public function index()
    {
        // Fetch data from the database
        $data = Test::with(['sources' => function($query) {
            $query->select('sources.id', 'sources.name', 'test_source_prices.price');
        }])->get(['id', 'name']);

        // Format the data to include source, price, and test name
        $formattedData = $data->map(function($test) {
            return $test->sources->map(function($source) use ($test) {
                return [
                    'test_name' => $test->name,
                    'source' => $source->name,
                    'price' => $source->pivot->price,
                    'timestamps' => $source->pivot->created_at->format('Y-m-d H')
                ];
            });
        })->flatten(1);

        // Pass data to Inertia
        return Inertia::render('Harvest', [
            'data' => $formattedData
        ]);
    }
}
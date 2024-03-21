<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $client = new Client();
        $apiKey = '5a3c4e6aa8690946e4534a57689222de'; // Replace with your TMDB API key

        try {
            // Make a GET request to TMDB API
            $response = $client->get('https://api.themoviedb.org/3/discover/movie', [
                'query' => [
                    'api_key' => $apiKey,
                    'page' => $request->query('page', 1) // Get current page number from query parameter
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            // Paginate the results
            $perPage = 100; // Number of results per page
            $currentPage = $request->query('page', 1);
            $items = $data['results'];
            $total = $data['total_results'];
            $movies = new LengthAwarePaginator($items, $total, $perPage, $currentPage, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);

            return view('movies.index', compact('movies'));
        } catch (\Exception $e) {
            return view('movies.index')->with('error', $e->getMessage());
        }
    }
}

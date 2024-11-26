<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function getReleases()
    {
        $token = env('GITHUB_PAT'); 
        $url = 'https://api.github.com/repos/hendrypk/bayaran-nih/releases';

        $response = Http::withHeaders([
            'Authorization' => "Bearer $token",
            'Accept' => 'application/vnd.github.v3+json',
        ])->get($url);

        if ($response->successful()) {
            return response()->json($response->json(), 200);
        } else {
            return response()->json(['error' => 'Failed to fetch releases'], $response->status());
        }
    }
}

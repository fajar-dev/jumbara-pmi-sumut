<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
{
    public function handle(Request $request)
    {
        $memberId = $request->input('memberId');

        if (!$memberId) {
            return response()->json(['error' => 'memberId is required'], 400);
        }

        $targetUrl = 'https://siamo.pmi.or.id/apimis/control/get_mis.php';

        $response = Http::get($targetUrl, [
            'memberId' => $memberId,
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Failed to fetch data'], $response->status());
        }
    }
}

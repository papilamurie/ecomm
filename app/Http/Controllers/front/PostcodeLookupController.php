<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostcodeLookupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function lookup($postcode)
    {
        // Sanitize and remove spaces - postcodes.io doesn't like spaces
        $postcode = strtoupper(str_replace(' ', '', trim($postcode)));

       // Use postcodes.io public API (no key needed)
        $url = "https://api.postcodes.io/postcodes/" . $postcode;

        $resp = Http::get($url);

        $json = $resp->json();

        // Handle invalid postcode (404)
        if ($resp->status() === 404) {
            return response()->json([
                'success' => false,
                'message' => 'Postcode not found. Please check the postcode and try again.',
            ], 200);
        }

        if (!$resp->ok()) {
            return response()->json([
                'success' => false,
                'message' => 'Lookup service temporarily unavailable',
            ], 200);
        }

        if (isset($json['status']) && $json['status'] === 200 && isset($json['result'])) {
            $r = $json['result'];

            // Choose fields to return; common useful ones:
            // Try admin_district first (e.g., "Liverpool"), then parish, town, district
            $city = $r['admin_district'] ?? $r['parish'] ?? $r['town'] ?? $r['district'] ?? $r['primary_care_trust'] ?? '';

            // County fallback chain
            // For metropolitan areas like Liverpool, Merseyside, etc., use pfa (Police Force Area) or admin_district
            // Otherwise use admin_county, county, or region
            $county = $r['admin_county'] ?? $r['pfa'] ?? $r['county'] ?? $r['admin_district'] ?? $r['region'] ?? '';

            return response()->json([
                'success' => true,
                'city' => $city,
                'county' => $county,
                'raw' => $r
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No results found',
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ShortenedUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class ShortenController extends Controller
{
    public function index()
    {
        $shortened_urls = ShortenedUrl::withTrashed()->get();

        return response()->json([
            'message' => 'Successfully retrieved shortened URLs.',
            'data' => $shortened_urls,
        ], 200);
    }

    public function show($id)
    {
        $shortened_url = ShortenedUrl::withTrashed()->find($id);
        if (!$shortened_url) {
            return response()->json([
                'message' => 'Shortened URL not found.',
            ], 404);
        }

        // Retrieve clicks
        $shortened_url->clicks = $shortened_url->clicks()->get();

        // Retrieve original URLs
        $shortened_url->urls = $shortened_url->urls()->get();

        return response()->json([
            'message' => 'Successfully retrieved shortened URL.',
            'data' => $shortened_url,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'urls' => 'required|array',
            'urls.*' => 'required|url',
            'max_clicks' => 'nullable|integer',
            'expired_at' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime(date('Y-m-d H:i:s'))) {
                        $fail('The ' . $attribute . ' must be greater than today\'s date.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $shortened_url = ShortenedUrl::create([
            'hash' => $this->generate_uuid(),
            'max_clicks' => $request->max_clicks,
            'expired_at' => $request->expired_at ? date('Y-m-d H:i:s', strtotime($request->expired_at)) : null,
        ]);

        foreach ($request->urls as $url) {
            $shortened_url->urls()->create([
                'url' => $url,
            ]);
        }

        return response()->json([
            'message' => 'Successfully shortened URL(s).',
            'data' => $shortened_url->only(['hash', 'max_clicks', 'expired_at', 'shortened_url']),
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $shortened_url = ShortenedUrl::withTrashed()->find($id);
        if (!$shortened_url) {
            return response()->json([
                'message' => 'Shortened URL not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'urls' => 'nullable|array',
            'urls.*' => 'required|url',
            'max_clicks' => 'nullable|integer',
            'expired_at' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime(date('Y-m-d H:i:s'))) {
                        $fail('The ' . $attribute . ' must be greater than today\'s date.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $shortened_url->update([
            'max_clicks' => $request->max_clicks,
            'expired_at' => $request->expired_at ? date('Y-m-d H:i:s', strtotime($request->expired_at)) : null,
        ]);

        if ($request->urls) {
            $shortened_url->urls()->delete();
            foreach ($request->urls as $url) {
                $shortened_url->urls()->create([
                    'url' => $url,
                ]);
            }
        }

        return response()->json([
            'message' => 'Successfully updated shortened URL.',
            'data' => $shortened_url->only(['hash', 'max_clicks', 'expired_at', 'shortened_url']),
        ], 200);
    }

    public function destroy($id)
    {
        $shortened_url = ShortenedUrl::withTrashed()->find($id);
        if (!$shortened_url) {
            return response()->json([
                'message' => 'Shortened URL not found.',
            ], 404);
        }

        $shortened_url->delete();

        return response()->json([
            'message' => 'Successfully deleted shortened URL.',
        ], 200);
    }

    public function restore($id)
    {
        $shortened_url = ShortenedUrl::withTrashed()->find($id);
        if (!$shortened_url) {
            return response()->json([
                'message' => 'Shortened URL not found.',
            ], 404);
        }

        $shortened_url->restore();

        return response()->json([
            'message' => 'Successfully restored shortened URL.',
        ], 200);
    }

    public function stats($hash)
    {
        $shortened_url = ShortenedUrl::withTrashed()->where('hash', '=', $hash)->first();
        if (!$shortened_url) {
            return response()->json([
                'message' => 'Shortened URL not found.',
            ], 404);
        }

        $clicks = $shortened_url->clicks()->get();
        $total_clicks = count($clicks);

        $unique_clicks = [];
        foreach ($clicks as $click) {
            if (!in_array($click->ip_address, $unique_clicks)) {
                $unique_clicks[] = $click->ip_address;
            }
        }
        $total_unique_clicks = count($unique_clicks);

        $qr_clicks = $clicks->where('referrer', '=', 'qr')->count();

        $unique_qr_clicks = [];
        foreach ($clicks as $click) {
            if ($click->referrer === 'qr' && !in_array($click->ip_address, $unique_qr_clicks)) {
                $unique_qr_clicks[] = $click->ip_address;
            }
        }
        $unique_qr_clicks = count($unique_qr_clicks);

        $clicks_by_os = $clicks->groupBy('operating_system')->map(function ($item, $key) {
            return count($item);
        });

        $clicks_by_browser = $clicks->groupBy('browser')->map(function ($item, $key) {
            return count($item);
        });

        $clicks_by_country = $clicks->groupBy('country')->map(function ($item, $key) {
            return count($item);
        });

        $analytics = [
            'total_clicks' => $total_clicks,
            'total_unique_clicks' => $total_unique_clicks,
            'qr_clicks' => $qr_clicks,
            'unique_qr_clicks' => $unique_qr_clicks,
            'clicks_by_os' => $clicks_by_os,
            'clicks_by_browser' => $clicks_by_browser,
            'clicks_by_country' => $clicks_by_country,
        ];

        return response()->json([
            'message' => 'Successfully retrieved shortened URL stats.',
            'data' => $analytics,
        ], 200);
    }

    private function generate_uuid()
    {
        $uuid = Uuid::uuid4();
        $short_uuid = substr($uuid->toString(), 0, 8);

        $is_exist = ShortenedUrl::withTrashed()->where('hash', '=', $short_uuid)->first();
        if (!$is_exist) return $short_uuid;

        return $this->generate_uuid();
    }
}

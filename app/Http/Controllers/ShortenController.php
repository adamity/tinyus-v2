<?php

namespace App\Http\Controllers;

use App\Models\ShortenedUrl;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;

class ShortenController extends Controller
{
    public function index()
    {
        die('TODO: Create a form to submit a URL to shorten');
    }

    public function show($hash)
    {
        $shortened_url = (new ShortenedUrl())->getByHash($hash);
        if (!$shortened_url) {
            die('TODO: Show a 404 page with a link to the homepage');
        }

        $user_info_and_location = $this->getUserInfoAndLocation();

        $shortened_url->clicks()->create([
            'referrer' => request()->query('ref'),
            'ip_address' => $user_info_and_location['ip_address'],
            'operating_system' => $user_info_and_location['operating_system'],
            'operating_system_version' => $user_info_and_location['operating_system_version'],
            'browser' => $user_info_and_location['browser'],
            'browser_version' => $user_info_and_location['browser_version'],
            'is_mobile' => $user_info_and_location['is_mobile'],
            'is_tablet' => $user_info_and_location['is_tablet'],
            'is_desktop' => $user_info_and_location['is_desktop'],
            'is_phone' => $user_info_and_location['is_phone'],
            'country' => $user_info_and_location['country'],
            'city' => $user_info_and_location['city'],
            'region' => $user_info_and_location['region'],
            'is_expired' => $shortened_url->hasExpired(),
        ]);

        if ($shortened_url->hasExpired()) {
            die('TODO: Show a page that says the link has expired');
        }

        $original_urls = $shortened_url->urls()->get();

        // If there is only one original URL, redirect to it
        if (count($original_urls) === 1) return redirect()->to($original_urls[0]->url);

        // If there are multiple original URLs, show a page with all of them
        foreach ($original_urls as $original_url) {
            echo '<a href="' . $original_url->url . '">' . $original_url->url . '</a><br>';
        }
    }

    private function getUserInfoAndLocation()
    {
        $agent = new Agent();
        $position = Location::get();

        return [
            'ip_address' => $position ? $position->ip : null,
            'operating_system' => $agent->platform() ?? 'Unknown',
            'operating_system_version' => $agent->version($agent->platform()) ?? 'Unknown',
            'browser' => $agent->browser() ?? 'Unknown',
            'browser_version' => $agent->version($agent->browser()) ?? 'Unknown',
            'is_mobile' => (int) $agent->isMobile(),
            'is_tablet' => (int) $agent->isTablet(),
            'is_desktop' => (int) $agent->isDesktop(),
            'is_phone' => (int) $agent->isPhone(),
            'country' => $position ? $position->countryName : 'Unknown',
            'city' => $position ? $position->cityName : 'Unknown',
            'region' => $position ? $position->regionName : 'Unknown',
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ShortenedUrl;
use Exception;
use GuzzleHttp\Client;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\DomCrawler\Crawler;

class ShortenController extends Controller
{
    public function index()
    {
        $navitem['home'] = 'active';
        return view('app', compact('navitem'));
    }

    public function stats()
    {
        $navitem['stats'] = 'active';
        return view('stats', compact('navitem'));
    }

    public function show($hash)
    {
        $shortened_url = (new ShortenedUrl())->getByHash($hash);
        if (!$shortened_url) return view('error');

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

        if ($shortened_url->hasExpired()) return view('error');
        $original_urls = $shortened_url->urls()->get();

        // If there is only one original URL, redirect to it
        if (count($original_urls) === 1) return redirect()->to($original_urls[0]->url);

        foreach ($original_urls as $original_url) {
            $original_url->preview = null;
            $preview = $this->getLinkPreview($original_url->url);
            if ($preview) $original_url->preview = $preview;
        }

        // If there are multiple original URLs, show a page with all of them
        return view('links', compact('original_urls'));
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

    private function getLinkPreview($url)
    {
        try {
            // Fetch the HTML of the URL
            $client = new Client();
            $response = $client->get($url);
            $html = $response->getBody()->getContents();
            $crawler = new Crawler($html);

            // Extract the title
            $title = '';
            if ($crawler->filter('meta[name="twitter:title"]')->count() > 0) {
                $title = $crawler->filter('meta[name="twitter:title"]')->attr('content');
            } else if ($crawler->filter('meta[property="og:title"]')->count() > 0) {
                $title = $crawler->filter('meta[property="og:title"]')->attr('content');
            } else if ($crawler->filter('head title')->count() > 0) {
                $title = $crawler->filter('head title')->first()->text();
            }

            // Extract the description
            $description = '';
            if ($crawler->filter('meta[name="description"]')->count() > 0) {
                $description = $crawler->filter('meta[name="description"]')->attr('content');
            } else if ($crawler->filter('meta[property="og:description"]')->count() > 0) {
                $description = $crawler->filter('meta[property="og:description"]')->attr('content');
            }

            // Extract the thumbnail
            $thumbnail = '';
            if ($crawler->filter('meta[name="twitter:image"]')->count() > 0) {
                $thumbnail = $crawler->filter('meta[name="twitter:image"]')->attr('content');
            } else if ($crawler->filter('meta[property="og:image"]')->count() > 0) {
                $thumbnail = $crawler->filter('meta[property="og:image"]')->attr('content');
            }

            // Check if any of the required elements are missing
            if (empty($title) || empty($description) || empty($thumbnail)) {
                throw new Exception('Unable to extract all required information.');
            }

            // Return the link preview
            return [
                'title' => $title,
                'description' => $description,
                'thumbnail' => $thumbnail,
                'favicon' => 'https://www.google.com/s2/favicons?domain=' . $url,
                'url' => $url,
            ];
        } catch (Exception $e) {
            // Handle errors (e.g., invalid URL, network issues)
            error_log('Error fetching link preview: ' . $e->getMessage());
            return null;
        }
    }
}

<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ArticleImageFinder {

    public function find($url, $cover)
    {
        $file_name = '';

        $img = $cover ?: $this->fetchFromUrl($url);

        if (! empty($img))
        {
            $extension = last(explode('.', $img));
            $file_name = substr(sha1($img), 0, 15) . '.' . $extension;

            $dir = substr($file_name, 0, 2);
            $path = storage_path('app/covers/' . $dir);
            $file_path = $path . '/' . $file_name;

            if (! is_dir($path))
            {
                mkdir($path);
            }

            if (! file_exists($file_path))
            {
                file_put_contents($file_path, file_get_contents($img));
            }
        }

        return $file_name;
    }

    private function fetchFromUrl($url)
    {
        try
        {
            $client = (new Client)->get($url);

            $crawler = new Crawler($client->getBody()->getContents());

            $url = $crawler->filter('meta[property="og:image"]')->attr('content');

            return preg_replace('/\?.*/', '', $url);
        }
        catch (\Exception $e)
        {
            return null;
        }
    }
}

<?php

namespace App\Services;

use Image;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ArticleImageFinder {

    public function find($url, $cover, $replace = false)
    {
        $file_name = '';

        $img = $cover ?: $this->fetchFromUrl($url);

        if (! empty($img))
        {
            $img = preg_replace('/\?.*/', '', $img);

            $extension = last(explode('.', $img));
            $file_name = substr(sha1($img), 0, 15) . '.' . $extension;

            $dir = substr($file_name, 0, 2);
            $path = storage_path('app/covers/' . $dir);
            $file_path = $path . '/' . $file_name;

            if (! is_dir($path))
            {
                mkdir($path);
            }

            if (! file_exists($file_path) || $replace)
            {
                file_put_contents($file_path, file_get_contents($img));

                $this->optimize($file_path);
            }
        }

        return $file_name;
    }

    public function optimize($file_path, $w = 960, $h = 540)
    {
        $img = Image::make($file_path)->fit($w, $h);

        $img->save($file_path);

        $optimizer = OptimizerChainFactory::create();

        $optimizer->optimize($file_path);

        $this->convert($file_path, $file_path);
    }

    private function fetchFromUrl($url)
    {
        try
        {
            $client = (new Client)->get($url);

            $crawler = new Crawler($client->getBody()->getContents());

            return $crawler->filter('meta[property="og:image"]')->attr('content');
        }
        catch (\Exception $e)
        {
            return null;
        }
    }

    public function convert($from, $to)
    {
        $command = 'convert '
                   . $from
                   . ' '
                   . '-sampling-factor 4:2:0 -strip -quality 65'
                   . ' '
                   . $to;

        return `$command`;
    }
}

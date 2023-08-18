<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class CrawlShopifyDataController extends Controller
{ 
    public function crawl()
    {
        $client = new Client();
    
        // Set the URL of the Shopify app page you want to crawl data from
        $url = 'https://www.bigcommerce.com/apps/categories/accounting-tax/';
    
        $response = $client->request('GET', $url);
    
        // Delay in seconds
        $delay = 5;
    
        // Introduce a delay of 5 seconds
        sleep($delay);
    
        // Perform data crawling operations
        $data = $this->parseData($response->getBody()->getContents());
    
        // Process the obtained data
        // ...
        // dd($data);
        if (!empty($data)) {
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Data not found'], 404);
        }
    }
    
    private function parseData($html)
    {
        $data = [];
    
        $crawler = new Crawler($html);
        // echo "HTML: " . $html . PHP_EOL;
        // Find the app name elements
        $appNameElements = $crawler->filter('a.breadcrumb-label');
    
        // $appNameElements->each(function (Crawler $element) use (&$data) {
        //     $appName = $element->text();
        //     $data[] = $appName;
        // });
    
        return $appNameElements;
    }
}
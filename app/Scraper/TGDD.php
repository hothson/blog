<?php

namespace App\Scraper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Product;

class TGDD
{

    public function scrape()
    {
        $url = 'https://www.thegioididong.com/dtdd';
        $client = new Client();
        $crawler = $client->request('GET', $url);
        
        $r = $crawler->filter('ul.homeproduct li.item')->each(
            function (Crawler $node) {
                
                $name = $node->filter('h3')->text();
                $price = $node->filter('.price strong')->text();
                $price = preg_replace('/\D/', '', $price);
                $wholeStar = $node->filter('.icontgdd-ystar')->count();
                $halfStar = $node->filter('.icontgdd-hstar')->count();
                $rate = $wholeStar + 0.5 * $halfStar;
                $product = new Product;
                $product->name = $name;
                $product->price = $price;
                $product->rate = $rate;
                $product->save();
            }
        );

    }
}
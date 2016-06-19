<?php
namespace pmill\MFP;

use GuzzleHttp\ClientInterface;

class CSRFToken
{
    /**
     * @param ClientInterface $httpClient
     * @return string
     */
    public function getToken(ClientInterface $httpClient)
    {
        $crawler = (new CrawlerFactory())->create($httpClient, 'https://www.myfitnesspal.com/account/login');
        return $crawler->filter('meta[name="csrf-token"]')->attr('content');
    }
}

<?php
namespace pmill\MFP;

use GuzzleHttp\ClientInterface;

class CrawlerFactory
{
    /**
     * @param ClientInterface $httpClient
     * @param $url
     * @param string $method
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function create(ClientInterface $httpClient, $url, $method = 'GET')
    {
        $response = $httpClient->request($method, $url);
        $body = $response->getBody()->getContents();

        return new \Symfony\Component\DomCrawler\Crawler($body);
    }
}

<?php
namespace pmill\MFP;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;

class Client
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var CookieJar
     */
    protected $cookies;

    /**
     * @var Auth
     */
    protected $authHelper;

    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient = null)
    {
        $this->httpClient = is_null($httpClient) ? $this->createHTTPClient() : $httpClient;
        $this->authHelper = new Auth();
        $this->authHelper->setHttpClient($this->httpClient);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getCurrentWeight()
    {
        $this->authHelper->login();

        $response = $this->httpClient->request('GET', 'https://api.myfitnesspal.com/v2/incubator/measurements?most_recent=true&type=weight', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$this->authHelper->getJwt(),
                'mfp-client-id' => 'mfp-main-js',
                'mfp-user-id' => $this->authHelper->getUserId(),
            ],
        ]);
        $body = $response->getBody()->getContents();

        $jsonBody = json_decode($body, true);
        if (is_null($jsonBody)) {
            throw new \Exception('Response is invalid json');
        }

        if (!isset($jsonBody['items']) || !is_array($jsonBody['items']) || count($jsonBody['items']) === 0) {
            throw new \Exception('Invalid response');
        }

        return $jsonBody['items'][0];
    }

    /**
     * @param $username
     * @param $password
     */
    public function setCredentials($username, $password)
    {
        $this->authHelper->setCredentials($username, $password);
    }

    /**
     * @return \GuzzleHttp\Client
     */
    protected function createHTTPClient()
    {
        $this->cookies = new CookieJar;

        $httpClient = new \GuzzleHttp\Client([
            'cookies' => $this->cookies,
            'base_uri' => '',
            'timeout' => 0,
            'allow_redirects' => true,
        ]);


        return $httpClient;
    }
}

<?php
namespace pmill\MFP;

use GuzzleHttp\ClientInterface;

class Auth
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var string
     */
    protected $jwt;

    /**
     * @throws \Exception
     */
    public function login()
    {
        $response = $this->httpClient->request('POST', 'https://www.myfitnesspal.com/account/login', [
            'form_params' => [
                'authenticity_token' => $this->getCSRFToken(),
                'username' => $this->username,
                'password' => $this->password,
                'remember_me' => 0,
            ],
        ]);
        $body = $response->getBody()->getContents();

        $this->userId = $this->fetchUserId($body);
        $this->jwt = $this->fetchAccessToken();
    }

    /**
     * @return string
     */
    public function getCSRFToken()
    {
        $helper = new CSRFToken();
        return $helper->getToken($this->httpClient);
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        if (is_null($this->userId)) {
            $this->login();
        }

        return $this->userId;
    }

    /**
     * @return string
     */
    public function getJwt()
    {
        if (is_null($this->jwt)) {
            $this->login();
        }

        return $this->jwt;
    }

    /**
     * @param $username
     * @param $password
     */
    public function setCredentials($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param ClientInterface $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param $body
     * @return mixed
     * @throws \Exception
     */
    protected function fetchUserId($body)
    {
        if (strstr($body, 'Incorrect username or password') !== false) {
            throw new \Exception('Incorrect username or password');
        }

        preg_match("/me\.API_USER_ID = '([0-9]+)';/", $body, $output);
        if (count($output) !== 2) {
            throw new \Exception('Could not determine user id');
        }

        return $output[1];
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function fetchAccessToken()
    {
        $response = $this->httpClient->request('GET', 'https://www.myfitnesspal.com/user/auth_token?refresh-true');
        $body = $response->getBody()->getContents();

        $jsonBody = json_decode($body, true);
        if (is_null($jsonBody)) {
            throw new \Exception('Response is invalid json');
        }

        return (string)$jsonBody['access_token'];
    }
}

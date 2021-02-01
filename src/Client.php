<?php


namespace RapigoCo\Rapigo;


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Utils;

class Client
{
    const SANDBOX_URL_BASE = 'https://test.rapigo.co/';
    const URL_BASE = 'https://www.rapigo.co/';
    const API_VERSION = 'v1';

    protected static $_sandbox = false;
    private $user;
    private $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @param false $status
     */
    public function sandboxMode($status = false)
    {
        self::$_sandbox = $status;
    }

    /**
     * @return GuzzleClient
     */
    public function client()
    {
        return new GuzzleClient([
            "base_uri" => $this->getBaseUrl()
        ]);
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        if(self::$_sandbox)
            return self::SANDBOX_URL_BASE;
        return self::URL_BASE;
    }

    public function getToken()
    {
        try{
            $response = $this->client()->post("api/token/",
                [
                    "headers" => [
                        "Content-Type" => "application/json"
                    ],
                    "json" => [
                        "username" => $this->user,
                        "password" => $this->password
                    ]
                ]);

            return self::responseJson($response);

        }catch (RequestException $exception){
            /*$message = self::getErrorMessage($exception->getMessage());*/
            throw new \Exception($exception->getMessage());
        }
    }

    public function validateAddress(array $params)
    {
        try{
            $response = $this->client()->post("api/".self::API_VERSION."/validate_address/",
                [
                    "headers" => [
                        "Content-Type" => "application/json",
                        "Authorization" => "Bearer " . $this->getToken()->access
                    ],
                    "json" => $params
                ]);

            return self::responseJson($response);

        }catch (RequestException $exception){
            /*$message = self::getErrorMessage($exception->getMessage());*/
            throw new \Exception($exception->getMessage());
        }
    }

    public function quoteEstimate(array $params)
    {
        try{
            $response = $this->client()->post("api/".self::API_VERSION."/estimate/",
                [
                    "headers" => [
                        "Content-Type" => "application/json",
                        "Authorization" => "Bearer " . $this->getToken()->access
                    ],
                    "json" => $params
                ]);

            return self::responseJson($response);

        }catch (RequestException $exception){
            /*$message = self::getErrorMessage($exception->getMessage());*/
            throw new \Exception($exception->getMessage());
        }
    }

    public function requestService(array $params)
    {
        try{
            $response = $this->client()->post("api/".self::API_VERSION."/request_service/",
                [
                    "headers" => [
                        "Content-Type" => "application/json",
                        "Authorization" => "Bearer " . $this->getToken()->access
                    ],
                    "json" => $params
                ]);

            return self::responseJson($response);

        }catch (RequestException $exception){
            /*$message = self::getErrorMessage($exception->getMessage());*/
            throw new \Exception($exception->getMessage());
        }
    }

    public function getServiceStatus($keyService)
    {
        try{
            $response = $this->client()->get("api/".self::API_VERSION."/get_service_status/",
                [
                    "headers" => [
                        "Content-Type" => "application/json",
                        "Authorization" => "Bearer " . $this->getToken()->access
                    ],
                    "query" => [
                        "key" => $keyService
                    ]
                ]);

            return self::responseJson($response);

        }catch (RequestException $exception){
            /*$message = self::getErrorMessage($exception->getMessage());*/
            throw new \Exception($exception->getMessage());
        }
    }

    public static function responseJson($response)
    {
        return Utils::jsonDecode(
            $response->getBody()->getContents()
        );
    }
}
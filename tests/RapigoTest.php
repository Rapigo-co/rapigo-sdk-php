<?php

use PHPUnit\Framework\TestCase;
use RapigoCo\Rapigo\Client;

class RapigoTest extends TestCase
{
    public $rapigo;

    protected function setUp()
    {
        $dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/../');
        $dotenv->load();
        $user = $_ENV['USER'];
        $password = $_ENV['PASSWORD'];

        $this->rapigo = new Client($user, $password);
        $this->rapigo->sandboxMode(true);
    }

    public function testAuth()
    {
        $response = $this->rapigo->getToken();
        var_dump($response);
    }


    public function testValidateAddress()
    {
        $params = [
            'address' => 'carrera 38A #25A-69'
        ];

        $response = $this->rapigo->validateAddress($params);
        var_dump($response);
    }

    public function testQuoteEstimate()
    {
        $params = array (
            'points' =>
                array (
                    array (
                        'address' => 'Carrera 18 #148-69',
                        'type' => 'point',
                        'description' => 'Recoger 2 paquetes',
                        'phone' => '3147445189',
                    ),
                    array (
                        'address' => 'Av 9 #104',
                        'type' => 'point',
                        'description' => 'Recoger 2 paquetes',
                        'phone' => '3147445189',
                    )
                )
        );

        $response = $this->rapigo->quoteEstimate($params);
        var_dump($response);
    }

    public function testRequestService()
    {
        $params = array (
            'city_id' => '1',
            'points' =>
                array (
                    array (
                        'address' => 'Carrera 18 #148-69',
                        'type' => 'point',
                        'description' => 'Recoger 2 paquetes',
                        'phone' => '3147445189',
                    ),
                    array (
                        'address' => 'Av 9 #104',
                        'type' => 'point',
                        'description' => 'Recoger 2 paquetes',
                        'phone' => '3147445189',
                    )
                )
        );

        $response = $this->rapigo->requestService($params);
        var_dump($response);
    }

    public function testGetServiceStatus()
    {
        $keyService = "0DBC6FDA";
        $response = $this->rapigo->getServiceStatus($keyService);
        var_dump($response);
    }
}
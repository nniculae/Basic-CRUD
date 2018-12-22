<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

class WebTestCaseBase extends WebTestCase
{
    /** @var Client */
    protected $client;

    protected function setUp()
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'niculae@zeelandnet.nl',
            'PHP_AUTH_PW' => 'parola-nicu',
        ]);

//        dump($this->client);die;
    }

}
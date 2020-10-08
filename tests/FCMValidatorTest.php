<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use LaravelFCM\Validator\FCMValidator;

class FCMValidatorTest extends FCMTestCase {

    public function testValidateToken()
    {
        $response = new Response(
            200,
            [],
            json_encode([])
        );

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')->once()->andReturn($response);

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMValidator($client, 'http://test.test', $logger);
        $validated = $fcm->validateToken('token1');

        $this->assertTrue($validated);
    }

    public function testValidateTokenInvalid()
    {
        $response = new Response(
            404,
            [],
            json_encode([])
        );

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')->once()->andReturn($response);

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMValidator($client, 'http://test.test', $logger);
        $validated = $fcm->validateToken('token1');

        $this->assertFalse($validated);
    }
}

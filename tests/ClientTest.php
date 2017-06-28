<?php


class ClientTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function get_price_method()
    {
        $dummyProduct = [
            'weight' => 100,
            'price' => 1000,
            'state' => 1, // Tehran <3
            'city' => 1, // Tehran <3
            'tip' => 0, // Sefareshi
            'cod' => 0, // With COD
        ];

        $client = new \Bdok\PostGateway\Client('123', $http = \Mockery::mock('GuzzleHttp\Client'));

        $http->shouldReceive('request')->once()->with('POST', 'post.php', \Mockery::on(function(&$data) {
            if (!is_array($data)) return false;
            return true;
        }))->andReturn(
            $response = Mockery::mock('GuzzleHttp\Psr7\Response')
        );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn('{"status":true,"message":{"data":"36770;26770;3309"}}');

        $res = $client->getPrice($dummyProduct);
        $this->assertEquals($res, ['36770', '26770', '3309']);
    }


    //@todo this test needs improve!, Test buildDataString() on new Order!
    /** @test */
    public function new_order_method()
    {
        $fakeOrder = [
            'customerPhone' => '09125076324',
            'reference' => '123456',
            'state' => 1,
            'city' => 1,
            'names' => 'عروسک خرس مهربون',
            'weight' => 250,
            'price' => 15000,
            'shipment' => 0, // Sefareshi
            'payment' => 0, // COD
            'customerName' => 'علیرضا فغانی',
            'address' => 'پاسداران گلستان اول در قهوه ای پلاک 0',
            'postalCode' => 1234567890,
            'customerEmail' => 'faghani.a@gmail.com',
        ];

        $client = new \Bdok\PostGateway\Client('123', $http = \Mockery::mock('GuzzleHttp\Client'));

        $http->shouldReceive('request')->once()->with('POST', 'post.php', \Mockery::on(function(&$data) {
            if (!is_array($data)) return false;
            return true;
        }))->andReturn(
            $response = Mockery::mock('GuzzleHttp\Psr7\Response')
        );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->twice()->andReturn('{"status":true,"message":{"data":"36770;26770;3309"}}');
        $response->shouldReceive('getBody')->twice()->andReturn('{"status":true,"message":{"data":"1^12345678901234567890^123456^36770^100"}}'); // @todo the last item in data is tax, whats tax?

        $res = $client->newOrder($fakeOrder);

        // assert: Tracking number
        $this->assertEquals($res[1], '12345678901234567890');
    }

    /** @test */
    public function change_state_method()
    {
        $client = new \Bdok\PostGateway\Client('123', $http = \Mockery::mock('GuzzleHttp\Client'));

        $http->shouldReceive('request')->once()->with('POST', 'post.php', \Mockery::on(function(&$data) {
            if (!is_array($data)) return false;
            return true;
        }))->andReturn(
            $response = Mockery::mock('GuzzleHttp\Psr7\Response')
        );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn('{"status":true,"message":{"data":{"status":true}}}');

        $res = $client->changeState(12345678901234567890, 1);
        $this->assertTrue($res);

        try {
            $client->changeState(12345678901234567890, 33);
        } catch (\Bdok\PostGateway\Exceptions\ValidationException $e) {
            $this->assertEquals($e->getMessage(), 'The given data failed to pass validation.');
            return;
        }
    }
}
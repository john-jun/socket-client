<?php
declare(strict_types=1);
namespace Air\SocketClient\Test;

use Air\SocketClient\Exception\SocketException;
use Air\SocketClient\NetAddress\TcpNetAddress;
use Air\SocketClient\Socket;
use PHPUnit\Framework\TestCase;

class SocketTest extends TestCase
{
    public function testConnect()
    {
        $socket = new Socket(new TcpNetAddress('dev-restful.moftech.net', 443, true));

        try {
            $socket->connect();
            echo PHP_EOL . $socket->getConnectUseTime() . PHP_EOL;

            $http = "GET /social/poster/share/xx HTTP/1.1\r\n";
            $http .= "Host: dev-internal-restful.moftech.net\r\n";
            $http .= "Accept: */*\r\n";
            $http .= "User-Agent: " . PHP_VERSION . "\r\n";
            $http .= "Connection: keep-alive\r\n\r\n";

            $i = 0;
            while ($i < 1) {
                echo ($socket->send($http)) . PHP_EOL;

                $j = 0;
                while ($j < 1) {
                    var_dump($socket->recv(1024));
                    $j++;
                }
                $i++;
            }
        } catch (\Exception $e) {
            $this->assertInstanceOf(SocketException::class, $e);
        }

    }
}
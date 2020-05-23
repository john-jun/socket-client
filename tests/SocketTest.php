<?php
declare(strict_types=1);
namespace Air\Socket\Client\Test;

use Air\Socket\Client\NetAddress\TcpNetAddress;
use Air\Socket\Client\NetAddress\TlsNetAddress;
use Air\Socket\Client\Socket;
use PHPUnit\Framework\TestCase;

class SocketTest extends TestCase
{
    public function testConnect()
    {
        $socket = new Socket(new TcpNetAddress('dev-internal-restful.moftech.net', 80));
        $socket->connect(3);

        $http = "GET /social/poster/share/xx HTTP/1.1\r\n";
        $http .= "Host: dev-internal-restful.moftech.net\r\n";
        $http .= "Accept: */*\r\n";
        $http .= "User-Agent: " . PHP_VERSION . "\r\n";
        $http .= "Connection: keep-alive\r\n\r\n";

        $i = 0;
        while ($i < 1) {
            var_dump($socket->send($http, 0.00001));
            var_dump($socket->send($http, 0.00001));

            $j = 0;
            while ($j < 2) {
                var_dump($socket->recv(65535, 1));
                $j++;
            }
            $i++;
        }
    }
}
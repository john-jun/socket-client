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
        $socket = new Socket(new TlsNetAddress('dev-restful.moftech.net', 443));
        $socket->connect();

        $http = "GET /social HTTP/1.1\r\n";
        $http .= "Host: dev-restful.moftech.net\r\n";
        $http .= "Accept: text/plant\r\n";
        $http .= "User-Agent: Tiger Api\r\n";
        $http .= "Connection: keep-alive\r\n\r\n";

        $i = 0;
        while ($i < 1) {
            var_dump($socket->send($http));
            var_dump($socket->send($http));

            sleep(3);
            var_dump($socket->recv(65535));

            $i++;
        }
    }
}
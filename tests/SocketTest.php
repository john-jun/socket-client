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
        try {
            $socket->connect(1);
            echo PHP_EOL . $socket->getConnectUseTime() . PHP_EOL;
        } catch (\Exception $e) {
            echo($e->getCode() . ':' . $e->getMessage()) . PHP_EOL;
            $this->expectExceptionObject($e);
        }

        $http = "GET /social/poster/share/xx HTTP/1.1\r\n";
        $http .= "Host: dev-restful.moftech.net\r\n";
        $http .= "Accept: */*\r\n";
        $http .= "User-Agent: " . PHP_VERSION . "\r\n";
        $http .= "Connection: keep-alive\r\n\r\n";

        try {
            $i = 0;
            while ($i < 1) {
                echo ($socket->send($http)) . PHP_EOL;

                $j = 0;
                while ($j < 1) {
                    var_dump($socket->recv(65535, 1));
                    $j++;
                }
                $i++;
            }
        } catch (\Exception $e) {
            $this->expectExceptionObject($e);
        }
    }
}
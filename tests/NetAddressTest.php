<?php
declare(strict_types=1);
namespace Air\SocketClient\Test;

use Air\SocketClient\NetAddress\TcpNetAddress;
use Air\SocketClient\NetAddress\UdpNetAddress;
use Air\SocketClient\NetAddress\UnixNetAddress;
use PHPUnit\Framework\TestCase;

class NetAddressTest extends TestCase
{
    public function testTcpNetAddress()
    {
        $tcp = new TcpNetAddress('192.168.30.77', 80);
        $this->assertStringContainsString('tcp', $tcp->getAddress());

        $tcp = new TcpNetAddress('192.168.30.77', 80, true);
        $this->assertStringContainsString('tls', $tcp->getAddress());
    }

    public function testUdpNetAddress()
    {
        $tcp = new UdpNetAddress('192.168.30.77', 80);
        $this->assertStringContainsString('udp://', $tcp->getAddress());
    }

    public function testUnixNetAddress()
    {
        $tcp = new UnixNetAddress('./socket.sock');
        $this->assertStringContainsString('unix://', $tcp->getAddress());
    }
}

<?php
declare(strict_types=1);
namespace Air\Socket\Client\NetAddress;

/**
 * Class UdpNetAddress
 * @package Air\Socket\Client\NetAddress
 */
class UdpNetAddress extends TcpNetAddress
{
    /**
     * @return string
     */
    public function getAddress(): string
    {
        return sprintf('udp://%s:%s', $this->host, $this->port);
    }
}

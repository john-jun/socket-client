<?php
declare(strict_types=1);
namespace Air\Socket\Client\NetAddress;

use Air\Socket\Client\NetAddressInterface;

class TcpNetAddress implements NetAddressInterface
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port;

    /**
     * TcpNetAddress constructor.
     * @param string $host
     * @param int $port
     */
    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return sprintf('tcp://%s:%s', $this->host, $this->port);
    }
}
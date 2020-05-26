<?php
declare(strict_types=1);
namespace Air\SocketClient\NetAddress;

use Air\SocketClient\NetAddressInterface;

/**
 * Class TcpNetAddress
 * @package Air\Socket\Client\NetAddress
 */
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
     * @var bool
     */
    private $overTLS;

    /**
     * TcpNetAddress constructor.
     * @param string $host
     * @param int $port
     * @param bool $overTLS
     */
    public function __construct(string $host, int $port, bool $overTLS = false)
    {
        $this->host = $host;
        $this->port = $port;
        $this->overTLS = $overTLS;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return sprintf('%s://%s:%s', ($this->overTLS ? 'tls' : 'tcp'), $this->host, $this->port);
    }
}

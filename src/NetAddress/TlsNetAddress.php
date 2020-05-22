<?php
declare(strict_types=1);
namespace Air\Socket\Client\NetAddress;

class TlsNetAddress extends TcpNetAddress
{
    /**
     * @var string
     */
    private $tlsVer;

    /**
     * TlsNetAddress constructor.
     * @param string $host
     * @param int $port
     * @param string $tlsVer
     */
    public function __construct(string $host, int $port, string $tlsVer = 'tls')
    {
        parent::__construct($host, $port);

        $this->tlsVer = $tlsVer;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return sprintf('%s://%s:%s', $this->tlsVer, $this->host, $this->port);
    }
}

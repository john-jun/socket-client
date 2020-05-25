<?php
declare(strict_types=1);
namespace Air\Socket\Client\NetAddress;

use Air\SocketClient\NetAddressInterface;

/**
 * Class UnixNetAddress
 * @package Air\Socket\Client\NetAddress
 */
class UnixNetAddress implements NetAddressInterface
{
    /**
     * @var string
     */
    private $file;

    /**
     * UnixNetAddress constructor.
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return sprintf('unix://%s', $this->file);
    }
}

<?php
declare(strict_types=1);
namespace Air\Socket\Client\NetAddress;

use Air\Socket\Client\NetAddressInterface;

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

<?php
declare(strict_types=1);
namespace Air\Socket\Client\NetAddress;

/**
 * Interface NetAddressInterface
 * @package Air\Socket\Client
 */
interface NetAddressInterface
{
    public function getAddress():string;
}

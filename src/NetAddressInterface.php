<?php
declare(strict_types=1);
namespace Air\SocketClient;

/**
 * Interface NetAddressInterface
 * @package Air\Socket\Client
 */
interface NetAddressInterface
{
    public function getAddress():string;
}

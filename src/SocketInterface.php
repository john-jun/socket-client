<?php
declare(strict_types=1);
namespace Air\Socket\Client;

/**
 * Interface SocketInterface
 * @package Air\Socket\Client
 */
interface SocketInterface
{
    public function connect(float $timeout) : bool;
    public function close() : bool;

    public function send(string $data, float $timeout);
    public function recv(int $length, float $timeout);

    public function getConnectUseTime(): float;
}

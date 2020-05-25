<?php
declare(strict_types=1);
namespace Air\SocketClient\Exception;

use Air\SocketClient\SocketExceptionInterface;
use Exception;

/**
 * Class SocketException
 * @package Air\Socket\Client\Exception
 */
class SocketException extends Exception implements SocketExceptionInterface
{
}

<?php
declare(strict_types=1);
namespace Air\Socket\Client\Exception;

use Air\Socket\Client\SocketExceptionInterface;
use Exception;

/**
 * Class SocketException
 * @package Air\Socket\Client\Exception
 */
class SocketException extends Exception implements SocketExceptionInterface
{
}

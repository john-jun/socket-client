<?php
declare(strict_types=1);
namespace Air\Socket\Client;

use Air\Socket\Client\Exception\ConnectException;
use Air\Socket\Client\Exception\ReadFailedException;
use Air\Socket\Client\Exception\TimeoutException;
use Air\Socket\Client\Exception\WriteFailedException;
use ErrorException;
use Throwable;

/**
 * Class Socket
 * @package Air\Socket\Client
 */
class Socket implements SocketInterface
{
    /**
     * @var resource
     */
    private $resource;

    /**
     * @var NetAddressInterface
     */
    private $netAddress;

    /**
     * Socket constructor.
     * @param NetAddressInterface $netAddress
     */
    public function __construct(NetAddressInterface $netAddress)
    {
        $this->netAddress = $netAddress;
    }

    /**
     * Connect Resource
     * @param float|int $timeout
     * @return bool
     * @throws ConnectException
     */
    public function connect(float $timeout = -1): bool
    {
        if (!$this->isConnected()) {
            try {
                $resource = @stream_socket_client($this->netAddress->getAddress(), $errNumber, $errString, $timeout);
                if (false !== $resource) {
                    $this->resource = $resource;

                    //set not blocking mode
                    stream_set_blocking($this->resource, false);
                }
            } catch (Throwable $e) {
                throw new ConnectException($e->getMessage(), $e->getCode(), $e);
            }

            $this->handleResourceFailed($errNumber, $errString);
        }

        return true;
    }

    /**
     * Has Connected
     * @return bool
     */
    public function isConnected(): bool
    {
        return $this->isUsable() && !feof($this->resource);  //on TCP - other party can close connection.
    }

    /**
     * Close Resource
     * @return bool
     */
    public function close(): bool
    {
        if ($this->isUsable()) {
            stream_socket_shutdown($this->resource, STREAM_SHUT_RDWR);
            $close = fclose($this->resource);

            $this->resource = null;
        }

        return $close ?? true;
    }

    /**
     * Send Data
     * @param string $data
     * @param float|int $timeout
     * @return false|int
     * @throws TimeoutException
     * @throws WriteFailedException
     */
    public function send(string $data, float $timeout = -1)
    {
        $sentLength = 0;
        $dataLength = strlen($data);

        $this->setTimeoutTime($timeout);

        while ($this->isConnected() && $sentLength < $dataLength) {
            $sentLength += $this->write(0 === $sentLength ? $data : substr($data, $sentLength));
        }

        if ($sentLength !== $dataLength) {
            throw new WriteFailedException("End-of-file reached, probably we got disconnected (sent $sentLength of $dataLength)");
        }

        return $sentLength;
    }

    /**
     * Recv Data
     * @param int $length
     * @param float|int $timeout
     * @return string
     * @throws ReadFailedException
     * @throws TimeoutException
     */
    public function recv(int $length = 65535, float $timeout = -1)
    {
        $this->setTimeoutTime($timeout);

        $recvData = '';
        while (true) {
            $readData = $this->read($length);
            $data .= $readData;

            if (strlen($readData) > 0) {
                break;
            } else {
                usleep(100);
            }
        }

        return $recvData;
    }

    /**
     * Check Resource usable
     * @return bool
     */
    public function isUsable() : bool
    {
        if (null === $this->resource) {
            return false;
        }

        return true;
    }

    /**
     * obj Destruct to close resource
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * @param string $data
     * @return false|int
     * @throws TimeoutException
     * @throws WriteFailedException
     */
    private function write(string $data)
    {
        $writeResult = fwrite($this->resource, $data);

        if (!$writeResult) {
            if ($this->getStreamMetaData()['timed_out']) {
                throw new TimeoutException('Write timed-out');
            }

            if (false === $writeResult) {
                throw new WriteFailedException('Failed to write request to socket [broken pipe]');
            }
        }

        return $writeResult;
    }

    /**
     * @param int $length
     * @return false|string
     * @throws ReadFailedException
     * @throws TimeoutException
     */
    private function read(int $length)
    {
        $packet = fread($this->resource, $length);

        if (false === $packet) {
            $info = $this->getStreamMetaData();
            if ($info['time_out']) {
                throw new TimeoutException('Read timed-out');
            }

            if (0 === $info['unread_bytes'] && $info['blocked'] && $info['eof']) {
                throw new ReadFailedException('Read got blocked or terminated');
            }

            throw new ReadFailedException('Read failed');
        }

        return $packet;
    }

    /**
     * timeout
     * @param float $timeout
     * @return bool
     */
    private function setTimeoutTime(float $timeout): bool
    {
        if ($this->isUsable() && $timeout > 0) {
            $seconds = floor($timeout);
            $microseconds = round(($timeout - $seconds) * 1e6);

            return stream_set_timeout($this->resource, (int)$seconds, (int)$microseconds);
        }

        return false;
    }

    /**
     * @return array
     */
    private function getStreamMetaData(): array
    {
        return stream_get_meta_data($this->resource);
    }

    /**
     * @param int|null $errNumber
     * @param string|null $errString
     * @throws ConnectException
     */
    private function handleResourceFailed(?int $errNumber, ?string $errString): void
    {
        if ($this->isUsable()) {
            return;
        }

        $lastError = error_get_last();
        $lastErrorException = null;

        if (null !== $lastError) {
            $lastErrorException = new ErrorException(
                $lastError['message'] ?? '[No message available]',
                0,
                $lastError['type'] ?? E_ERROR,
                $lastError['file'] ?? '[No file available]',
                $lastError['line'] ?? '[No line available]'
            );
        }

        throw new ConnectException(
            sprintf('Failed connecting to %s : %s', $this->netAddress->getAddress(), $errString),
            (int)$errNumber,
            $lastErrorException
        );
    }
}

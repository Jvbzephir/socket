<?php
namespace Icicle\Socket\Stream;

use Icicle\Socket\Socket;
use Icicle\Stream\ReadableStreamInterface;

class ReadableStream extends Socket implements ReadableStreamInterface
{
    use ReadableStreamTrait;
    
    /**
     * @param resource $socket
     */
    public function __construct($socket)
    {
        parent::__construct($socket);
        $this->init($socket);
    }

    /**
     * Frees resources associated with the stream and closes the stream.
     *
     * @param \Throwable $exception Reason for the stream closing.
     */
    protected function free(\Throwable $exception = null)
    {
        $this->detach($exception);
        parent::close();
    }
}

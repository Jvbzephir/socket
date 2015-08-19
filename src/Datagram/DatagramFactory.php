<?php

/*
 * This file is part of the socket package for Icicle, a library for writing asynchronous code in PHP.
 *
 * @copyright 2014-2015 Aaron Piotrowski. All rights reserved.
 * @license Apache-2.0 See the LICENSE file that was distributed with this source code for more information.
 */

namespace Icicle\Socket\Datagram;

use Icicle\Socket\Exception\FailureException;
use Icicle\Socket\ParserTrait;

class DatagramFactory implements DatagramFactoryInterface
{
    use ParserTrait;

    /**
     * {@inheritdoc}
     */
    public function create(string $host, int $port, array $options = []): DatagramInterface
    {
        $context = [];
        
        $context['socket'] = [];
        $context['socket']['bindto'] = $this->makeName($host, $port);
        
        $context = stream_context_create($context);
        
        $uri = $this->makeUri('udp', $host, $port);
        // Error reporting suppressed since stream_socket_server() emits an E_WARNING on failure (checked below).
        $socket = @stream_socket_server($uri, $errno, $errstr, STREAM_SERVER_BIND, $context);
        
        if (!$socket || $errno) {
            throw new FailureException(
                sprintf('Could not create datagram on %s: Errno: %d; %s', $uri, $errno, $errstr)
            );
        }
        
        return new Datagram($socket);
    }
}

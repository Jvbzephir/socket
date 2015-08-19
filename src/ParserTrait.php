<?php

/*
 * This file is part of the socket package for Icicle, a library for writing asynchronous code in PHP.
 *
 * @copyright 2014-2015 Aaron Piotrowski. All rights reserved.
 * @license Apache-2.0 See the LICENSE file that was distributed with this source code for more information.
 */

namespace Icicle\Socket;

trait ParserTrait
{
    /**
     * Parses a name of the format ip:port, returning an array containing the ip and port.
     *
     * @param string $name
     *
     * @return array [ip-address, port] or [socket-path, 0].
     */
    protected function parseName(string $name): array
    {
        $colon = strrpos($name, ':');

        if (false === $colon) { // Unix socket.
            return [$name, 0];
        }

        $address = trim(substr($name, 0, $colon), '[]');
        $port = (int) substr($name, $colon + 1);

        $address = $this->parseAddress($address);

        return [$address, $port];
    }

    /**
     * Formats given address into a string. Converts integer to IPv4 address, wraps IPv6 address in brackets.
     *
     * @param string $address
     *
     * @return string
     */
    protected function parseAddress(string $address): string
    {
        if (false !== strpos($address, ':')) { // IPv6 address
            return '[' . trim($address, '[]') . ']';
        }

        return $address;
    }

    /**
     * Creates string of format $address[:$port].
     *
     * @param string $address Address or path.
     * @param int $port Port number or null for unix socket.
     *
     * @return string
     */
    protected function makeName(string $address, int $port): string
    {
        if (-1 === $port) { // Unix socket.
            return $address;
        }

        return sprintf('%s:%d', $this->parseAddress($address), $port);
    }

    /**
     * Creates string of format $protocol://$address[:$port].
     *
     * @param string $protocol Protocol.
     * @param string $address Address or path.
     * @param int $port Port number or null for unix socket.
     *
     * @return string
     */
    protected function makeUri(string $protocol, string $address, int $port): string
    {
        if (-1 === $port) { // Unix socket.
            return sprintf('%s://%s', $protocol, $address);
        }

        return sprintf('%s://%s:%d', $protocol, $this->parseAddress($address), $port);
    }
}

<?php
namespace Icicle\Socket\Datagram;

interface DatagramFactoryInterface
{
    /**
     * @param string $host
     * @param int $port
     * @param mixed[] $options
     *
     * @return \Icicle\Socket\Datagram\Datagram
     *
     * @throws \Icicle\Socket\Exception\FailureException If creating the datagram fails.
     */
    public function create($host, $port, array $options = []): DatagramInterface;
}

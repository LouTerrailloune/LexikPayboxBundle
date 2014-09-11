<?php

namespace Lexik\Bundle\PayboxBundle\Transport;

use Lexik\Bundle\PayboxBundle\Paybox\RequestInterface;

/**
 * Transport\TransportInterface class.
 *
 * @author Fabien Pomerol <fabien.pomerol@gmail.com>
 */
interface TransportInterface
{
    /**
     * Prepare and send a message.
     *
     * @param RequestInterface $request RequestInterface instance
     *
     * @return String The Paybox response
     */
    public function call(RequestInterface $request);
}

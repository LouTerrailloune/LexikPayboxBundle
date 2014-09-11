<?php

namespace Lexik\Bundle\PayboxBundle\Paybox;

/**
 * Paybox\RequestInterface class.
 *
 */
interface RequestInterface
{
    /**
     * Returns all parameters set for a request.
     *
     * @return array
     */
    function getParameters();
}

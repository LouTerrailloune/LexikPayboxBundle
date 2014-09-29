<?php

namespace Lexik\Bundle\PayboxBundle\Paybox\Direct;

use Lexik\Bundle\PayboxBundle\Paybox\Paybox;
use Lexik\Bundle\PayboxBundle\Paybox\Direct\ParameterResolver;
use Lexik\Bundle\PayboxBundle\Paybox\RequestInterface;
use Lexik\Bundle\PayboxBundle\Transport\TransportInterface;

/**
 * Paybox\Diret\Request class.
 *
 * @author Vincent Terraillon <lou.terrailloune@gmail.com>
 */
class Request extends Paybox implements RequestInterface
{
    /**
     * @var TransportInterface This is how
     * you will point to Paybox (via cURL or Shell)
     */
    protected $transport;

    /**
     * @var array Configuration
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param array              $parameters
     * @param array              $servers
     * @param TransportInterface $transport
     */
    public function __construct(array $parameters, array $servers, TransportInterface $transport = null, array $config)
    {
        $this->transport = $transport;
        $this->config = $config;
        parent::__construct($parameters, $servers);
    }

    /**
     * @see Paybox::initParameters()
     */
    protected function initParameters()
    {
        $this->setParameter('SITE',        $this->globals['site']);
        $this->setParameter('RANG',        $this->globals['rank']);
        $this->setParameter('VERSION',     '00104');
        $this->setParameter('IDENTIFIANT', $this->globals['login']);
        $this->setParameter('CLE',         $this->globals['password']);
        $this->setParameter('ACTIVITE',    '024');
    }

    /**
     * Returns all parameters set for a payment.
     *
     * @return array
     */
    public function getParameters()
    {
        $resolver = new ParameterResolver();

        $parameters = $resolver->resolve($this->parameters);

        uksort($parameters, function($key1, $key2){
            if($key1 == 'TYPE')
            {
                return -1;
            }
            if($key2 == 'TYPE')
            {
                return 1;
            }
            return 0;
        });
        return $parameters;
    }

    /**
     * {@inheritDoc}
     *
     * @throws RuntimeException On cURL error
     *
     * @return array All the parameters returned by Paybox server
     */
    public function run()
    {
        $this->setParameter('DATEQ', date('dmYHis'));
        $this->setParameter('NUMQUESTION', time());

        $servers = $this->config['servers'][$this->globals['platform']];

        $this->transport->setEndpoint('https://'.$servers[0].$this->config['path']);

        $resultString = $this->transport->call($this);
        parse_str($resultString, $result);

        $result['used_endpoint'] = 'https://'.$servers[0].$this->config['path'];

        return $result;
    }
}

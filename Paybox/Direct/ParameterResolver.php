<?php

namespace Lexik\Bundle\PayboxBundle\Paybox\Direct;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

/**
 * Paybox\Direct\ParameterResolver class.
 *
 * @author Vincent Terraillon <lou.terrailloune@gmail.com>
 */
class ParameterResolver
{
    /**
     * @var array
     */
    private $knownParameters;

    /**
     * @var array
     */
    private $requiredParameters;

    /**
     * @var OptionsResolver
     */
    private $resolver;

    /**
     * Constructor initialize all available parameters.
     */
    public function __construct()
    {
        $this->resolver = new OptionsResolver();

        $this->knownParameters = array(
            'ACQUEREUR',
            'ACTIVITE',
            'ARCHIVAGE',
            'AUTORISATION',
            'CVV',
            'DATENAISS',
            'DATEQ',
            'DATEVAL',
            'DEVISE',
            'DIFFERE',
            'ERRORCODETEST',
            'ID3D',
            'MONTANT',
            'NUMAPPEL',
            'NUMQUESTION',
            'NUMTRANS',
            'PAYS',
            'PORTEUR',
            'PRIV_CODETRAITEMENT',
            'RANG',
            'REFABONNE',
            'REFERENCE',
            'SHA-1',
            'SITE',
            'TYPE',
            'TYPECARTE',
            'VERSION',
            'CLE',
            'IDENTIFIANT',
        );
    }

    /**
     * Resolves parameters for a cancellation call.
     *
     * @param  array $parameters
     *
     * @return Options
     */
    public function resolve(array $parameters)
    {
        $this->initParameters();

        return $this->resolver->resolve($parameters);
    }

    /**
     * Initialise required parameters for a cancellation call.
     */
    protected function initParameters()
    {
        $this->requiredParameters = array(
            'SITE',
            'RANG',
            'VERSION',
            'TYPE',
            'DATEQ',
            'NUMQUESTION',
            'CLE',
            'IDENTIFIANT',
        );

        $this->initResolver();
    }

    /**
     * Initialize the OptionResolver with required/optionnal options and allowed values.
     */
    protected function initResolver()
    {
        $this->resolver->setRequired($this->requiredParameters);

        $this->resolver->setOptional(array_diff($this->knownParameters, $this->requiredParameters));

        $this->initAllowed();
    }

    /**
     * Initialize allowed values for the cancellation OptionResolver.
     */
    protected function initAllowed()
    {
        $this->resolver->setAllowedValues(array(
            'VERSION' => array('00103', '00104'),
            'TYPE'    => array('00005'),
        ));
    }
}

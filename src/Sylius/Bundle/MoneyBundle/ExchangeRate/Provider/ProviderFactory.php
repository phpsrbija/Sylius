<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\MoneyBundle\ExchangeRate\Provider;

use Symfony\Component\DependencyInjection\ContainerAware;

class ProviderFactory extends ContainerAware
{

    /**
     * @var Container
     */
    private $container;

    function __construct($providerName, $serviceName)
    {

    }


    /**
     * Create provider object
     */
    public function createProvider()
    {
        return $this->container->get($this->getActiveProviderName());
    }

    /**
     * Get selected Provider name
     */
    private function getActiveProviderName()
    {
        return 'sylius.exchange_rate.yahoo_provider';
    }

}

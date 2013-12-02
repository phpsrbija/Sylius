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

class Factory
{

    /**
     * @var Container
     */
    private $container;

    /**
     * Create provider object
     */
    public function createProvider()
    {
        return $this->container->get($this->getActiveProviderName());
    }

    /**
     * Set Service Container
     * @param $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * Get selected Provider name
     */
    private function getActiveProviderName()
    {
        return 'sylius.exchange_rate.google_provider';
    }

}

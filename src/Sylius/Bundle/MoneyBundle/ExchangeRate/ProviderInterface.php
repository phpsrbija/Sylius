<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\MoneyBundle\ExchangeRate;

interface ProviderInterface
{
    /**
     * Get rate value from external services
     *
     * @param  string $currencyFrom
     * @param  string $currencyTo
     * @return float
     */
    public function getRate($currencyFrom, $currencyTo);
}

<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\MoneyBundle\ExchangeRate\Updater;

use Sylius\Bundle\MoneyBundle\ExchangeRate\UpdaterInterface;

/**
 * Class GoogleProvider
 *
 * Get the currency rates from the Google Service
 *
 * @author Ivan Đurđevac <djurdjevac@gmail.com>
 */
class DatabaseUpdater implements UpdaterInterface
{

    /**
     * @var ProviderInterface
     */
    private $exchange_rate_provider;

    /**
     * Create Updater with provider
     */
    public function __construct($providerFactory)
    {
        $this->exchange_rate_provider = $providerFactory->createProvider();
    }

    /**
     * Update rate in database for currency
     * @param  string $currency
     * @return bool
     */
    public function updateRate($currency)
    {
        // :todo Implement method
    }

    /**
     * Update All rates
     * @return bool
     */
    public function updateAllRates()
    {
        // :todo Implement method
    }
}
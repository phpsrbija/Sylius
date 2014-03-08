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

use Sylius\Bundle\MoneyBundle\ExchangeRate\Provider\ProviderFactory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GoogleProvider
 *
 * Get the currency rates from the Google Service
 *
 * @author Ivan Đurđevac <djurdjevac@gmail.com>
 */
class DatabaseUpdater implements UpdaterInterface, ContainerAwareInterface
{
    /**
     * Container
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Set Container
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @var ProviderInterface
     */
    private $exchangeRateProvider;

    /**
     * Create Updater with provider
     */
    public function __construct(ProviderFactory $providerFactory)
    {
        $this->exchangeRateProvider = $providerFactory->createProvider();
    }

    /**
     * Update rate in database for currency
     * @param  string $currency
     * @return bool
     */
    public function updateRate($currency)
    {
        $doctrine = $this->container->get('doctrine');
        $exchangeRate = $doctrine
            ->getRepository('Sylius\Bundle\MoneyBundle\Model\ExchangeRate')
            ->findOneBy(array('currency' => $currency));

        if (!$exchangeRate) {
            return false;
        }

        $currencyRate = $this->exchangeRateProvider->getRate($this->getBaseCurrency(), $exchangeRate->getCurrency());
        $exchangeRate->setRate($currencyRate);

        $doctrine->getManager()->flush();

        return true;
    }

    /**
     * Update All rates
     * @return bool
     */
    public function updateAllRates()
    {
        $doctrine = $this->container->get('doctrine');
        $exchangeRates = $doctrine
            ->getRepository('Sylius\Bundle\MoneyBundle\Model\ExchangeRate')
            ->findAll();

        $baseCurrency = $this->getBaseCurrency();

        foreach ($exchangeRates as $exchangeRate) {
            if ($baseCurrency == $exchangeRate->getCurrency()) {
                continue;
            }

            $currencyRate = $this->exchangeRateProvider->getRate($baseCurrency, $exchangeRate->getCurrency());
            $exchangeRate->setRate($currencyRate);
        }
        $doctrine->getManager()->flush();

        return true;
    }

    /**
     * Bet base currency
     * @return string
     */
    private function getBaseCurrency()
    {
        $currencyConverter = $this->container->get('sylius.currency_converter');

        return $currencyConverter->getBaseCurrency();
    }
}

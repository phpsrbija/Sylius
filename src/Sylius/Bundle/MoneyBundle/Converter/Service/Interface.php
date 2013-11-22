<?php
/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Sylius\Bundle\MoneyBundle\Converter;

/**
 * Interface Service_Interface
 *
 * Interface used by external services which can response with exchange rate values
 *
 * @package Sylius\Bundle\MoneyBundle\Converter
 * @author Ivan Đurđevac <djurdjevac@gmail.com>
 */
Interface Service_Interface
{
    /**
     * Get rate value from external services
     *
     * @param $fromCurrency
     * @param $toCurrency
     * @return mixed
     */
    public function getRate($fromCurrency, $toCurrency);
}
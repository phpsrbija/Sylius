<?php
/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Sylius\Bundle\MoneyBundle\Converter\Service;

use Sylius\Bundle\MoneyBundle\Converter\Service_Interface;
use Guzzle\Http\Client as HttpClient;

/**
 * Class Google
 *
 * Get the currency rates from the Google Service
 *
 * @package Sylius\Bundle\MoneyBundle\Converter\Service
 * @author Ivan Đurđevac <djurdjevac@gmail.com>
 */
class Google implements Service_Interface
{
    /**
     * Service exchange rate url
     * @var string
     */
    private $serviceUrl = 'http://rate-exchange.appspot.com/';

    /**
     * Get rate from Google exchange rate service
     * @param $fromCurrency
     * @param $toCurrency
     * @return mixed|void
     */
    public function getRate($fromCurrency, $toCurrency)
    {
        $client = new HttpClient();
        if ($request = $client->post($this->serviceUrl."currency?from=$fromCurrency&to=$toCurrency"))
        {
            $serviceResponse = json_encode($request);
            $serviceResponse->rate;
        }

        return false;
    }
}
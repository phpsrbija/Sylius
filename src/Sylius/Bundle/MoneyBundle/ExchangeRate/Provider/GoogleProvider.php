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

use Sylius\Bundle\MoneyBundle\ExchangeRate\ProviderInterface;
use Guzzle\Http\ClientInterface;

/**
 * Class GoogleProvider
 *
 * Get the currency rate from the Google Service
 *
 * @author Ivan Đurđevac <djurdjevac@gmail.com>
 */
class GoogleProvider implements ProviderInterface
{
    /**
     * Http Client object
     * @var \Guzzle\Http\Client
     */
    private $httpClient;

    /**
     * Service exchange rate url
     * @var string
     */
    private $serviceUrl = 'http://rate-exchange.appspot.com/';

    /**
     * Google provider construct
     * @param $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Get rate from Google exchange rate service
     * @param  string    $currencyFrom
     * @param  string    $currencyTo
     * @throws Exception
     * @return float
     */
    public function getRate($currencyFrom, $currencyTo)
    {
        $fetchUrl = sprintf('%scurrency?from=%s&to=%s', $this->serviceUrl, $currencyFrom, $currencyTo);
        if ($response = $this->httpClient->get($fetchUrl)->send() && $jsonResponse = $response->json()) {
            return (float) $jsonResponse['rate'];
        }

        throw new Exception('Google exchange service is not available');
    }
}

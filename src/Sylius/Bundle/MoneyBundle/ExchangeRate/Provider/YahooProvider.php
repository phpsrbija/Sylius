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

use Guzzle\Http\ClientInterface;

/**
 * Class GoogleProvider
 *
 * Get the currency rates from the Google Service
 *
 * @author Ivan Đurđevac <djurdjevac@gmail.com>
 */
class YahooProvider implements ProviderInterface
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
    private $serviceUrl = 'http://finance.yahoo.com/';

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
     * @param  string            $currencyFrom
     * @param  string            $currencyTo
     * @throws ProviderException
     * @return float
     */
    public function getRate($currencyFrom, $currencyTo)
    {
        $fetchUrl = sprintf('%sd/quotes.csv?e=.csv&f=sl1d1t1&s=%s%s=X', $this->serviceUrl, $currencyFrom, $currencyTo);
        if ($response = $this->httpClient->get($fetchUrl)->send()) {
            $response->getBody()->seek(0);
            $responseArray = explode(',', (string) $response->getBody());
            if (isset($responseArray[1])) {
                return (float) $responseArray[1];
            }
        }

        throw new ProviderException('Yahoo exchange service is not available');
    }
}

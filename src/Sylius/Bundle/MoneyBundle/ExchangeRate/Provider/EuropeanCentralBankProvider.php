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
 * Class EuropeanCentralBankProvider
 *
 * Get the currency rate from the European Central Bank
 *
 * @author Milan Popovic <komita1981@gmail.com>
 */
class EuropeanCentralBankProvider implements ProviderInterface
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
    private $serviceUrl = 'http://www.ecb.europa.eu/';

    /**
     * European Central Bank provider construct
     * @param $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Get rate from European Central Bank exchange rate service
     * @param  string    $currencyFrom
     * @param  string    $currencyTo
     * @throws Exception
     * @return float
     */
    public function getRate($currencyFrom, $currencyTo)
    {
        $fetchUrl = sprintf('%sstats/eurofxref/eurofxref-daily.xml', $this->serviceUrl);

        try{
            $response = $this->httpClient->get($fetchUrl)->send();
        }catch (ClientErrorResponseException $e){
            throw new Exception($e->getMessage());
        }

        $xmlResponse = $response->xml();

        if (! isset($xmlResponse->Cube->Cube->Cube)){
            throw new Exception('Invalid XML file');
        }

        $currencyFrom == 'EUR' and $currencyFromRate = 1;
        $currencyTo == 'EUR' and $currencyToRate = 1;

        foreach($xmlResponse->Cube->Cube->Cube as $node){
            $currency = (string) $node['currency'];

            if ($currencyFrom == $currency){
                $currencyFromRate = (float) $node['rate'];
            }

            if ($currencyTo == $currency){
                $currencyToRate = (float) $node['rate'];
            }

            if (isset($currencyFromRate) and isset($currencyToRate)){
                break;
            }
        }

        if (! isset($currencyFromRate) or $currencyFromRate == 0){
            throw new Exception('Invalid input currency code');
        }

        if (! isset($currencyToRate) or $currencyToRate == 0){
            throw new Exception('Invalid output currency code');
        }

        return (float) $currencyToRate/$currencyFromRate;
    }
}

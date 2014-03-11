<?php namespace Sylius\Bundle\MoneyBundle\Model;

use Symfony\Component\Yaml\Parser;

class ExchangeRateConfig
{
    /**
     * Exchange Rate config
     * @var array
     */
    protected $configArray;


    /**
     * Get Config Array
     * @return array
     */
    public function get()
    {
        if (!$this->configArray) {
            $parser = new Parser();
            $this->configArray = $parser->parse(file_get_contents(__DIR__ . '/../Resources/config/exchange_rates.yml'));
        }
        return $this->configArray;
    }

    /**
     * Get available exchange rate services
     * @return string
     */
    public function getExchangeServiceNames()
    {
        $config = $this->get();
        return $config['services'];
    }
}
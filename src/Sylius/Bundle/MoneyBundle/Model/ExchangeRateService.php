<?php namespace Sylius\Bundle\MoneyBundle\Model;



class ExchangeRateService
{

    /**
     * Settings Manager
     * @var SettingsManagerInterface
     */
    protected $settingsManager;

    /**
     * Exchange Rate Config
     * @var ExchangeRateConfig
     */
    protected $config;



    /**
     * @param $settingsManager
     * @param $config
     */
    function __construct($settingsManager, ExchangeRateConfig $config)
    {
        $this->settingsManager = $settingsManager;
        $this->config = $config;
    }

    /**
     * Get selected Provider name
     */
    public function getActiveProviderKey()
    {
        $providerName  = $this->settingsManager->loadSettings('exchange_rates')->get('exchange_service_name');
        if (!$providerName) {
            $config = $this->config->get();
            return $config['default_service'];
        }

        return $providerName;
    }

    /**
     * Get active Provider Name
     * @return string
     */
    public function getActiveProviderName()
    {
        $providerKey = $this->getActiveProviderKey();
        $services = $this->config->getExchangeServiceNames();

        return isset($services[$providerKey]) ? $services[$providerKey] : '';
    }
}
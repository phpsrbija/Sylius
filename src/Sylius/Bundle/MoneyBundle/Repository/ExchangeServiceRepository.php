<?php namespace Sylius\Bundle\MoneyBundle\Model;

class ExchangeServiceRepository
{
    /**
     * Service Name
     * @var string
     */
    protected $serviceName;

    /**
     * @param string $serviceName
     */
    public function setExchangeServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }

    /**
     * @return string
     */
    public function getExchangeServiceName()
    {
        return $this->serviceName;
    }


}
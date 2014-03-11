<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\MoneyBundle\Settings;

use Sylius\Bundle\MoneyBundle\Model\ExchangeRateConfig;
use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface;
use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\FormBuilderInterface;


class ExchangeRateSettingsSchema implements SchemaInterface
{


    /**
     * Exchange Rate Config
     * @var ExchangeRateConfig
     */
    protected $config;

    public function __construct(ExchangeRateConfig $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults(array(
                'exchange_service_name'            => 'Sylius - Modern ecommerce for Symfony2',
            ))
            ->setAllowedTypes(array(
                'exchange_service_name'            => array('string')
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('exchange_service_name', 'sylius_exchange_service_choice', array(
                'label'       => 'sylius.exchange_rate.form.select_provider',
                'choices' => $this->config->getExchangeServiceNames(),
            ));
    }
}

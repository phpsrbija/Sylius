<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Component\Money\Converter;

use PhpSpec\ObjectBehavior;

class CurrencyConverterSpec extends ObjectBehavior
{
    /**
     * @param Sylius\Component\Resource\Repository\RepositoryInterface $exchangeRateRepository
     */
    function let($exchangeRateRepository)
    {
        $this->beConstructedWith($exchangeRateRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\Money\Converter\CurrencyConverter');
    }

    function it_implements_Sylius_exchange_rate_interface()
    {
        $this->shouldImplement('Sylius\Component\Money\Converter\CurrencyConverterInterface');
    }

    /**
     * @param \Sylius\Component\Money\Model\ExchangeRateInterface $exchangeRate
     */
    function it_converts_to_any_currency($exchangeRate, $exchangeRateRepository)
    {
        $exchangeRateRepository->findOneBy(array('currency' => 'USD'))->shouldBeCalled()->willReturn($exchangeRate);
        $exchangeRate->getRate()->shouldBeCalled()->willReturn(0.76495);

        $this->convert(65.55, 'USD')->shouldReturnFloat(85.691875285966);
    }

    public function getMatchers()
    {
        return array(
            'returnFloat' => function ($a, $b) {
                return (string) $a === (string) $b;
            }
        );
    }
}

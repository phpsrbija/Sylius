<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\MoneyBundle\Context;

use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CurrencyContextSpec extends ObjectBehavior
{
    public function let(SessionInterface $session)
    {
        $this->beConstructedWith($session, 'EUR');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\MoneyBundle\Context\CurrencyContext');
    }

    public function it_implements_Sylius_currency_context_interface()
    {
        $this->shouldImplement('Sylius\Bundle\MoneyBundle\Context\CurrencyContextInterface');
    }

    public function it_gets_default_currency()
    {
        $this->getDefaultCurrency()->shouldReturn('EUR');
    }

    public function it_gets_currency_from_session($session)
    {
        $session->get('currency', 'EUR')->shouldBeCalled()->willReturn('RSD');

        $this->getCurrency()->shouldReturn('RSD');
    }

    public function it_sets_currency_to_session($session)
    {
        $session->set('currency', 'PLN')->shouldBeCalled();

        $this->setCurrency('PLN');
    }
}

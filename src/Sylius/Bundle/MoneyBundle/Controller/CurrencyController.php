<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\MoneyBundle\Controller;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

class CurrencyController extends ResourceController
{
    public function changeAction(Request $request, $currency)
    {
        $this->get('sylius.currency_context')->setCurrency($currency);

        return $this->redirect($request->headers->get('referer'));
    }


    public function updateAllRatesAction(Request $request)
    {
        $databaseUpdater = $this->container->get('sylius.exchange_rate.updater');
        if ($databaseUpdater->updateAllRates())
        {
            $this->flashHelper->setFlash('success', 'sylius.exchange_rate.update_all_rates');
        } else {
            $this->flashHelper->setFlash('errors', 'sylius.exchange_rate.update_all_rates');
        }

        return $this->redirect($this->get('router')->generate('sylius_backend_exchange_rate_index'));

    }
}

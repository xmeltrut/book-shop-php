<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use Stripe\Stripe;
use Stripe\Charge;

use App\Helper\Basket;

class LocalCheckoutController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/local-checkout")
     */
    public function localCheckout(Request $request)
    {
        if ($request->isMethod('POST')) {
            $token = $request->request->get('token');

            Stripe::setApiKey($_ENV['STRIPE_PRIVATE_KEY']);

            $basket = new Basket($this->session->get('basket'));

            $charge = Charge::create([
                'amount' => $basket->getRawPrice(),
                'currency' => 'gbp',
                'description' => $basket->getDescription(),
                'source' => $token,
            ]);

            $this->session->set('basket', []);
            return $this->redirect('/success');
        }

        return $this->render('local-checkout.html.twig');
    }
}

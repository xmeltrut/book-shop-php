<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use Stripe\Stripe;
use Stripe\PaymentIntent;

use App\Helper\Basket;

class ScaCheckoutController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/sca-checkout")
     */
    public function scaCheckout(Request $request)
    {
        $basket = new Basket($this->session->get('basket'));
        Stripe::setApiKey($_ENV['STRIPE_PRIVATE_KEY']);

        if ($request->isMethod('POST')) {
            $this->session->set('basket', []);
            return $this->redirect('/success');
        }

        $intent = PaymentIntent::create([
          'amount' => $basket->getRawPrice(),
          'currency' => 'gbp',
          'description' => $basket->getDescription()
        ]);

        return $this->render('sca-checkout.html.twig', [
            'clientSecret' => $intent->client_secret
        ]);
    }
}

<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/checkout")
     */
    public function checkout(Request $request)
    {
        Stripe::setApiKey($_ENV['STRIPE_PRIVATE_KEY']);

        $sessionData = [
          'payment_method_types' => ['card'],
          'line_items' => [],
          'success_url' => 'http://localhost:8000/success?session_id={CHECKOUT_SESSION_ID}',
          'cancel_url' => 'http://localhost:8000/basket',
        ];

        foreach ($this->session->get('basket') as $book) {
            $sessionData['line_items'][] = [
                'name' => $book['title'],
                'description' => $book['author'],
                'amount' => ($book['price'] * 100),
                'currency' => 'gbp',
                'quantity' => 1
            ];
        }

        $session = Session::create($sessionData);

        return $this->render('checkout.html.twig', [
            'sessionId' => $session->id
        ]);
    }
}

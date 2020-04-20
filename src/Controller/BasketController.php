<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/basket")
     */
    public function viewBasket(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->session->set('basket', []);
        }

        $basket = $this->session->get('basket');
        $totalPrice = 0;

        foreach ($basket as $book) {
            $totalPrice += $book['price'];
        }

        return $this->render('basket.html.twig', [
            'basket' => $basket,
            'totalPrice' => $totalPrice
        ]);
    }
}

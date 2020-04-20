<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/basket/add")
     */
    public function add(Request $request)
    {
        $json = json_decode($request->getContent());
        $basket = $this->session->get('basket', []);
        $book = $this->getDoctrine()->getRepository('App\Entity\Book')->find($json->id);
        $basket[] = $book->jsonSerialize();
        $this->session->set('basket', $basket);
        return $this->json($basket);
    }

    /**
     * @Route("/basket/list")
     */
    public function list()
    {
        $basket = $this->session->get('basket', []);
        return $this->json($basket);
    }
}

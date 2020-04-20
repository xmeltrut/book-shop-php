<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class HomepageController extends AbstractController
{
    public function index()
    {
        $books = $this->getDoctrine()
            ->getRepository('App\Entity\Book')
            ->findBy([]);

        return $this->render('homepage.html.twig', [
            'books' => $books
        ]);
    }
}

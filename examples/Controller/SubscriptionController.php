<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\SetupIntent;

class SubscriptionController extends AbstractController
{
    /**
     * @Route("/subscription")
     */
    public function subscription(Request $request)
    {
        if ($request->request->get('action') == 'create_customer') {
            return $this->createCustomer($request);
        } elseif ($request->request->get('action') == 'submit_payment') {
            return $this->redirect('/success');
        }

        return $this->render('subscription.html.twig', [
            'clientSecret' => null
        ]);
    }

    private function createCustomer(Request $request)
    {
        $name = $request->request->get('name');
        $email = $request->request->get('email');

        Stripe::setApiKey($_ENV['STRIPE_PRIVATE_KEY']);

        $customer = Customer::create(['name' => $name, 'email' => $email]);

        $intent = SetupIntent::create([
            'customer' => $customer->id,
            'payment_method_types' => ['card'],
        ]);

        return $this->render('subscription.html.twig', [
            'clientSecret' => $intent->client_secret
        ]);
    }
}

<?php
$container->loadFromExtension('twig', [
    // ...
    'globals' => [
        'stripe_public_key' => $_ENV['STRIPE_PUBLIC_KEY'],
    ],
]);

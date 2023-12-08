<?php

namespace App\EventListener;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;

class RedirectIfNotVerifiedListener {
    private $router;
    private $security;

    public function __construct(Security $security, RouterInterface $router)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $currentRoute = $request->attributes->get('_route');
        $user = $this->security->getUser();

        if ($user) {
            $excludedRoutes = ['app_logout', 'app_verify_email', 'app_email_not_verified', 'app_resend_email'];
            if (in_array($currentRoute, $excludedRoutes)) {
                return;
            }

            if (!$user->isVerified()) {
                $response = new RedirectResponse($this->router->generate('app_email_not_verified'));
                $event->setResponse($response);
            }
        }
    }
}
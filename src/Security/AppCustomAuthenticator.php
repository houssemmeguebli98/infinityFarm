<?php
// src/Security/AppCustomAuthenticator.php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppCustomAuthenticator extends AbstractLoginFormAuthenticator
{
use TargetPathTrait;

public const LOGIN_ROUTE = 'app_login';

public function __construct(private UrlGeneratorInterface $urlGenerator)
{
}

public function authenticate(Request $request): Passport
{
$email = $request->request->get('email', '');

$request->getSession()->set(Security::LAST_USERNAME, $email);

return new Passport(
new UserBadge($email),
new PasswordCredentials($request->request->get('password', '')),
[
new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
new RememberMeBadge(),
]
);
}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $user = $token->getUser();

        // Check the user status
        if ($user->getStatus() === false) {
            // Redirect the user to the ban page
            return new RedirectResponse($this->urlGenerator->generate('ban_page'));
        }

        // If not banned, proceed with the regular redirect logic
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // If not banned and no target path, redirect to the home page
        return new RedirectResponse($this->urlGenerator->generate('home'));
    }

protected function getLoginUrl(Request $request): string
{
return $this->urlGenerator->generate(self::LOGIN_ROUTE);
}
}

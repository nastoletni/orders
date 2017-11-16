<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Symfony\Security;

use BadMethodCallException;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Hmac\Sha512;
use Lcobucci\JWT\Token;
use Nastoletni\Orders\Application\SignedJwtProviderConfiguration;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Guard\GuardAuthenticatorInterface;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator implements GuardAuthenticatorInterface
{
    /**
     * @var SignedJwtProviderConfiguration
     */
    private $configuration;

    /**
     * ApiTokenAuthenticator constructor.
     *
     * @param SignedJwtProviderConfiguration $configuration
     */
    public function __construct(SignedJwtProviderConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new JsonResponse(['error' => 'You are unauthorized. Head to /api/auth.'], 401);
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request): ?Token
    {
        if (!$request->headers->has('Authorization')
            || !preg_match(
                '/^(?:Bearer) ([A-Za-z0-9-_]+\.[A-Za-z0-9-_]+\.[A-Za-z0-9-_]*)$/',
                $request->headers->get('Authorization'),
                $matches
        )) {
            return null;
        }

        $parser = new Parser();
        $token = $parser->parse($matches[1]);

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($token, UserProviderInterface $userProvider): UserInterface
    {
        /** @var $token Token|null */
        if (null === $token) {
            throw new AuthenticationException('Invalid token provided. Head to /api/auth.');
        }

        $username = $token->getClaim('username');
        try {
            $user = $userProvider->loadUserByUsername($username);
        } catch (UsernameNotFoundException $e) {
            throw new AuthenticationException('Invalid credentials given.');
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($token, UserInterface $user): bool
    {
        /** @var $token Token */
        try {
            if (!$token->verify($this->configuration->getSigner(), $this->configuration->getSecret())) {
                throw new AuthenticationException('Invalid credentials given');
            }
        } catch (BadMethodCallException $e) {
            throw new AuthenticationException('Invalid credentials given');
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['error' => $exception->getMessage()], 400);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe(): bool
    {
        return false;
    }
}
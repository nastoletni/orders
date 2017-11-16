<?php

declare(strict_types=1);

namespace Nastoletni\Orders\UserInterface\Api;

use Nastoletni\Orders\Application\SignedJwtProvider;
use Nastoletni\Orders\Domain\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserController extends Controller
{
    /**
     * @var UserProviderInterface
     */
    private $userProvider;

    /**
     * @var SignedJwtProvider
     */
    private $jwtProvider;

    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserController constructor.
     *
     * @param UserProviderInterface $userProvider
     * @param SignedJwtProvider $jwtProvider
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(
        UserProviderInterface $userProvider,
        SignedJwtProvider $jwtProvider,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->userProvider = $userProvider;
        $this->jwtProvider = $jwtProvider;
        $this->passwordEncoder = $encoderFactory->getEncoder(User::class);
    }

    /**
     * POST /api/auth
     *
     * Example request:
     *
     *     {
     *         "username": "JohnDoe",
     *         "password": "password123"
     *     }
     *
     * Example response:
     *
     *     {
     *         "token": "*signed JWT token*"
     *     {
     *
     * @param Request $request
     *
     * @return Response
     */
    public function auth(Request $request): Response
    {
        $errorResponse = $this->json(['error' => 'Invalid credentials given.'], 401);

        try {
            $user = $this->userProvider->loadUserByUsername($request->request->get('username', ''));
        } catch (UsernameNotFoundException $e) {
            return $this->json(['error' => 'Invalid credentials given. dupaaaa'], 401);
        }

        if (!$this->passwordEncoder->isPasswordValid(
            $user->getPassword(),
            $request->request->get('password', ''),
            $user->getSalt()
        )) {
            return $errorResponse;
        }

        $token = $this->jwtProvider->provide(['username' => $user->getUsername()]);

        return $this->json(['token' => (string) $token]);
    }
}
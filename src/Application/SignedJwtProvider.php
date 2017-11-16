<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application;

use DateTime;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Token;

class SignedJwtProvider
{
    /**
     * @var SignedJwtProviderConfiguration
     */
    private $configuration;

    /**
     * SignedJwtProvider constructor.
     *
     * @param SignedJwtProviderConfiguration $configuration
     */
    public function __construct(SignedJwtProviderConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param array $payload
     *
     * @return Token
     */
    public function provide(array $payload): Token
    {
        $builder = new Builder();

        foreach ($payload as $key => $value) {
            $builder->set($key, $value);
        }

        $builder->setExpiration((new DateTime('+1 hour'))->getTimestamp());

        $builder->sign(
            $this->configuration->getSigner(),
            $this->configuration->getSecret()
        );

        return $builder->getToken();
    }
}
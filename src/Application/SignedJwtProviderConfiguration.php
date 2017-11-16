<?php

declare(strict_types=1);

namespace Nastoletni\Orders\Application;

use Lcobucci\JWT\Signer;

class SignedJwtProviderConfiguration
{
    /**
     * @var Signer
     */
    private $signer;

    /**
     * @var string
     */
    private $secret;

    /**
     * SignedJwtProviderConfiguration constructor.
     *
     * @param Signer $signer
     * @param string $secret
     */
    public function __construct(Signer $signer, string $secret)
    {
        $this->signer = $signer;
        $this->secret = $secret;
    }

    /**
     * @return Signer
     */
    public function getSigner(): Signer
    {
        return $this->signer;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }
}
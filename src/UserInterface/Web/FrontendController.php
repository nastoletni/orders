<?php

declare(strict_types=1);

namespace Nastoletni\Orders\UserInterface\Web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontendController extends Controller
{
    /**
     * GET /
     *
     * @param Request $request
     *
     * @return Response
     */
    public function frontend(Request $request): Response
    {
        return $this->render('@views/index.html');
    }
}
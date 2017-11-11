<?php

declare(strict_types=1);

namespace Nastoletni\Orders\UserInterface\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller
{
    /**
     * @return Response
     */
    public function all(): Response
    {
        $items = $this->get('allItemsQuery')->query();

        return $this->json(['items' => $items]);
    }
}
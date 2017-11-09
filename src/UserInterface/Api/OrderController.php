<?php

declare(strict_types=1);

namespace Nastoletni\Orders\UserInterface\Api;

use Exception;
use Nastoletni\Orders\Application\Command\Handler\PlaceOrderPayload;
use Nastoletni\Orders\Application\Command\PlaceOrder;
use Nastoletni\Orders\Application\Validator\OrderValidator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * GET /api/order
     *
     * Example response:
     *
     *     {
     *         "orders":  [
     *             {
     *                 "id": "07bd795a-f467-4088-98fd-414594bf802b",
     *                 "name": "John Doe",
     *                 "phone": "+48 123 456 789",
     *                 "email": "john.doe@example.com",
     *                 "address": "John Doe\nExample St\n00-100 Warszawa",
     *                 "items": [
     *                     {
     *                         "id": 1,
     *                         "amount": 3,
     *                     }
     *                 ],
     *                 "comments": "",
     *                 "stage": 0,
     *                 "placedAt": 1510260966,
     *             }
     *         ]
     *     }
     *
     * @return Response
     */
    public function all(): Response
    {
        return $this->json([], 501);
    }

    /**
     * POST /api/order
     *
     * Example input:
     *
     *     {
     *         "name": "John Doe",
     *         "phone": "+48 123 456 789",
     *         "email": "john.doe@example.com",
     *         "address": "John Doe\nExample St\n00-100 Warszawa",
     *         "items": [
     *             {
     *                 "id": 1,
     *                 "amount": 3
     *             }
     *         ]
     *         "comments": ""
     *     }
     *
     * Response on success with 201 status:
     *
     *     {
     *         "orderId": "07bd795a-f467-4088-98fd-414594bf802b"
     *     }
     *
     * and on failure with 400 status:
     *
     *     {
     *         "errors": []
     *             {
     *                 "foo": "bar"
     *             }
     *         ]
     *     }
     *
     * @param Request $request
     *
     * @return Response
     */
    public function makeOrder(Request $request): Response
    {
        $errors = (new OrderValidator())->validate($request);
        if (count ($errors) > 0) {
            return $this->json([
                'errors' => $errors
            ], 400);
        }

        $placeOrderCommand = new PlaceOrder(
            $request->request->get('name'),
            $request->request->get('phone'),
            $request->request->get('email'),
            $request->request->get('address'),
            $request->request->get('items'),
            $request->request->get('comments')
        );

        try {
            /** @var PlaceOrderPayload $payload */
            $payload = $this->get('placeOrder.handler')->handle($placeOrderCommand);
        } catch (Exception $e) {
            return $this->json([], 500);
        }

        return $this->json([
            'orderId' => $payload->getOrderId()
        ], 201);
    }

    /**
     * PATCH /api/order/:id/stage
     *
     * Example input:
     *
     *     {
     *         "stage": 1
     *     }
     *
     * @param Request $request
     * @param string $id
     *
     * @return Response
     */
    public function patchStage(Request $request, string $id): Response
    {
        return $this->json([], 501);
    }

    /**
     * DELETE /api/order/:id
     *
     * @param string $id
     *
     * @return Response
     */
    public function delete(string $id): Response
    {
        return $this->json([], 501);
    }
}
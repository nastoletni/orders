<?php

declare(strict_types=1);

namespace Nastoletni\Orders\UserInterface\Api;

use Nastoletni\Orders\Application\Command\ChangeOrderStageCommand;
use Nastoletni\Orders\Application\Command\DeleteOrderCommand;
use Nastoletni\Orders\Application\Command\Handler\Exception\ItemNotFoundException;
use Nastoletni\Orders\Application\Command\Handler\Exception\OrderNotFoundException;
use Nastoletni\Orders\Application\Command\Handler\Exception\OrderNotValidException;
use Nastoletni\Orders\Application\Command\Handler\PlaceOrderPayload;
use Nastoletni\Orders\Application\Command\PlaceOrderCommand;
use Nastoletni\Orders\Application\Validator\OrderValidator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * GET /api/order
     *
     * Example input (all fields are optional, `start` and `length` values are the default ones):
     *
     *     {
     *         "start": 0,
     *         "length": 20,
     *         "sort": "placedAt",
     *         "sortDirection": 1,
     *         "filter": {
     *             "stage": [1, 2]
     *         }
     *     }
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
     *                         "item": {
     *                             "name": "Bubble gum",
     *                             "price": 1.99
     *                         }
     *                     }
     *                 ],
     *                 "comments": "",
     *                 "stage": 0,
     *                 "placedAt": 1510260966,
     *             }
     *         ]
     *     }
     *
     * @param Request $request
     *
     * @return Response
     */
    public function all(Request $request): Response
    {
        $orders = $this->get('allOrdersQuery')->query($request);

        return $this->json(['orders' => $orders], 200);
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
     *         "message": "Order placed successfully",
     *         "orderId": "07bd795a-f467-4088-98fd-414594bf802b"
     *     }
     *
     * and on failure with 400 status:
     *
     *     {
     *         "errors": [
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
    public function placeOrder(Request $request): Response
    {
        $orderValidator = new OrderValidator();

        try {
            $orderValidator->validate($request);

            $placeOrderCommand = new PlaceOrderCommand(
                $request->request->get('name'),
                $request->request->get('phone'),
                $request->request->get('email'),
                $request->request->get('address'),
                $request->request->get('items'),
                $request->request->get('comments')
            );

            /** @var PlaceOrderPayload $payload */
            $payload = $this->get('placeOrder.handler')->handle($placeOrderCommand);
        } catch (ItemNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        } catch (OrderNotValidException $e) {
            return $this->json(['error' => $e->getMessage(), 'errors' => $e->getErrors()], 400);
        }

        return $this->json([
            'message' => 'Order placed successfully',
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
        $changeOrderStage = new ChangeOrderStageCommand($id, $request->request->getInt('stage'));
        $this->get('changeOrderStage.handler')->handle($changeOrderStage);

        return $this->json(['message' => 'Stage updated successfully'], 200);
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
        $deleteCommand = new DeleteOrderCommand($id);

        try {
            $this->get('deleteOrder.handler')->handle($deleteCommand);
        } catch (OrderNotFoundException $e) {
            return $this->json(['error' => 'Order not found'], 404);
        }

        return $this->json(['message' => 'Order deleted successfully'], 200);
    }
}
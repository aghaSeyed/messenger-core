<?php

namespace Paya\Infrastructure\Http\Controller;

use Paya\Application\DTO\MessageDTO;
use Paya\Application\DTO\ReadMessageDTO;
use Paya\Application\UseCase\CreateMessageRequest;
use Paya\Application\UseCase\ReadMessageRequest;
use Paya\Infrastructure\Http\JsonResponse;
use Paya\Infrastructure\Http\Request;

class MessengerController
{
    private CreateMessageRequest $createMessageRequest;
    private ReadMessageRequest $readMessageRequest;

    public function __construct(CreateMessageRequest $createMessageRequest, ReadMessageRequest $readMessageRequest)
    {
        $this->createMessageRequest = $createMessageRequest;
        $this->readMessageRequest = $readMessageRequest;
    }

    public function list(Request $request)
    {
        $data = $request->getParams();
        $dto = ReadMessageDTO::fromArray($data);
        $response = $this->readMessageRequest->execute($dto);

        JsonResponse::success([
            'data' => $response,
        ], 201);
    }

    public function setHeaders(Request $request)
    {
        JsonResponse::success([
            'data' => ['message' => 'success'],
        ], 201);
    }

    public function sendMessage(Request $request)
    {
        $data = $request->getJsonBody();
        $dto = MessageDTO::fromArray($data);
        $this->createMessageRequest->execute($dto);
        JsonResponse::success([
            'message' => 'Request is saved successfully',

        ]);
    }

}
<?php

declare(strict_types=1);

// Bootstrap the application
require_once __DIR__ . '/../vendor/autoload.php';

use Paya\Application\UseCase\CancelTransferRequest;
use Paya\Application\UseCase\ConfirmTransferRequest;
use Paya\Application\UseCase\CreateMessageRequest;
use Paya\Application\UseCase\CreateTransferRequest;
use Paya\Application\UseCase\ListTransfers;
use Paya\Application\UseCase\ReadMessageRequest;
use Paya\Infrastructure\Database\DatabaseConnection;
use Paya\Infrastructure\Http\Controller\MessengerController;
use Paya\Infrastructure\Http\Controller\ShebaController;
use Paya\Infrastructure\Http\ErrorHandler;
use Paya\Infrastructure\Http\Request;
use Paya\Infrastructure\Http\Router;
use Paya\Infrastructure\Persistence\FileMessageRepository;
use Paya\Infrastructure\Persistence\PDOAccountRepository;
use Paya\Infrastructure\Persistence\PDOTransferRepository;


date_default_timezone_set('UTC');

try {

//    $pdo = DatabaseConnection::getInstance();
//
//    $accountRepository = new PDOAccountRepository($pdo);
//    $transferRepository = new PDOTransferRepository($pdo);
//
//    $createTransferRequest = new CreateTransferRequest(
//        $accountRepository,
//        $transferRepository,
//        $pdo
//    );
//
//    $confirmTransferRequest = new ConfirmTransferRequest(
//        $transferRepository,
//        $accountRepository,
//        $pdo
//    );
//
//    $cancelTransferRequest = new CancelTransferRequest(
//        $transferRepository,
//        $accountRepository,
//        $pdo
//    );
//
//    $listTransfers = new ListTransfers($transferRepository);


//    $controller = new ShebaController(
//        $createTransferRequest,
//        $confirmTransferRequest,
//        $cancelTransferRequest,
//        $listTransfers
//    );
    $fileMessageRepository = new FileMessageRepository();
    $createMessageRequest = new CreateMessageRequest($fileMessageRepository);
    $readMessageRequest = new ReadMessageRequest($fileMessageRepository);

    $controller = new MessengerController($createMessageRequest,$readMessageRequest);
    $request = Request::fromGlobals();
    $router = new Router($controller);


    $router->dispatch($request);
} catch (Throwable $e) {
    ErrorHandler::handle($e);
}

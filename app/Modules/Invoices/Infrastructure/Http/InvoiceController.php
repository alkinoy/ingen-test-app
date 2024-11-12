<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http;

use App\Domain\Exception\InvoiceNotFoundException;
use App\Domain\Exception\InvoiceStatusChangeException;
use App\Infrastructure\Controller;
use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\Invoices\Application\Repository\InvoiceRepositoryInterface;
use Illuminate\Http\Response;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Throwable;

class InvoiceController extends Controller
{

    public function __construct(
        private readonly InvoiceFacadeInterface $invoiceFacade,
        private readonly LoggerInterface $logger,
    )
    {
    }

    public function show(string $id)
    {
        try {
            $invoiceDto = $this->invoiceFacade->listInvoice(Uuid::fromString($id));
            return response()->json($invoiceDto->jsonSerialize());
        } catch (InvoiceNotFoundException $e) {
            return response()->json('Invoice not found', Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            $errorId = uniqid();
            $this->logger->error(
                'Unexpected error occurred while listing invoices.',
                [
                    'exception' => $e,
                    'requestedId' => $id,
                    'errorId' => $errorId,
                ]
            );
            return response()->json('Unexpected exception. Error id is ' . $errorId, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function approve($id)
    {
        try {
            $this->invoiceFacade->approveInvoice(Uuid::fromString($id));
            return response()->json(['message' => 'Invoice approved'], Response::HTTP_ACCEPTED);
        } catch (InvoiceNotFoundException $e) {
            return response()->json('Invoice not found', Response::HTTP_NOT_FOUND);
        } catch (InvoiceStatusChangeException $e) {
            return response()->json('Invoice status already set', Response::HTTP_CONFLICT);
        } catch (\Throwable $e) {
            $errorId = uniqid();
            $this->logger->error(
                'Unexpected error occurred while approving.',
                [
                    'exception' => $e,
                    'requestedId' => $id,
                    'errorId' => $errorId,
                ]
            );
            return response()->json('Unexpected exception. Error id is ' . $errorId, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function reject($id)
    {
        try {
            $this->invoiceFacade->rejectInvoice(Uuid::fromString($id));
            return response()->json(['message' => 'Invoice rejected'], Response::HTTP_ACCEPTED);
        } catch (InvoiceNotFoundException $e) {
            return response()->json('Invoice not found', Response::HTTP_NOT_FOUND);
        } catch (InvoiceStatusChangeException $e) {
            return response()->json('Invoice status already set', Response::HTTP_CONFLICT);
        } catch (\Throwable $e) {
            $errorId = uniqid();
            $this->logger->error(
                'Unexpected error occurred while rejecting.',
                [
                    'exception' => $e,
                    'requestedId' => $id,
                    'errorId' => $errorId,
                ]
            );
            return response()->json('Unexpected exception. Error id is ' . $errorId, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}

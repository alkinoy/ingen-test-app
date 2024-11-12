<?php

declare(strict_types=1);

namespace App\Modules\Approval\Application;

use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use Illuminate\Contracts\Events\Dispatcher;

final readonly class ApprovalFacade implements ApprovalFacadeInterface
{
    public function __construct(
        private Dispatcher $dispatcher
    ) {
    }

    public function approve(ApprovalDto $dto): true
    {
        $this->validate($dto);
        $this->dispatcher->dispatch(new EntityApproved($dto));

        return true;
    }

    public function reject(ApprovalDto $dto): true
    {
        $this->validate($dto);
        $this->dispatcher->dispatch(new EntityRejected($dto));

        return true;
    }

    //looks like this validation had broke DDD approach - business logic should be in the domain object, not in app
    //i've added this validation in the domain object, so, this code could be removed.
    private function validate(ApprovalDto $dto): void
    {
//        if (StatusEnum::DRAFT !== StatusEnum::tryFrom($dto->status->value)) {
//            throw new LogicException('approval status is already assigned');
//        }
    }
}

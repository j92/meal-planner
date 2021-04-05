<?php
declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Core\Plan\PlanServiceInterface;
use App\Entity\Plan;

final class PlanDataPersister implements ContextAwareDataPersisterInterface
{
    private PlanServiceInterface $planService;

    public function __construct(PlanServiceInterface $planService)
    {
        $this->planService = $planService;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Plan;
    }

    public function persist($data, array $context = [])
    {
        if ($data instanceof Plan && $data->getId() === null) {
            return $this->planService->createPlan($data);
        }
    }

    public function remove($data, array $context = [])
    {
        $this->planService->removePlan($data);
    }
}

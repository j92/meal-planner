<?php
declare(strict_types=1);

namespace App\Core\Plan\Service;

use App\Core\Plan\Exception\PlanNotFound;
use App\Core\Plan\PlanServiceInterface;
use App\Entity\Plan;
use App\Repository\PlanRepository;
use Doctrine\ORM\EntityManagerInterface;

final class PlanService implements PlanServiceInterface
{
    private PlanRepository $plans;

    private EntityManagerInterface $em;

    public function __construct(PlanRepository $plans, EntityManagerInterface $em)
    {
        $this->plans = $plans;
        $this->em = $em;
    }

    public function getPlanById(int $planId): Plan
    {
        $plan = $this->plans->find($planId);

        if ($plan === null) {
            throw new PlanNotFound();
        }

        return $plan;
    }

    public function createPlan(Plan $plan): Plan
    {
        $this->em->persist($plan);
        $this->em->flush();

        return $plan;
    }

    public function removePlan(Plan $plan): void
    {
        $this->em->remove($plan);
        $this->em->flush();
    }
}

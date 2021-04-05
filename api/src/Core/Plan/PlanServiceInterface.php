<?php
declare(strict_types=1);

namespace App\Core\Plan;

use App\Entity\Plan;

interface PlanServiceInterface
{
    public function getPlanById(int $planId): Plan;

    public function createPlan(Plan $plan): Plan;

    public function removePlan(Plan $plan): void;
}

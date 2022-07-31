<?php

namespace App\Specifications;

use App\Models\Contests\Contest;

class ContestCanBeEnteredSpecification
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        if ($contest->max_users > 0 && $contest->contestUsers()->count() == $contest->max_users) {
            return false;
        }

        if (!$contest->isStatusReady() && $contest->isSuspended()) {
            return false;
        }

        if (time() >= strtotime($contest->start_date)) {
            return false;
        }

        return true;
    }
}

<?php

namespace App\Models;

class PrizePlace
{
    public ?int $places = null;
    public ?float $prize = null;
    public ?float $voucher = null;
    public ?int $badge_id = null;
    public ?int $num_badges = null;
    public ?array $winners = null;
    public ?int $from = null;
    public ?int $to = null;
}

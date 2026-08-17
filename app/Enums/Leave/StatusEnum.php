<?php

namespace App\Enums\Leave;

enum StatusEnum: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'yellow',
            self::Approved => 'emerald',
            self::Rejected => 'red',
        };
    }
}

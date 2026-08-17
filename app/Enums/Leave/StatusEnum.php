<?php

namespace App\Enums\Leave;

enum StatusEnum: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}

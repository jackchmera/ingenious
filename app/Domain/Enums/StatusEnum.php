<?php

declare(strict_types=1);

namespace App\Domain\Enums;

enum StatusEnum: string
{
    case DRAFT = 'draft';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function isProcessed(): bool
    {
        return self::DRAFT->value !== $this->value;
    }
}

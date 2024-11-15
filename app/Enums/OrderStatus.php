<?php

namespace App\Enums;

enum OrderStatus: int
{
    case FOR_PAYMENT = 1;
    case CANCELED = 2;
    case PAID = 3;

    public function getName(): string
    {
        return  match ($this) {
            self::FOR_PAYMENT => 'На оплату',
            self::CANCELED => 'Отменен',
            self::PAID => 'Оплачен',
        };
    }
}

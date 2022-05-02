<?php
namespace App\Enums;

enum BillType: string {
    case MONTHLY = 'monthly';
    case ANNUALLY = 'annually';
}
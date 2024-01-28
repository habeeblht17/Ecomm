<?php

namespace App\Enums;

enum ProductStockEnum : string {
    case INSTOCK = 'instock';
    case OUTOFSTOCK = 'outofstock';
}

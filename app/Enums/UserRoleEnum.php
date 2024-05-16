<?php

namespace App\Enums;

enum UserRoleEnum : string {

    case ADMIN = 'admin';
    case VENDOR = 'vendor';
    case USER = 'user';
}
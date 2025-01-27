<?php

declare(strict_types=1);

namespace App\Core;

class Role
{
    public const ADMIN = 'admin';
    public const EDITOR = 'editor';
    public const USER = 'user';

    public static function getAllRoles(): array {
        return [
            self::ADMIN,
            self::EDITOR,
            self::USER
        ];
    }
}
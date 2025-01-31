<?php

declare(strict_types=1);

namespace App\Core;

interface IMiddleware
{
    public function execute(): bool;
}
<?php

declare(strict_types=1);

namespace Framework\Wyjatki;

use RuntimeException;

class WyjatkiWalidacji extends RuntimeException
{
    public function __construct(public array $bledy, int $code = 422)
    {
        parent::__construct(code: $code);
    }
}

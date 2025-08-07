<?php

declare(strict_types=1);

namespace Framework\Kontrakty;

interface PPInterfejs
{
    public function przetwarzaj(callable $nastepny);
}

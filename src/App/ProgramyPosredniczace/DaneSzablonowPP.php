<?php

declare(strict_types=1);

namespace App\ProgramyPosredniczace;

use Framework\Kontrakty\PPInterfejs;
use Framework\SilnikSzablonow;

class DaneSzablonowPP implements PPInterfejs
{
    public function __construct(private SilnikSzablonow $silnikSzablonow) {}

    public function przetwarzaj(callable $nastepny)
    {
        $this->silnikSzablonow->dodajGlobalna('tytul', 'Strona główna');
        $nastepny();
    }
}

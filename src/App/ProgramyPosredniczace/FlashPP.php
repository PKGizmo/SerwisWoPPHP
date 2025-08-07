<?php

declare(strict_types=1);

namespace App\ProgramyPosredniczace;

use Framework\Kontrakty\PPInterfejs;
use Framework\SilnikSzablonow;

class FlashPP implements PPInterfejs
{
    public function __construct(private SilnikSzablonow $silnikSzablonow) {}

    public function przetwarzaj(callable $nastepny)
    {
        $this->silnikSzablonow->dodajGlobalna('bledy', $_SESSION['bledy'] ?? []);
        $this->silnikSzablonow->dodajGlobalna('stareDaneFormularza', $_SESSION['stareDaneFormularza'] ?? []);

        unset($_SESSION['bledy']);
        unset($_SESSION['stareDaneFormularza']);

        $nastepny();
    }
}

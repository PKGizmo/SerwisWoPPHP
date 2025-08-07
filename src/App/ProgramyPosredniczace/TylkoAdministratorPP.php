<?php

declare(strict_types=1);

namespace App\ProgramyPosredniczace;

use Framework\Kontrakty\PPInterfejs;
use Framework\SilnikSzablonow;

class TylkoAdministratorPP implements PPInterfejs
{
    public function __construct(private SilnikSzablonow $silnikSzablonow) {}

    public function przetwarzaj(callable $nastepny)
    {
        if (empty($_SESSION['uzytkownik'])) {
            przekierujDo('/');
        }

        if (!$_SESSION['uprawnienia'] == 1) {
            przekierujDo('/');
        }

        $nastepny();
    }
}

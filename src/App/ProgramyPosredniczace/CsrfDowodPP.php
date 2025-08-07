<?php

declare(strict_types=1);

namespace App\ProgramyPosredniczace;

use Framework\Kontrakty\PPInterfejs;
use Framework\SilnikSzablonow;

class CsrfDowodPP implements PPInterfejs
{
    public function __construct(private SilnikSzablonow $silnikSzablonow) {}

    public function przetwarzaj(callable $nastepny)
    {
        //dowod = token
        $_SESSION['dowod'] = $_SESSION['dowod'] ?? bin2hex(random_bytes(32));

        $this->silnikSzablonow->dodajGlobalna('csrfDowod', $_SESSION['dowod']);

        $nastepny();
    }
}

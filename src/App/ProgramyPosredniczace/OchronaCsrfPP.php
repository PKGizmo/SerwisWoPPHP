<?php

declare(strict_types=1);

namespace App\ProgramyPosredniczace;

use Framework\Kontrakty\PPInterfejs;
use Framework\SilnikSzablonow;

class OchronaCsrfPP implements PPInterfejs
{
    public function __construct(private SilnikSzablonow $silnikSzablonow) {}

    public function przetwarzaj(callable $nastepny)
    {
        $metodaZadania = strtoupper($_SERVER['REQUEST_METHOD']);
        $poprawneMetody = ['POST', 'PATCH', 'DELETE'];

        if (!in_array($metodaZadania, $poprawneMetody)) {
            $nastepny();
            return;
        }

        if ($_SESSION['dowod'] !== $_POST['dowod']) {
            przekierujDo('/');
        }

        unset($_SESSION['dowod']);

        $nastepny();
    }
}

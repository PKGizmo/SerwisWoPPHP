<?php

declare(strict_types=1);

namespace App\ProgramyPosredniczace;

use Framework\Kontrakty\PPInterfejs;
use App\Wyjatki\WyjatkiSesje;

class SesjePP implements PPInterfejs
{
    public function przetwarzaj(callable $nastepny)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new WyjatkiSesje("Sesja jest już aktywna!");
        }

        if (headers_sent($nazwaPliku, $linia)) {
            throw new WyjatkiSesje("Nagłówki zostały już wysłane! Rozważ aktywację buforów wyjściowych. Dane wyprowadzone z pliku: {$nazwaPliku} - linia: {$linia}.");
        }

        session_set_cookie_params([
            'secure' => $_ENV['APP_ENV'] === "production",
            'httponly' => true,
            'samesite' => 'lax'
        ]);

        session_start();

        $nastepny();

        session_write_close();
    }
}

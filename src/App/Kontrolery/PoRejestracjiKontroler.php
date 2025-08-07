<?php

declare(strict_types=1);

namespace App\Kontrolery;

use Framework\SilnikSzablonow;
use App\Uslugi\{UslugaWalidacyjna, UslugaUzytkownika};

class PoRejestracjiKontroler
{
    public function __construct(
        private SilnikSzablonow $silnikSzablonow,
        private UslugaWalidacyjna $uslugaWalidacyjna,
        private UslugaUzytkownika $uslugaUzytkownika
    ) {}

    public function poRejestracjiSzablon()
    {
        echo $this->silnikSzablonow->renderujSzablon("/poRejestracji.php", [
            'tytul' => "Dziękuję!"
        ]);
    }
}

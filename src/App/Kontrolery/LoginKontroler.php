<?php

declare(strict_types=1);

namespace App\Kontrolery;

use Framework\SilnikSzablonow;
use App\Uslugi\{UslugaWalidacyjna, UslugaUzytkownika};

class LoginKontroler
{

    public function __construct(
        private SilnikSzablonow $silnikSzablonow,
        private UslugaWalidacyjna $uslugaWalidacyjna,
        private UslugaUzytkownika $uslugaUzytkownika
    ) {}

    public function loginSzablon()
    {
        echo $this->silnikSzablonow->renderujSzablon("/logowanie.php", [
            'tytul' => 'Logowanie'
        ]);
    }

    public function login()
    {
        $this->uslugaWalidacyjna->walidujLogowanie($_POST);
        $this->uslugaUzytkownika->zaloguj($_POST);
        przekierujDo('/konto');
    }
}

<?php

declare(strict_types=1);

namespace App\Kontrolery;

use Framework\SilnikSzablonow;
use App\Uslugi\{UslugaWalidacyjna, UslugaUzytkownika, UslugaMaila};

class RejestracjaKontroler
{

    public function __construct(
        private SilnikSzablonow $silnikSzablonow,
        private UslugaWalidacyjna $uslugaWalidacyjna,
        private UslugaUzytkownika $uslugaUzytkownika,
        private UslugaMaila $uslugaMaila
    ) {}

    public function rejestracjaSzablon()
    {
        echo $this->silnikSzablonow->renderujSzablon("/rejestracja.php", [
            'tytul' => 'Rejestracja'
        ]);
    }

    public function rejestracja()
    {
        $this->uslugaWalidacyjna->walidujRejestracje($_POST);
        $this->uslugaUzytkownika->mailWUzyciu($_POST['email']);
        $uzytkownik = $this->uslugaUzytkownika->dodajUzytkownika($_POST);
        $this->uslugaMaila->wyslijMailaAktywacyjnegoKonta($_POST, (int)$uzytkownik);
        przekierujDo('/poRejestracji');
    }

    public function wyloguj()
    {
        $this->uslugaUzytkownika->wyloguj();

        przekierujDo('/login');
    }
}

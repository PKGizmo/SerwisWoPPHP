<?php

declare(strict_types=1);

namespace App\Kontrolery;

use Framework\{SilnikSzablonow, BazaDanych};
use App\Uslugi\{UslugaWalidacyjna, UslugaUzytkownika, UslugaAdministratora, UslugaObrazow};

class KontoKontroler
{
    public function __construct(
        private SilnikSzablonow $silnikSzablonow,
        private UslugaWalidacyjna $uslugaWalidacyjna,
        private UslugaUzytkownika $uslugaUzytkownika,
        private UslugaAdministratora $uslugaAdministratora,
        private UslugaObrazow $uslugaObrazow,
        private BazaDanych $db
    ) {}

    public function kontoSzablon()
    {
        $uzytkownik = $this->uslugaUzytkownika->pobierzUzytkownika($_SESSION['uzytkownik']);
        $ktore_uprawnienia = $this->uslugaUzytkownika->pobierzUprawnienia();
        $uprawnienia = $this->uslugaUzytkownika->pobierzOpisyUprawnien($ktore_uprawnienia);
        $obraz = $this->uslugaObrazow->pobierzObrazUzyt($_SESSION['uzytkownik']);

        echo $this->silnikSzablonow->renderujSzablon("/konto.php", [
            'tytul' => "Konto",
            'uzytkownik' => $uzytkownik,
            'uprawnienia' => $uprawnienia,
            'obraz' => $obraz
        ]);
    }

    public function kategorieSzablon()
    {
        $kategorie = $this->uslugaAdministratora->pobierzKategorie();

        echo $this->silnikSzablonow->renderujSzablon("/administrator/edytuj_kategorie.php", [
            'tytul' => "Edytuj kategorie",
            'kategorie' => $kategorie
        ]);
    }

    public function dodajKategorie()
    {
        $this->uslugaWalidacyjna->walidujKategorie($_POST);
        $this->uslugaAdministratora->dodaj_kategorie($_POST);
        przekierujDo('/edytuj_kategorie');
    }

    public function zapiszKategorie()
    {
        $dane = array_slice($_POST, 1);
        $this->uslugaWalidacyjna->walidujKategorieWszystkie($dane);
        przekierujDo('/edytuj_kategorie');
    }

    public function przegladUzytkownikowSzablon()
    {
        $uzytkownicy = $this->uslugaUzytkownika->pobierzWszystkichUzytkownikow();
        echo $this->silnikSzablonow->renderujSzablon("/administrator/przeglad_uzytkownikow.php", [
            'tytul' => "Przegląd użytkowników",
            'uzytkownicy' => $uzytkownicy
        ]);
    }

    public function awatar()
    {
        $this->uslugaObrazow->przekazObrazUzyt($_SESSION['uzytkownik'], $_FILES['obraz']);

        przekierujDo('/konto');
    }
}

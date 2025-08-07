<?php

declare(strict_types=1);

namespace App\Uslugi;

use Framework\BazaDanych;
use Framework\Wyjatki\WyjatkiWalidacji;

class UslugaUzytkownika
{
    public function __construct(private BazaDanych $db) {}

    public function mailWUzyciu(string $email)
    {
        $iloscMaili = $this->db->zapytanie(
            "SELECT COUNT(*) FROM uzytkownicy WHERE email = :email",
            [
                'email' => $email
            ]
        )->policz();

        if ($iloscMaili > 0) {
            $bladMaila = [];
            $bladMaila['email'][] = 'Ten e-mail jest już zajęty!';
            //throw new WyjatkiWalidacji(['email']['Ten e-mail jest już zajęty!']);
            throw new WyjatkiWalidacji($bladMaila);
        }
    }

    public function dodajUzytkownika(array $daneFormularza)
    {
        $haslo = password_hash($daneFormularza['haslo'], PASSWORD_BCRYPT, ['cost' => 12]);

        $this->db->zapytanie(
            "INSERT INTO uzytkownicy (imie,email,haslo,wiek,pochodzenie,social_media_url) 
            VALUES (:imie, :email, :haslo, :wiek, :pochodzenie, :social_media_url)",
            [
                'imie' => $daneFormularza['imie'],
                'email' => $daneFormularza['email'],
                'haslo' => $haslo,
                'wiek' => $daneFormularza['wiek'],
                'pochodzenie' => $daneFormularza['pochodzenie'],
                'social_media_url' => $daneFormularza['socialMediaURL']
            ]
        );

        session_regenerate_id();
        //$_SESSION['uzytkownik'] = $this->db->id();
        return $this->db->id();
    }

    public function zaloguj(array $daneFormularza)
    {
        $uzytkownik = $this->db->zapytanie("SELECT * FROM uzytkownicy WHERE email=:email", [
            'email' => $daneFormularza['email']
        ])->znajdz();

        $porownanieHasla = password_verify(
            $daneFormularza['haslo'],
            $uzytkownik['haslo'] ?? ''
        );

        if (!$uzytkownik || !$porownanieHasla) {
            $bladLogowania = [];
            $bladLogowania['haslo'][] = 'Niepoprawne dane!';
            throw new WyjatkiWalidacji($bladLogowania);
        }

        $aktywowano = $this->db->zapytanie("SELECT aktywowano FROM aktywacja_konta WHERE id_uzytkownika = :id_uzytkownika", [
            'id_uzytkownika' => $uzytkownik['id']
        ])->znajdz();

        if ((!$aktywowano || $aktywowano['aktywowano'] === 0) && !($uzytkownik['typ_konta'] === 1)) {
            $bladLogowania = [];
            $bladLogowania['haslo'][] = 'Konto nie zostało aktywowane!';
            throw new WyjatkiWalidacji($bladLogowania);
        }

        session_regenerate_id();

        //Dzięki temu ustalamy, że użytkownik jest zalogowany
        $_SESSION['uzytkownik'] = $uzytkownik['id'];
        $_SESSION['uprawnienia'] = $uzytkownik['typ_konta'];
    }

    public function wyloguj()
    {
        unset($_SESSION['uzytkownik']);
        unset($_SESSION['uprawnienia']);
        session_regenerate_id();
    }

    public function pobierzUprawnienia()
    {
        //Jeśli użytkownik jest zalogowany, pobieramy jego uprawnienia
        //Jeśli nie, traktujemy go jak normalnego czytelnika (uprawnienia = 2)
        if (isset($_SESSION['uzytkownik'])) {
            $uprawnienia = $this->db->zapytanie("SELECT typ_konta FROM uzytkownicy WHERE id=:id", [
                'id' => $_SESSION['uzytkownik']
            ])->znajdz();
        } else
            $uprawnienia['typ_konta'] = 2;

        return $uprawnienia['typ_konta'];
    }

    public function pobierzOpisyUprawnien($id)
    {
        $uprawnienia_nazwy = $this->db->zapytanie("SELECT opis_typu_konta, uprawnienia FROM typy_kont WHERE typ = :typ", [
            'typ' => $id
        ])->znajdz();

        $uprawnienia['opis'] = $uprawnienia_nazwy['opis_typu_konta'];
        $uprawnienia['uprawnienia'] = $uprawnienia_nazwy['uprawnienia'];

        return $uprawnienia;
    }

    public function pobierzUzytkownika(int $id)
    {
        $uzytkownik = $this->db->zapytanie("SELECT * FROM uzytkownicy WHERE id=:id", [
            'id' => $id
        ])->znajdz();

        return $uzytkownik;
    }

    public function pobierzWszystkichUzytkownikow()
    {
        $uzytkownicy = $this->db->zapytanie("SELECT * FROM uzytkownicy")->znajdzWszystkie();

        return $uzytkownicy;
    }
}

<?php

declare(strict_types=1);

namespace App\Kontrolery;

use Framework\{SilnikSzablonow, BazaDanych};
use App\Uslugi\{UslugaWalidacyjna, UslugaUzytkownika};
use Framework\Wyjatki\WyjatkiWalidacji;
use PhpToken;

class WeryfikacjaKontroler
{
    public function __construct(
        private SilnikSzablonow $silnikSzablonow,
        private UslugaWalidacyjna $uslugaWalidacyjna,
        private UslugaUzytkownika $uslugaUzytkownika,
        private BazaDanych $db
    ) {}

    public function weryfikacjaSzablon()
    {
        $wiadomosc = '';
        $ok = 1;
        $email = $_GET['email'] ?? '';
        $token = $_GET['token'] ?? '';

        $uzytkownik = $this->db->zapytanie("SELECT * FROM uzytkownicy WHERE email=:email", [
            'email' => $email
        ])->znajdz();

        if (!$uzytkownik) {
            $wiadomosc = 'Niepoprawne dane konta!';
            $ok = 0;
        }

        $dane = $this->db->zapytanie("SELECT token, aktywowano FROM aktywacja_konta WHERE id_uzytkownika = :id_uzytkownika", [
            'id_uzytkownika' => $uzytkownik['id']
        ])->znajdz();

        if ($dane['aktywowano'] === 1) {
            $wiadomosc = 'Konto jest już aktywne!';
            $ok = 0;
        }

        $porownanieTokena = password_verify(
            $dane['token'],
            $token ?? ''
        );

        if (!$porownanieTokena) {
            $wiadomosc = "Niepoprawne dane aktywacyjne!";
            $ok = 0;
        }

        if ($ok === 1) {
            $wiadomosc = "Konto zostało aktywowane!<br>Możesz się już zalogować!";
            $this->db->zapytanie(
                "UPDATE aktywacja_konta SET aktywowano = 1 WHERE
            id_uzytkownika = :id_uzytkownika",
                ['id_uzytkownika' => $uzytkownik['id']]
            );

            $this->db->zapytanie(
                "UPDATE uzytkownicy SET aktywne = 1 WHERE
            id = :id_uzytkownika",
                ['id_uzytkownika' => $uzytkownik['id']]
            );
        }

        //session_regenerate_id();

        //Dzięki temu ustalamy, że użytkownik jest zalogowany
        //$_SESSION['uzytkownik'] = $uzytkownik['id'];
        //$_SESSION['uprawnienia'] = $uzytkownik['typ_konta'];


        echo $this->silnikSzablonow->renderujSzablon("/weryfikacja.php", [
            'tytul' => "Weryfikacja",
            'wiadomosc' => $wiadomosc
        ]);
    }
}

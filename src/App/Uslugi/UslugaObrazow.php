<?php

declare(strict_types=1);

namespace App\Uslugi;

use App\Konfig\Sciezki;
use Framework\BazaDanych;
use Framework\Wyjatki\WyjatkiWalidacji;

class UslugaObrazow
{
    public function __construct(private BazaDanych $db) {}

    public function walidujObraz(?array $plik)
    {
        if (!$plik || $plik['error'] !== UPLOAD_ERR_OK) {
            throw new WyjatkiWalidacji([
                'obraz' => ['Nie udało się przesłać pliku!']
            ]);
        }

        //Maksymalny rozmiar pliku w MB
        $maksymalnaWielkoscPlikuMB = 1;
        $maksymalnaWielkoscPliku = $maksymalnaWielkoscPlikuMB * 1024 * 1024;

        if ($plik['size'] > $maksymalnaWielkoscPliku) {
            throw new WyjatkiWalidacji([
                'obraz' => ["Rozmiar pliku przekracza dopuszczalną wartość! ({$maksymalnaWielkoscPlikuMB}MB)"]
            ]);
        }

        $oryginalnaNazwaPliku = $plik['name'];

        if (!preg_match('/^[A-za-z0-9\s._-]+$/', $oryginalnaNazwaPliku)) {
            throw new WyjatkiWalidacji([
                'obraz' => ['Niepoprawna nazwa pliku!', '(Upewnij się, że nie posiada polskich znaków)']
            ]);
        }

        $typMimePliku = $plik['type'];
        $dozwolonyTypyMime = ['image/jpeg', 'image/png'];

        if (!in_array($typMimePliku, $dozwolonyTypyMime)) {
            throw new WyjatkiWalidacji([
                'obraz' => ['Niepoprawny typ pliku!', '(Upewnij się, że to plik typu .jpg lub .png)']
            ]);
        }
    }

    public function przekazObrazArt(array $artykul, int $idArtykulu, array $plik)
    {
        $rozszerzeniePliku = pathinfo($plik['name'], PATHINFO_EXTENSION);
        [$rok, $miesiac, $tytul] = explode('/', $artykul['link']);
        $nowaNazwaPliku = bin2hex(random_bytes(4)) . "." . $rozszerzeniePliku;

        $sciezkaPliku = "/assets/images/blog/" . $rok . "/" . $miesiac . "/" . (string)$idArtykulu;

        if (!is_dir($sciezkaPliku)) {
            mkdir($sciezkaPliku, recursive: true);
        }

        $calosc = $sciezkaPliku . "/" . $nowaNazwaPliku;
        $doBazy = $rok . "/" . $miesiac . "/" . (string)$idArtykulu . "/" . $nowaNazwaPliku;

        if (!move_uploaded_file($plik['tmp_name'], $calosc)) {
            throw new WyjatkiWalidacji([
                'obraz' => ['Błąd przesyłania pliku!']
            ]);
        }

        $czyJuzJestGlownyObraz = $this->db->zapytanie(
            "SELECT * FROM obrazy_blog WHERE
            id_artykulu = :id_artykulu AND czy_glowny = 1",
            [
                'id_artykulu' => $idArtykulu
            ]
        )->znajdz();

        if ($czyJuzJestGlownyObraz) {
            //czy_glowny: 1 - obrazek główny artykułu, 0 - obrazek w tekście
            $this->db->zapytanie(
                "UPDATE obrazy_blog SET czy_glowny = 0 WHERE
            id_artykulu = :id_artykulu AND czy_glowny = 1",
                [
                    'id_artykulu' => $idArtykulu
                ]
            );
        }

        $this->db->zapytanie(
            "INSERT INTO obrazy_blog (oryginalna_nazwa_pliku, nowa_nazwa_pliku, typ_mediow, id_artykulu, czy_glowny, sciezka) 
            VALUES (:oryginalna_nazwa_pliku, :nowa_nazwa_pliku, :typ_mediow, :id_artykulu, :czy_glowny, :sciezka)",
            [
                'oryginalna_nazwa_pliku' => $plik['name'],
                'nowa_nazwa_pliku' => $nowaNazwaPliku,
                'typ_mediow' => $plik['type'],
                'id_artykulu' => $idArtykulu,
                'czy_glowny' => 1,
                'sciezka' => $doBazy
            ]
        );
    }

    public function pobierzObrazArt(int $idArtykulu)
    {
        $obraz = $this->db->zapytanie(
            "SELECT * FROM obrazy_blog WHERE
            id_artykulu = :id_artykulu AND czy_glowny = 1",
            [
                'id_artykulu' => $idArtykulu
            ]
        )->znajdz();

        $sc = $obraz['sciezka'] ?? '';
        //$sciezka_pelna = Sciezki::PLIKIBLOG . $sc;
        if ($sc) {
            $sciezka_pelna = "/assets/images/blog/" . $sc;
            $obraz['sciezka_pelna'] = $sciezka_pelna;
        }

        return $obraz;
    }

    public function przekazObrazUzyt(int $idUzytkownika, array $plik)
    {
        $rozszerzeniePliku = pathinfo($plik['name'], PATHINFO_EXTENSION);
        $nowaNazwaPliku = bin2hex(random_bytes(4)) . "." . $rozszerzeniePliku;

        $sciezkaPliku = "assets/images/uzytkownicy/" . (string)$idUzytkownika;
        $calosc = $sciezkaPliku . "/" . $nowaNazwaPliku;

        if (!is_dir($calosc)) {
            mkdir($sciezkaPliku . "/", recursive: true);
        }

        if (!move_uploaded_file($plik['tmp_name'], $calosc)) {
            throw new WyjatkiWalidacji([
                'obraz' => ['Błąd przesyłania pliku!']
            ]);
        }

        $czyJuzJestObraz = $this->db->zapytanie(
            "SELECT * FROM obrazy_uzytkownikow WHERE
            id_uzytkownika = :id_uzytkownika",
            [
                'id_uzytkownika' => $idUzytkownika
            ]
        )->znajdz();

        if ($czyJuzJestObraz) {
            //czy_glowny: 1 - obrazek główny artykułu, 0 - obrazek w tekście
            $this->db->zapytanie(
                "UPDATE obrazy_uzytkownikow SET oryginalna_nazwa_pliku = :oryginalna_nazwa_pliku,
                nowa_nazwa_pliku = :nowa_nazwa_pliku WHERE
            id_uzytkownika = :id_uzytkownika",
                [
                    'oryginalna_nazwa_pliku' => $plik['name'],
                    'nowa_nazwa_pliku' => $nowaNazwaPliku,
                    'id_uzytkownika' => $idUzytkownika
                ]
            );
        } else {
            $this->db->zapytanie(
                "INSERT INTO obrazy_uzytkownikow (oryginalna_nazwa_pliku, nowa_nazwa_pliku, typ_mediow, id_uzytkownika) 
            VALUES (:oryginalna_nazwa_pliku, :nowa_nazwa_pliku, :typ_mediow, :id_artykulu)",
                [
                    'oryginalna_nazwa_pliku' => $plik['name'],
                    'nowa_nazwa_pliku' => $nowaNazwaPliku,
                    'typ_mediow' => $plik['type'],
                    'id_artykulu' => $idUzytkownika
                ]
            );
        }
    }

    public function pobierzObrazUzyt(int $idUzytkownika)
    {
        $obraz = $this->db->zapytanie(
            "SELECT * FROM obrazy_uzytkownikow WHERE
            id_uzytkownika = :id_uzytkownika",
            [
                'id_uzytkownika' => $idUzytkownika
            ]
        )->znajdz();

        $sc = $obraz['id_uzytkownika'] ?? '';
        //$sciezka_pelna = Sciezki::PLIKIBLOG . $sc;
        if ($sc) {
            $sciezka_pelna = "/assets/images/uzytkownicy/" . $sc;
            $obraz['sciezka_pelna'] = $sciezka_pelna;
        }

        return $obraz;
    }
}

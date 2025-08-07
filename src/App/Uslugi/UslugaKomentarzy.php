<?php

declare(strict_types=1);

namespace App\Uslugi;

use Framework\BazaDanych;
use Framework\Wyjatki\WyjatkiWalidacji;
use PDOException;

class UslugaKomentarzy
{
    public function __construct(
        private BazaDanych $db
    ) {}

    public function policzKomentarze(int $id, int $ktore = 1)
    {
        //Rola uzytkownika: 1 - admin, 2 - normalny, 3 - premium
        //Stan komentarza: 0 - szkic, 1 - zatwierdzony
        //Ktore: 0 - szkice, 1 - zatwierdzone, 2- wszystkie
        if ($ktore === 0)
            $ilosc = $this->db->zapytanie(
                "SELECT COUNT(*) FROM komentarze WHERE id_artykulu = :id_artykulu AND stan = 0",
                ['id_artykulu' => $id]
            )->policz();
        elseif ($ktore === 1)
            $ilosc = $this->db->zapytanie(
                "SELECT COUNT(*) FROM komentarze WHERE id_artykulu = :id_artykulu AND stan = 1",
                ['id_artykulu' => $id]
            )->policz();
        elseif ($ktore === 2)
            $ilosc = $this->db->zapytanie(
                "SELECT COUNT(*) FROM komentarze WHERE id_artykulu = :id_artykulu AND (stan = 0 OR stan = 1)",
                ['id_artykulu' => $id]
            )->policz();

        return (int)$ilosc;
    }

    public function napiszKomentarz(array $parametry, array $daneFormularza)
    {
        //Piszemy nowy komentarz bezpośrednio pod artykułem
        if ($parametry['id_komentarza'] == 0) {
            $this->db->zapytanie("INSERT INTO komentarze (id_uzytkownika, id_artykulu, tresc)
            VALUES(:id_uzytkownika, :id_artykulu, :tresc)", [
                'id_uzytkownika' => $daneFormularza['id_komentujacego'],
                'id_artykulu' => $parametry['id_artykulu'],
                'tresc' => e($daneFormularza['tresc'])
            ]);
        }
        //Odpowiadamy na inny komentarz
        else {
            $this->db->zapytanie("INSERT INTO komentarze (id_uzytkownika, id_artykulu, id_komentarza, tresc)
            VALUES(:id_uzytkownika, :id_artykulu, :id_komentarza, :tresc)", [
                'id_uzytkownika' => $daneFormularza['id_komentujacego'],
                'id_artykulu' => $parametry['id_artykulu'],
                'id_komentarza' => $parametry['id_komentarza'],
                'tresc' => e($daneFormularza['tresc'])
            ]);
        }
    }

    public function pobierzKomentarze(int $id_artykulu, int $stan = 1, int $rolaUzytkownika = 2)
    {
        //Stan komentarza - 0: szkic, 1: zatwierdzony
        $komentarze = $this->db->zapytanie(
            "SELECT k.*, u.imie, u.typ_konta, o.nowa_nazwa_pliku as awatar FROM komentarze as k
            LEFT JOIN uzytkownicy as u ON k.id_uzytkownika = u.id
            LEFT JOIN obrazy_uzytkownikow as o ON u.id = o.id_uzytkownika
            WHERE k.id_artykulu = :id_artykulu",
            [
                'id_artykulu' => $id_artykulu
            ]
        )->znajdzWszystkie();

        return $komentarze;
    }

    public function utworzDrzewoKomentarzy(int $id_artykulu)
    {
        $komentarze = $this->pobierzKomentarze($id_artykulu);
        if (!$komentarze) return [];
        $drzewoKomentarzy = [];

        foreach ($komentarze as $node) {
            $drzewoKomentarzy[$node['id_komentarza']][] = $node;
        }

        $fnBuilder = function ($siblings) use (&$fnBuilder, $drzewoKomentarzy) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling['id'];
                if (isset($drzewoKomentarzy[$id])) {
                    $sibling['odpowiedzi'] = $fnBuilder($drzewoKomentarzy[$id]);
                }
                $siblings[$k] = $sibling;
            }
            return $siblings;
        };

        $drzewoKomentarzy = $fnBuilder($drzewoKomentarzy[0]);

        return $drzewoKomentarzy;
    }

    public function recursiveEcho($input, array &$tablica = [], int $poziom = 0)
    {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                if (isset($value['odpowiedzi'])) {
                    if (is_array($value))
                        $this->recursiveEcho($value, $tablica, $poziom);
                } else {
                    if (!($key === 'odpowiedzi') && !(is_array($value))) {
                        //echo ($key . " => " . $value . "<br>");
                        if ($key === 'id')
                            $tablica[] = array('id' => $value, 'poziom' => $poziom);
                    } else {
                        if (($key === 'odpowiedzi'))
                            $poziom++;

                        $this->recursiveEcho($value, $tablica, $poziom);
                    }
                }
            }
        }
    }

    public function zatwierdzKomentarz(array $parametry)
    {
        $this->db->zapytanie(
            "UPDATE komentarze SET stan = 1 WHERE id = :id AND id_artykulu=:id_artykulu AND stan = 0",
            [
                'id' => $parametry['id_komentarza'],
                'id_artykulu' => $parametry['id_artykulu']
            ]
        );
    }

    public function anulujKomentarz(array $parametry)
    {
        $this->db->zapytanie(
            "UPDATE komentarze SET stan = 0 WHERE id = :id AND id_artykulu=:id_artykulu AND stan = 1",
            [
                'id' => $parametry['id_komentarza'],
                'id_artykulu' => $parametry['id_artykulu']
            ]
        );
    }
}

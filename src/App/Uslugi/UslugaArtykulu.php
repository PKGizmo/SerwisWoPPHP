<?php

declare(strict_types=1);

namespace App\Uslugi;

use DateTime;
use Framework\BazaDanych;

class UslugaArtykulu
{
    public function __construct(private BazaDanych $db) {}

    public function dodajArtykul(array $daneFormularza, ?array $danePlikow)
    {
        $sformatowanaData = str_replace('T', ' ', $daneFormularza['data']) . ":00";

        $this->db->zapytanie(
            "INSERT INTO artykuly (id_autora,tytul,streszczenie,tresc,stan,link,data_utworzenia) 
            VALUES (:id_autora, :tytul, :streszczenie, :tresc, :stan, :link, :data_utworzenia)",
            [
                'id_autora' => $_SESSION['uzytkownik'],
                'tytul' => $daneFormularza['tytul'],
                'streszczenie' => $daneFormularza['streszczenie'],
                'tresc' => $daneFormularza['tresc'],
                'stan' => $daneFormularza['stan'],
                'link' => $daneFormularza['link'],
                'data_utworzenia' => $sformatowanaData
            ]
        );
    }

    public function dodajKategorie(int $id, array $daneFormularza)
    {
        foreach ($daneFormularza['kat'] as $kat) {
            $this->db->zapytanie(
                "INSERT INTO kategorie (id_artykulu,kategoria) VALUES (:id_artykulu, :kategoria)",
                [
                    'id_artykulu' => $id,
                    'kategoria' => $kat + 1,
                ]
            );
        }
    }

    public function pobierzArtykuly(int $uprawnieniaUzytkownika, int $ilosc, int $offset, $rok = 0, $miesiac = 0)
    {
        $poszukiwanie = addcslashes($_GET['s'] ?? '', '%_');
        $parametry = [
            'szukaj' => "%{$poszukiwanie}%"
        ];

        //Uprawnienia użytkownika: 
        //1 - administrator, 2 - normalne, 3 - rozszerzone
        //Stan artykulu: 
        //1 - szkic (tylko dla admina), 2 - normalny (tylko dla uzytkownikow bez premium), 3 - premium
        $where = '';
        $intRok = 0;

        if ($rok > 0) {
            $intRok = (int)$rok;
            $rok = (string)$rok . e('/%');
        }

        $intMiesiac = (int)$miesiac;
        $miesiac = (string)$miesiac;
        $miesiac = "%/{$miesiac}/%";

        if ($intRok > 0) {
            $where = "AND link LIKE '{$rok}'";
        }

        if ($intRok > 0 && $intMiesiac > 0) {
            $where = "AND (link LIKE '{$rok}' AND link LIKE '{$miesiac}')";
        }

        if ($uprawnieniaUzytkownika === 1) {
            $artykuly = $this->db->zapytanie(
                "SELECT *, DATE_FORMAT(data_utworzenia, '%d-%m-%Y %H:%i') as sformatowana_data
            FROM artykuly WHERE
            (streszczenie LIKE :szukaj OR tresc LIKE :szukaj) {$where}
            ORDER BY data_utworzenia DESC
            LIMIT {$ilosc} OFFSET {$offset}
            ",
                $parametry
            )->znajdzWszystkie();

            $iloscArtykulow = $this->db->zapytanie(
                "SELECT COUNT(*)
                FROM artykuly WHERE (streszczenie LIKE :szukaj OR tresc LIKE :szukaj) {$where}
                ORDER BY data_utworzenia DESC",
                $parametry,
            )->policz();
        } elseif ($uprawnieniaUzytkownika === 2) {
            $artykuly = $this->db->zapytanie(
                "SELECT *, DATE_FORMAT(data_utworzenia, '%d-%m-%Y %H:%i') as sformatowana_data
                FROM artykuly WHERE stan = 2 
                AND (streszczenie LIKE :szukaj OR tresc LIKE :szukaj) {$where}
                ORDER BY data_utworzenia DESC
                LIMIT {$ilosc} OFFSET {$offset}
                ",
                $parametry
            )->znajdzWszystkie();

            $iloscArtykulow = $this->db->zapytanie(
                "SELECT COUNT(*)
                FROM artykuly WHERE stan = 2 
                AND (streszczenie LIKE :szukaj OR tresc LIKE :szukaj) {$where}
                ORDER BY data_utworzenia DESC",
                $parametry
            )->policz();
        } else {
            $artykuly = $this->db->zapytanie(
                "SELECT *, DATE_FORMAT(data_utworzenia, '%d-%m-%Y %H:%i') as sformatowana_data
                FROM artykuly WHERE (stan=2 OR stan=3) 
            AND (streszczenie LIKE :szukaj OR tresc LIKE :szukaj) {$where}
            ORDER BY data_utworzenia DESC
            LIMIT {$ilosc} OFFSET {$offset}
            ",
                $parametry
            )->znajdzWszystkie();

            $iloscArtykulow = $this->db->zapytanie(
                "SELECT COUNT(*)
                FROM artykuly WHERE (stan=2 OR stan=3) 
                AND (streszczenie LIKE :szukaj OR tresc LIKE :szukaj) {$where}
                ORDER BY data_utworzenia DESC",
                $parametry
            )->policz();
        }

        $i = 0;

        foreach ($artykuly as $artykul) {

            $autor = $this->pobierzAutora($artykul['id_autora']);

            $artykuly[$i]['imie_autora'] = $autor['imie'];

            $kategorie = $this->pobierzKategorie($artykul['id']);
            $artykuly = $this->pobierzNazwyKategorii($i, $artykuly, $kategorie);
            $i++;
        }
        return [$artykuly, $iloscArtykulow];
    }

    public function pobierzArtykul(string $link)
    {
        return $this->db->zapytanie(
            "SELECT *, DATE_FORMAT(data_utworzenia, '%d-%m-%Y %H:%i') as sformatowana_data
            FROM artykuly
            WHERE link = :link",
            [
                'link' => $link
            ]
        )->znajdz();
    }

    public function pobierzAutora(int $id_autora)
    {
        $autor = $this->db->zapytanie("SELECT id, imie, typ_konta FROM uzytkownicy WHERE id = :id", [
            'id' => $id_autora
        ])->znajdz();

        return $autor;
    }

    public function pobierzKategorie(int $id_artykulu)
    {
        $kategorie = $this->db->zapytanie(
            "SELECT * FROM kategorie WHERE id_artykulu=:id_artykulu",
            ['id_artykulu' => $id_artykulu]
        )->znajdzWszystkie();

        return $kategorie;
    }

    public function pobierzNazwyKategorii(int $i, array $artykuly, array $kategorie)
    {
        $j = 0;

        foreach ($kategorie as $kategoria) {

            $nazwy_kategorii = $this->db->zapytanie("SELECT nazwa FROM kategorie_opisy WHERE id=:id", [
                'id' => $kategoria['kategoria']
            ])->znajdz();

            $artykuly[$i]['kategorie'][$j]['id'] = $kategoria['id'];
            $artykuly[$i]['kategorie'][$j]['ktora'] = $kategoria['kategoria'];
            $artykuly[$i]['kategorie'][$j]['nazwa'] = $nazwy_kategorii['nazwa'];
            $j++;
        }

        return $artykuly;
    }

    public function aktualizujArtykul(int $id_artykulu, array $daneFormularza, ?array $danePlikow)
    {
        $sformatowanaData = str_replace('T', ' ', $daneFormularza['data']) . ":00";

        $this->db->zapytanie(
            "UPDATE artykuly SET tytul=:tytul,streszczenie=:streszczenie,tresc=:tresc,stan=:stan,link=:link,data_modyfikacji=:data_modyfikacji
            WHERE id = :id_artykulu",
            [
                'tytul' => $daneFormularza['tytul'],
                'streszczenie' => $daneFormularza['streszczenie'],
                'tresc' => $daneFormularza['tresc'],
                'stan' => $daneFormularza['stan'],
                'link' => $daneFormularza['link'],
                'data_modyfikacji' => $sformatowanaData,
                'id_artykulu' => $id_artykulu
            ]
        );
    }

    public function aktualizujKategorie(int $id, array $daneFormularza)
    {
        $this->db->zapytanie(
            "DELETE FROM kategorie WHERE id_artykulu=:id_artykulu",
            [
                'id_artykulu' => $id,
            ]
        );

        $this->dodajKategorie($id, $daneFormularza);
    }

    public function pobierzWszystkieKategorie()
    {
        $kategorie = $this->db->zapytanie("SELECT * FROM kategorie_opisy ORDER BY id ASC")->znajdzWszystkie();
        return $kategorie;
    }

    public function pobierzRokMiesiacArtykulow(int $uprawnienia = 0)
    {
        $where = '';

        if ($uprawnienia === 0 || $uprawnienia === 2)
            $where = 'WHERE (stan = 2)';
        elseif ($uprawnienia === 3)
            $where = 'WHERE (stan = 2 OR stan = 3)';

        $rozneDaneArt = $this->db->zapytanie("
        SELECT id, tytul, link, stan 
        FROM artykuly {$where}
        ORDER BY data_utworzenia DESC")->znajdzWszystkie();

        $rok = [];
        $miesiac = [];
        $reszta = [];
        $miesiacInt = [];

        foreach ($rozneDaneArt as $rozne) {
            [$rok[], $miesiac[], $reszta[]] = explode('/', $rozne['link']);
        }

        //$iloscMiesiac = array_count_values($miesiac);
        $iloscRok = array_count_values($rok);
        foreach ($miesiac as $m) {
            //$obiektDaty   = DateTime::createFromFormat('!m', $m);
            //$nazwaMiesiaca[] = $obiektDaty->format('F'); // March
            $miesiacInt[] = (int)$m;
        }
        $iloscMiesiac = array_count_values($miesiacInt);

        return [$rozneDaneArt, $rok, $iloscRok, $miesiac, $iloscMiesiac];
    }

    public function pobierzArtykulyKategoria(int $uprawnieniaUzytkownika, int $ilosc, int $offset, int $kat = 0)
    {
        $poszukiwanie = addcslashes($_GET['s'] ?? '', '%_');
        $parametry = [
            'szukaj' => "%{$poszukiwanie}%"
        ];

        //Uprawnienia użytkownika: 
        //1 - administrator, 2 - normalne, 3 - rozszerzone
        //Stan artykulu: 
        //1 - szkic (tylko dla admina), 2 - normalny (tylko dla uzytkownikow bez premium), 3 - premium

        if ($uprawnieniaUzytkownika === 1) {
            $artykuly = $this->db->zapytanie(
                "SELECT a.*, DATE_FORMAT(a.data_utworzenia, '%d-%m-%Y %H:%i') as sformatowana_data,
                k.kategoria
            FROM artykuly as a 
            LEFT JOIN kategorie as k
            ON a.id = k.id_artykulu
            WHERE
            (a.streszczenie LIKE :szukaj OR a.tresc LIKE :szukaj) AND k.kategoria = :kat
            ORDER BY data_utworzenia DESC
            LIMIT {$ilosc} OFFSET {$offset}
            ",
                [
                    'szukaj' => (string)$parametry['szukaj'],
                    'kat' => $kat
                ]
            )->znajdzWszystkie();

            $iloscArtykulow = $this->db->zapytanie(
                "SELECT COUNT(*), k.kategoria
                FROM artykuly as a
                LEFT JOIN kategorie as k
                ON a.id = k.id_artykulu
                WHERE (a.streszczenie LIKE :szukaj OR a.tresc LIKE :szukaj) AND k.kategoria = :kat
                ORDER BY a.data_utworzenia DESC",
                [
                    'szukaj' => $parametry['szukaj'],
                    'kat' => $kat
                ]
            )->policz();
        } elseif ($uprawnieniaUzytkownika === 2) {
            $artykuly = $this->db->zapytanie(
                "SELECT a.*, DATE_FORMAT(a.data_utworzenia, '%d-%m-%Y %H:%i') as sformatowana_data,
                k.kategoria
            FROM artykuly as a 
            LEFT JOIN kategorie as k
            ON a.id = k.id_artykulu
            WHERE
            (a.streszczenie LIKE :szukaj OR a.tresc LIKE :szukaj) AND k.kategoria = :kat AND stan = 2
            ORDER BY data_utworzenia DESC
            LIMIT {$ilosc} OFFSET {$offset}
            ",
                [
                    'szukaj' => (string)$parametry['szukaj'],
                    'kat' => $kat
                ]
            )->znajdzWszystkie();

            $iloscArtykulow = $this->db->zapytanie(
                "SELECT COUNT(*), k.kategoria
                FROM artykuly as a
                LEFT JOIN kategorie as k
                ON a.id = k.id_artykulu
                WHERE (a.streszczenie LIKE :szukaj OR a.tresc LIKE :szukaj) AND k.kategoria = :kat AND stan = 2
                ORDER BY a.data_utworzenia DESC",
                [
                    'szukaj' => $parametry['szukaj'],
                    'kat' => $kat
                ]
            )->policz();
        } else {
            $artykuly = $this->db->zapytanie(
                "SELECT a.*, DATE_FORMAT(a.data_utworzenia, '%d-%m-%Y %H:%i') as sformatowana_data,
                k.kategoria
            FROM artykuly as a 
            LEFT JOIN kategorie as k
            ON a.id = k.id_artykulu
            WHERE
            (a.streszczenie LIKE :szukaj OR a.tresc LIKE :szukaj) AND k.kategoria = :kat 
            AND (stan = 2 OR stan = 3)
            ORDER BY data_utworzenia DESC
            LIMIT {$ilosc} OFFSET {$offset}
            ",
                [
                    'szukaj' => (string)$parametry['szukaj'],
                    'kat' => $kat
                ]
            )->znajdzWszystkie();

            $iloscArtykulow = $this->db->zapytanie(
                "SELECT COUNT(*), k.kategoria
                FROM artykuly as a
                LEFT JOIN kategorie as k
                ON a.id = k.id_artykulu
                WHERE (a.streszczenie LIKE :szukaj OR a.tresc LIKE :szukaj) AND k.kategoria = :kat 
                AND (stan = 2 OR stan = 3)
                ORDER BY a.data_utworzenia DESC",
                [
                    'szukaj' => $parametry['szukaj'],
                    'kat' => $kat
                ]
            )->policz();
        }
        $i = 0;

        foreach ($artykuly as $artykul) {

            $autor = $this->pobierzAutora($artykul['id_autora']);

            $artykuly[$i]['imie_autora'] = $autor['imie'];

            $kategorie = $this->pobierzKategorie($artykul['id']);
            $artykuly = $this->pobierzNazwyKategorii($i, $artykuly, $kategorie);
            $i++;
        }

        return [$artykuly, $iloscArtykulow];
    }
}

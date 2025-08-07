<?php

declare(strict_types=1);

namespace App\Uslugi;

use Framework\BazaDanych;
use Framework\Wyjatki\WyjatkiWalidacji;
use PDOException;

class UslugaAdministratora
{
    public function __construct(
        private BazaDanych $db
    ) {}

    public function pobierzKategorie()
    {
        $kategorie = $this->db->zapytanie(
            "SELECT * FROM kategorie_opisy ORDER BY id ASC"
        )->znajdzWszystkie();

        return $kategorie;
    }

    public function dodaj_kategorie(array $daneFormularza)
    {
        try {
            $this->db->zapytanie(
                "INSERT INTO kategorie_opisy (id, nazwa) VALUES (:id, :nazwa)",
                [
                    'id' => $daneFormularza['kat_id'],
                    'nazwa' => $daneFormularza['nazwa']
                ]
            );
        } catch (PDOException $w) {
            $bladKategorii = [];
            $bladKategorii['nazwa'][] = 'Ta nazwa kategorii jest już zajęta!';
            throw new WyjatkiWalidacji($bladKategorii);
        }
    }

    /*public function dodajKategorie(int $id, array $daneFormularza)
    {
        foreach ($daneFormularza['kat'] as $kat) {
            $this->db->zapytanie(
                "INSERT INTO kategorie (id_artykulu,kategoria) VALUES (:id_artykulu, :kategoria)",
                [
                    'id_artykulu' => $id,
                    'kategoria' => $kat,
                ]
            );
        }
    }



    public function pobierzNazwyKategorii(array $artykuly, array $kategorie)
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

    public function aktualizujKategorie(int $id, array $daneFormularza)
    {
        $this->db->zapytanie(
            "DELETE FROM kategorie WHERE id_artykulu=:id_artykulu",
            [
                'id_artykulu' => $id,
            ]
        );

        $this->dodajKategorie($id, $daneFormularza);
    }*/
}

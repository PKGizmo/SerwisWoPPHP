<?php

declare(strict_types=1);

namespace App\Kontrolery;

use Framework\{BazaDanych, SilnikSzablonow};
use App\Uslugi\{UslugaWalidacyjna, UslugaArtykulu, UslugaKomentarzy, UslugaObrazow};

class ArtykulKontroler
{
    public function __construct(
        private SilnikSzablonow $silnikSzablonow,
        private UslugaWalidacyjna $uslugaWalidacyjna,
        private UslugaArtykulu $uslugaArtykulu,
        private UslugaKomentarzy $uslugaKomentarzy,
        private UslugaObrazow $uslugaObrazow,
        private BazaDanych $db
    ) {}

    public function napiszArtykul()
    {
        $kategorie = $this->uslugaArtykulu->pobierzWszystkieKategorie();
        echo $this->silnikSzablonow->renderujSzablon("/artykuly/napisz_artykul.php", [
            'tytul' => 'Napisz artykuł',
            'kategorie' => $kategorie
        ]);
    }

    public function zapiszArtykul()
    {
        $this->uslugaWalidacyjna->walidujArtykul($_POST);
        $this->uslugaArtykulu->dodajArtykul($_POST, $_FILES);
        $this->uslugaArtykulu->dodajKategorie((int)$this->db->id(), $_POST);
        przekierujDo('/napisz_artykul');
    }

    public function edytujArtykul(array $parametry)
    {
        $linkArtykulu = $parametry['link_a_rok'] . "/" . $parametry['link_a_miesiac'] . "/" . $parametry['link_a_tytul'];
        $artykul = $this->uslugaArtykulu->pobierzArtykul($linkArtykulu);
        $autor = $this->uslugaArtykulu->pobierzAutora($artykul['id_autora']);
        $kategorie = $this->uslugaArtykulu->pobierzKategorie($artykul['id']);
        $kategorieWszystkie = $this->uslugaArtykulu->pobierzWszystkieKategorie();
        $artykul = $this->uslugaArtykulu->pobierzNazwyKategorii(0, $artykul, $kategorie);
        $iloscKomentarzy = $this->uslugaKomentarzy->policzKomentarze($artykul['id']);
        $artykul['ilosc_komentarzy'] = (int)$iloscKomentarzy;
        $obraz = $this->uslugaObrazow->pobierzObrazArt($artykul['id']);

        echo $this->silnikSzablonow->renderujSzablon("artykuly/edytuj_artykul.php", [
            'tytul' => $artykul['tytul'],
            'artykul' => $artykul,
            'kategorie' => $kategorie,
            'kategorieWszystkie' => $kategorieWszystkie,
            'imie_autora' => $autor['imie'],
            'obraz' => $obraz
        ]);
    }

    public function aktualizuj_artykul(array $id_artykulu)
    {
        $this->uslugaWalidacyjna->walidujArtykul($_POST);
        $plikObrazu = $_FILES['obraz'] ?? null;
        $this->uslugaObrazow->walidujObraz($plikObrazu);
        $this->uslugaObrazow->przekazObrazArt($_POST, (int)$id_artykulu['id'], $plikObrazu);

        $this->uslugaArtykulu->aktualizujArtykul((int)$id_artykulu['id'], $_POST, $plikObrazu);
        $this->uslugaArtykulu->aktualizujKategorie((int)$id_artykulu['id'], $_POST);
        przekierujDo("/edytuj_artykul/{$_POST['link']}");
    }

    public function napiszKomentarz(array $parametry)
    {
        //$parametry[0] - id_artykulu, $parametry[1] - id_komentarza (0 - odpowiedź na artykuł, nie na inny komentarz)

        //Walidacja pola komentarza
        $this->uslugaKomentarzy->napiszKomentarz($parametry, $_POST);
        przekierujDo($_SERVER['HTTP_REFERER']);
    }

    public function zatwierdzKomentarz(array $parametry)
    {
        //$parametry[0] - id_artykulu, $parametry[1] - id_komentarza (0 - odpowiedź na artykuł, nie na inny komentarz)
        $this->uslugaKomentarzy->zatwierdzKomentarz($parametry, $_POST);
        przekierujDo($_SERVER['HTTP_REFERER']);
    }

    public function anulujKomentarz(array $parametry)
    {
        //$parametry[0] - id_artykulu, $parametry[1] - id_komentarza (0 - odpowiedź na artykuł, nie na inny komentarz)
        $this->uslugaKomentarzy->anulujKomentarz($parametry, $_POST);
        przekierujDo($_SERVER['HTTP_REFERER']);
    }
}

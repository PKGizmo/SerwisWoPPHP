<?php

declare(strict_types=1);

namespace App\Kontrolery;

use Framework\SilnikSzablonow;
use App\Uslugi\{UslugaUzytkownika, UslugaArtykulu, UslugaKomentarzy, UslugaObrazow};

class BlogKontroler
{
    public function __construct(
        private SilnikSzablonow $silnikSzablonow,
        private UslugaUzytkownika $uslugaUzytkownika,
        private UslugaArtykulu $uslugaArtykulu,
        private UslugaKomentarzy $uslugaKomentarzy,
        private UslugaObrazow $uslugaObrazow
    ) {}

    public function blogSzablon()
    {
        [$uprawnienia, $artykuly, $strona, $poszukiwanie, $ostatniaStrona, $linkiStrony] = $this->daneSzablonow();

        $kategorieWszystkie = $this->uslugaArtykulu->pobierzWszystkieKategorie();

        [$rozneDaneArt, $rok, $iloscRok, $miesiac, $iloscMiesiac] = $this->uslugaArtykulu->pobierzRokMiesiacArtykulow($uprawnienia);

        echo $this->silnikSzablonow->renderujSzablon("blog.php", [
            'tytul' => 'Blog',
            'artykuly' => $artykuly,
            'biezacaStrona' => $strona,
            'kwerendaDlaPoprzedniejStrony' => http_build_query([
                'p' => $strona - 1,
                's' => $poszukiwanie
            ]),
            'ostatniaStrona' => $ostatniaStrona,
            'kwerendaDlaNastepnejStrony' => http_build_query([
                'p' => $strona + 1,
                's' => $poszukiwanie
            ]),
            'linkiStrony' => $linkiStrony,
            'poszukiwanieBok' => $poszukiwanie,
            'kategorieWszystkie' => $kategorieWszystkie,
            'rozneDaneArt' => $rozneDaneArt,
            'iloscRok' => $iloscRok,
            'rok' => $rok,
            'iloscMiesiac' => $iloscMiesiac,
            'miesiac' => $miesiac
        ]);
    }

    public function daneSzablonow($rok = 0, $miesiac = 0)
    {
        $strona = $_GET['p'] ?? 1;
        $strona = (int)$strona;
        $ilosc = 3;
        $offset = ($strona - 1) * $ilosc;

        $poszukiwanie = $_GET['s'] ?? NULL;

        $uprawnienia = 2;

        if (isset($_SESSION['uzytkownik'])) {
            $uprawnienia = $this->uslugaUzytkownika->pobierzUprawnienia();
        }

        [$artykuly, $iloscArtykulow] = $this->uslugaArtykulu->pobierzArtykuly(
            $uprawnienia,
            $ilosc,
            $offset,
            $rok,
            $miesiac
        );

        $i = 0;
        foreach ($artykuly as $artykul) {
            $iloscKomentarzyZatw = $this->uslugaKomentarzy->policzKomentarze($artykul['id'], 1);
            $iloscKomentarzySzkic = $this->uslugaKomentarzy->policzKomentarze($artykul['id'], 0);
            $obraz = $this->uslugaObrazow->pobierzObrazArt($artykul['id']);

            $artykuly[$i]['ilosc_komentarzy'] = $iloscKomentarzyZatw;
            $artykuly[$i]['ilosc_komentarzy_szkic'] = $iloscKomentarzySzkic;

            $artykuly[$i]['obraz'] = $obraz;

            $i++;
        }

        $ostatniaStrona = ceil($iloscArtykulow / $ilosc);
        $strony = $ostatniaStrona ? range(1, $ostatniaStrona) : [];

        $linkiStrony = array_map(
            fn($nrStrony) => http_build_query([
                'p' => $nrStrony,
                's' => $poszukiwanie
            ]),
            $strony
        );

        return [$uprawnienia, $artykuly, $strona, $poszukiwanie, $ostatniaStrona, $linkiStrony, $offset, $strony, $ilosc];
    }

    public function czytajArtykul(array $parametry)
    {
        $uprawnienia = 2;
        $uprawnienia = $this->uslugaUzytkownika->pobierzUprawnienia();
        $linkArtykulu = $parametry['link_a_rok'] . "/" . $parametry['link_a_miesiac'] . "/" . $parametry['link_a_tytul'];
        $artykul = $this->uslugaArtykulu->pobierzArtykul($linkArtykulu);
        $autor = $this->uslugaArtykulu->pobierzAutora($artykul['id_autora']);

        if (!$artykul) {
            przekierujDo('/blog');
        }

        $kategorie = $this->uslugaArtykulu->pobierzKategorie($artykul['id']);
        $kategorieWszystkie = $this->uslugaArtykulu->pobierzWszystkieKategorie();
        $artykul = $this->uslugaArtykulu->pobierzNazwyKategorii(0, $artykul, $kategorie);
        $iloscKomentarzyZatw = $this->uslugaKomentarzy->policzKomentarze($artykul['id'], 1);
        $iloscKomentarzySzkic = $this->uslugaKomentarzy->policzKomentarze($artykul['id'], 0);

        $artykul['ilosc_komentarzy'] = $iloscKomentarzyZatw;
        $artykul['ilosc_komentarzy_szkic'] = $iloscKomentarzySzkic;

        $obraz = $this->uslugaObrazow->pobierzObrazArt($artykul['id']);
        $artykul['obraz'] = $obraz;

        $komentarze = $this->uslugaKomentarzy->pobierzKomentarze($artykul['id']);

        $drzewoKomentarzy = $this->uslugaKomentarzy->utworzDrzewoKomentarzy($artykul['id']);
        $tabelaPoziomow = [];
        $this->uslugaKomentarzy->recursiveEcho($drzewoKomentarzy, $tabelaPoziomow);

        [$rozneDaneArt, $rok, $iloscRok, $miesiac, $iloscMiesiac] = $this->uslugaArtykulu->pobierzRokMiesiacArtykulow($uprawnienia);

        //dd($drzewoKomentarzy);
        echo $this->silnikSzablonow->renderujSzablon("artykuly/wyswietl_artykul.php", [
            'tytul' => $artykul['tytul'],
            'artykul' => $artykul,
            'imie_autora' => $autor['imie'],
            'komentarze' => $komentarze,
            'tabelaPoziomow' => $tabelaPoziomow,
            'kategorie' => $kategorie,
            'kategorieWszystkie' => $kategorieWszystkie,
            'rozneDaneArt' => $rozneDaneArt,
            'iloscRok' => $iloscRok,
            'rok' => $rok,
            'iloscMiesiac' => $iloscMiesiac,
            'miesiac' => $miesiac,
            'autor' => $autor

        ]);
    }

    public function archiwumSzablon(array $parametry)
    {
        $rokArch = $parametry['link_arch_rok'] ?? NULL;
        $miesiacAarch  = $parametry['link_arch_miesiac'] ?? NULL;

        [$uprawnienia, $artykuly, $strona, $poszukiwanie, $ostatniaStrona, $linkiStrony, $offset, $strony, $ilosc] = $this->daneSzablonow($rokArch, $miesiacAarch);

        $kategorieWszystkie = $this->uslugaArtykulu->pobierzWszystkieKategorie();

        [$rozneDaneArt, $rok, $iloscRok, $miesiac, $iloscMiesiac] = $this->uslugaArtykulu->pobierzRokMiesiacArtykulow($uprawnienia);

        echo $this->silnikSzablonow->renderujSzablon("archiwum.php", [
            'tytul' => 'Archiwum bloga',
            'artykuly' => $artykuly,
            'biezacaStrona' => $strona,
            'kwerendaDlaPoprzedniejStrony' => http_build_query([
                'p' => $strona - 1,
                's' => $poszukiwanie
            ]),
            'ostatniaStrona' => $ostatniaStrona,
            'kwerendaDlaNastepnejStrony' => http_build_query([
                'p' => $strona + 1,
                's' => $poszukiwanie
            ]),
            'linkiStrony' => $linkiStrony,
            'poszukiwanieBok' => $poszukiwanie,
            'kategorieWszystkie' => $kategorieWszystkie,
            'rozneDaneArt' => $rozneDaneArt,
            'iloscRok' => $iloscRok,
            'rok' => $rok,
            'iloscMiesiac' => $iloscMiesiac,
            'miesiac' => $miesiac,
            'rokArch' => $rokArch,
            'miesiacArch' => $miesiacAarch
        ]);
    }

    public function kategoriaSzablon(array $parametry)
    {
        $kategoriaId = (int)$parametry['kat_id'];

        [$uprawnienia, $artykuly, $strona, $poszukiwanie, $ostatniaStrona, $linkiStrony, $offset, $strony, $ilosc] = $this->daneSzablonow();

        $kategorieWszystkie = $this->uslugaArtykulu->pobierzWszystkieKategorie();

        [$rozneDaneArt, $rok, $iloscRok, $miesiac, $iloscMiesiac] = $this->uslugaArtykulu->pobierzRokMiesiacArtykulow($uprawnienia);

        $artykulyKategoria = $this->uslugaArtykulu->pobierzArtykulyKategoria(
            $uprawnienia,
            $ilosc,
            $offset,
            $kategoriaId
        );

        $i = 0;
        foreach ($artykulyKategoria[0] as $artykul) {
            $iloscKomentarzy = $this->uslugaKomentarzy->policzKomentarze($artykul['id']);
            $artykulyKategoria[0][$i]['ilosc_komentarzy'] = $iloscKomentarzy;
            $i++;
        }

        $iloscArtykulow = $artykulyKategoria[1];
        $ostatniaStrona = ceil($iloscArtykulow / $ilosc);
        $strony = $ostatniaStrona ? range(1, $ostatniaStrona) : [];

        $linkiStrony = array_map(
            fn($nrStrony) => http_build_query([
                'p' => $nrStrony,
                's' => $poszukiwanie
            ]),
            $strony
        );
        $tytul = "Kategoria: " . $kategorieWszystkie[$kategoriaId - 1]['nazwa'];

        echo $this->silnikSzablonow->renderujSzablon("kategoria.php", [
            'tytul' => $tytul,
            'artykuly' => $artykuly,
            'biezacaStrona' => $strona,
            'kwerendaDlaPoprzedniejStrony' => http_build_query([
                'p' => $strona - 1,
                's' => $poszukiwanie
            ]),
            'ostatniaStrona' => $ostatniaStrona,
            'kwerendaDlaNastepnejStrony' => http_build_query([
                'p' => $strona + 1,
                's' => $poszukiwanie
            ]),
            'linkiStrony' => $linkiStrony,
            'poszukiwanieBok' => $poszukiwanie,
            'kategorieWszystkie' => $kategorieWszystkie,
            'rozneDaneArt' => $rozneDaneArt,
            'iloscRok' => $iloscRok,
            'rok' => $rok,
            'iloscMiesiac' => $iloscMiesiac,
            'miesiac' => $miesiac,
            'kategoriaId' => $kategoriaId,
            'artykulyKat' => $artykulyKategoria[0]
        ]);
    }
}

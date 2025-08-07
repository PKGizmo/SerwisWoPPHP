<?php

declare(strict_types=1);

namespace App\Uslugi;

use Framework\Walidator;
use Framework\Reguly\{
    WymaganeRegula,
    EmailRegula,
    MinRegula,
    WRegula,
    UrlRegula,
    ZgodnoscRegula,
    MaxDlugoscRegula,
    Min1WyborRegula,
    TylkoLiczbyRegula,
    FormatDatyRegula,
    UnikalnoscRegula
};

class UslugaWalidacyjna
{
    private Walidator $walidator;

    public function __construct()
    {
        $this->walidator = new Walidator();

        $this->walidator->dodaj('wymagane', new WymaganeRegula());
        $this->walidator->dodaj('email', new EmailRegula());
        $this->walidator->dodaj('min', new MinRegula());
        $this->walidator->dodaj('w', new WRegula());
        $this->walidator->dodaj('url', new UrlRegula());
        $this->walidator->dodaj('zgodnosc', new ZgodnoscRegula());
        $this->walidator->dodaj('dlugoscMax', new MaxDlugoscRegula());
        $this->walidator->dodaj('min1Wybor', new Min1WyborRegula());
        $this->walidator->dodaj('tylkoLiczby', new TylkoLiczbyRegula());
        $this->walidator->dodaj('formatDaty', new FormatDatyRegula());
        $this->walidator->dodaj('unikalnosc', new UnikalnoscRegula());
    }

    public function walidujRejestracje(array $daneFormularza)
    {
        $this->walidator->waliduj($daneFormularza, [
            'imie' => ['wymagane'],
            'email' => ['wymagane', 'email'],
            'haslo' => ['wymagane'],
            'potwierdzHaslo' => ['wymagane', 'zgodnosc:haslo'],
            'wiek' => ['wymagane', 'min:12', 'tylkoLiczby'],
            'pochodzenie' => ['wymagane', 'w:Polska,USA,InneEuropa'],
            'socialMediaURL' => ['url'],
            'regulamin' => ['wymagane'],
            'zasady' => ['wymagane']
        ]);
    }

    public function walidujLogowanie(array $daneFormularza)
    {
        $this->walidator->waliduj($daneFormularza, [
            'email' => ['wymagane', 'email'],
            'haslo' => ['wymagane']
        ]);
    }

    public function walidujArtykul(array $daneFormularza)
    {
        $this->walidator->waliduj($daneFormularza, [
            'tytul' => ['wymagane', 'dlugoscMax:255'],
            'link' => ['wymagane'],
            'kat' => ['min1Wybor'],
            'data' => ['wymagane', 'formatDaty:Y-m-d G:i'],
            'streszczenie' => ['wymagane', 'min:32', 'dlugoscMax:300'],
            'tresc' => ['wymagane', 'min:255']
        ]);
    }

    public function walidujKategorie($daneFormularza)
    {
        $this->walidator->waliduj($daneFormularza, [
            'nazwa' => ['wymagane']
        ]);
    }

    public function walidujKategorieWszystkie(array $daneFormularza)
    {
        $ilosc = count($daneFormularza);

        for ($i = 1; $i <= $ilosc; $i++) {
            $tabela1[] = 'nazwa' . $i;
            $unikalne = '';
            for ($j = 1; $j <= $ilosc; $j++) {
                if ($j <> $i) {
                    $unikalne = $unikalne . $daneFormularza['nazwa' . $j];
                    if ($j < $ilosc) {
                        $unikalne = $unikalne . ',';
                    }
                }
            }
            $tabela2[] = ['wymagane', 'unikalnosc:' . $unikalne];
        }
        $tabela = array_combine($tabela1, $tabela2);

        $this->walidator->waliduj($daneFormularza, $tabela);
    }
}

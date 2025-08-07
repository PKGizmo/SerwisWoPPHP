<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    //route - trasa
    //path - sciezka
    private array $trasy = [];

    private array $programyPosredniczace = [];

    public function dodaj(string $metoda, string $sciezka, $kontroler)
    {
        //var_dump($sciezka);
        $sciezka = $this->normalizujSciezke($sciezka);

        $sciezkaWyrReg = preg_replace('#{[^/]+}#', '([^/]+)', $sciezka);

        $this->trasy[] = [
            'metoda' => strtoupper($metoda),
            'sciezka' => $sciezka,
            'kontroler' => $kontroler,
            'programy_posredniczace' => [],
            'sciezkaWyrReg' => $sciezkaWyrReg
        ];
    }

    public function normalizujSciezke(string $sciezka): string
    {
        $sciezka = trim($sciezka, '/');
        $sciezka = "/{$sciezka}/";
        $sciezka = preg_replace('#[/]{2,}#', '/', $sciezka);

        return $sciezka;
    }

    public function wyslijTrasa(string $sciezka, string $metoda, Kontener $kontener = null)
    {
        $sciezka = $this->normalizujSciezke($sciezka);
        $metoda = strtoupper($_POST['_METHOD'] ?? $metoda);

        foreach ($this->trasy as $trasa) {
            if (
                !preg_match("#^{$trasa['sciezkaWyrReg']}$#", $sciezka, $wartosciParametrow) ||
                $trasa['metoda'] !== $metoda
            ) {
                continue;
            }

            array_shift($wartosciParametrow);
            preg_match_all('#{([^/]+)}#', $trasa['sciezka'], $kluczeParametrow);
            $kluczeParametrow = $kluczeParametrow[1];

            $parametry = array_combine($kluczeParametrow, $wartosciParametrow);

            //Kontroler zawiera nazwę klasy, a nie instancję
            [$klasa, $funkcja] = $trasa['kontroler'];

            $instancjaKontrolera = $kontener ?
                $kontener->ustanow($klasa) :
                new $klasa;

            $akcja = fn() => $instancjaKontrolera->{$funkcja}($parametry);

            $wszystkiePP = [...$trasa['programy_posredniczace'], ...$this->programyPosredniczace];

            foreach ($wszystkiePP as $programPosredniczacy) {
                $instancjaProgramuPosredniczacego = $kontener ?
                    $kontener->ustanow($programPosredniczacy) :
                    new $programPosredniczacy;

                $akcja = fn() => $instancjaProgramuPosredniczacego->przetwarzaj($akcja);
            }

            $akcja();

            return;
        }
    }

    public function dodajProgramPosredniczacy(string $programPosredniczacy)
    {
        $this->programyPosredniczace[] = $programPosredniczacy;
    }

    public function dodajPPTrasie(string $pp)
    {
        $kluczOstatniejTrasy = array_key_last($this->trasy);
        $this->trasy[$kluczOstatniejTrasy]['programy_posredniczace'][] = $pp;
    }
}

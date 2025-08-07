<?php

declare(strict_types=1);

namespace Framework;

//Template - szablon

class SilnikSzablonow
{
    private array $globalneDaneSzablonow = [];

    public function __construct(private string $bazowaSciezka) {}

    public function renderujSzablon(string $szablon, array $dane = [])
    {
        extract($dane, EXTR_SKIP);
        extract($this->globalneDaneSzablonow, EXTR_SKIP);

        ob_start();

        include $this->ustanow($szablon);

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }

    public function ustanow(string $sciezka)
    {
        return "{$this->bazowaSciezka}/{$sciezka}";
    }

    public function dodajGlobalna(string $klucz, mixed $wartosc)
    {
        $this->globalneDaneSzablonow[$klucz] = $wartosc;
    }
}

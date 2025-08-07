<?php

declare(strict_types=1);

namespace Framework;

class App
{
    private Router $router;
    private Kontener $kontener;

    public function __construct(string $sciezkaDefinicjiKontenera = null)
    {
        $this->router = new Router();
        $this->kontener = new Kontener();

        if ($sciezkaDefinicjiKontenera) {
            $definicjeKontenera = include $sciezkaDefinicjiKontenera;
            $this->kontener->dodajDefinicje($definicjeKontenera);
        }
    }

    public function run()
    {
        $sciezka = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $metoda = $_SERVER['REQUEST_METHOD'];
        $this->router->wyslijTrasa($sciezka, $metoda, $this->kontener);
    }

    public function get(string $sciezka, array $kontroler): App
    {
        $this->router->dodaj('GET', $sciezka, $kontroler);
        return $this;
    }

    public function post(string $sciezka, array $kontroler): App
    {
        $this->router->dodaj('POST', $sciezka, $kontroler);
        return $this;
    }

    public function dodajProgramPosredniczacy(string $programPosredniczacy)
    {
        $this->router->dodajProgramPosredniczacy($programPosredniczacy);
    }

    public function dodajPPTrasie(string $pp)
    {
        $this->router->dodajPPTrasie($pp);
    }
}

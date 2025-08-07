<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass, ReflectionNamedType;
use Framework\Wyjatki\WyjatkiKontenera;

class Kontener
{
    private array $definicje = [];
    private array $rozstrzygniete = [];

    public function dodajDefinicje(array $noweDefinicje)
    {
        $this->definicje = [...$this->definicje, ...$noweDefinicje];
    }

    public function ustanow(string $nazwaKlasy)
    {
        $klasaRefleksyjna = new ReflectionClass($nazwaKlasy);

        if (!$klasaRefleksyjna->isInstantiable()) {
            throw new WyjatkiKontenera("Z klasy {$nazwaKlasy} nie można utworzyć instancji");
        }

        $konstruktor = $klasaRefleksyjna->getConstructor();

        if (!$konstruktor) {
            return new $nazwaKlasy;
        }

        $parametry = $konstruktor->getParameters();

        if (count($parametry) === 0) {
            return new $nazwaKlasy;
        }

        $zaleznosci = [];

        foreach ($parametry as $parametr) {
            $nazwa = $parametr->getName();
            $typ = $parametr->getType();

            if (!$typ) {
                throw new WyjatkiKontenera("Nie udało się ustanowić klasy {$nazwaKlasy}, ponieważ parametr {$nazwa} nie posiada wskazania typu.");
            }

            if (!$typ instanceof ReflectionNamedType || $typ->isBuiltin()) {
                throw new WyjatkiKontenera("Nie udało się ustanowić klasy {$nazwaKlasy}, ponieważ parametr ma niewłaściwą nazwę typu.");
            }

            $zaleznosci[] = $this->get($typ->getName());
        }

        return $klasaRefleksyjna->newInstanceArgs($zaleznosci);
    }

    public function get(string $id)
    {
        if (!array_key_exists($id, $this->definicje)) {
            throw new WyjatkiKontenera("Klasa {$id} nie istnieje w kontenerze.");
        }

        if (array_key_exists($id, $this->rozstrzygniete)) {
            return $this->rozstrzygniete[$id];
        }

        $funkcjaFabryczna = $this->definicje[$id];
        $zaleznosc = $funkcjaFabryczna($this);

        $this->rozstrzygniete[$id] = $zaleznosc;

        return $zaleznosc;
    }
}

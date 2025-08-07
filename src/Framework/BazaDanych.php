<?php

declare(strict_types=1);

namespace Framework;

use PDO, PDOException, PDOStatement;

class BazaDanych
{
    private PDO $polaczenie;
    private PDOStatement $rezultat;

    public function __construct(
        string $sterownik,
        array $konfiguracja,
        string $uzytkownik,
        string $haslo
    ) {
        $konfiguracja = http_build_query(data: $konfiguracja, arg_separator: ';');

        $dsn = "{$sterownik}:{$konfiguracja}";

        try {
            $this->polaczenie = new PDO($dsn, $uzytkownik, $haslo, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $w) {
            die("Nie udało się nawiązać połączenia z bazą danych!");
        }
    }

    public function zapytanie(string $zapytanie, array $parametry = []): BazaDanych
    {
        $this->rezultat = $this->polaczenie->prepare($zapytanie);
        $this->rezultat->execute($parametry);

        return $this;
    }

    public function policz()
    {
        return $this->rezultat->fetchColumn();
    }

    public function znajdz()
    {
        return $this->rezultat->fetch();
    }

    public function id()
    {
        return $this->polaczenie->lastInsertId();
    }

    public function znajdzWszystkie()
    {
        return $this->rezultat->fetchAll();
    }
}

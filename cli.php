<?php

include __DIR__ . "/src/Framework/bazaDanych.php";

use Framework\BazaDanych;

$db = new BazaDanych(
    'mysql',
    [
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'serwiswop'
    ],
    'root',
    ''
);

$plikSQL = file_get_contents("./baza_danych.sql");

$db->zapytanie($plikSQL);

/*try {
    $db->polaczenie->beginTransaction();

    $db->polaczenie->query("INSERT INTO uzytkownicy (email,imie,haslo) VALUES ('d@d.com','Marta','ddd')");

    $szukaj = "Marta";
    $zapytanie = "SELECT * FROM uzytkownicy WHERE imie=:imie";

    $rezultat = $db->polaczenie->prepare($zapytanie);
    $rezultat->bindValue('imie', $szukaj, PDO::PARAM_STR);

    //$rezultat->execute([
    //    'imie' => $szukaj
    //]);
    $rezultat->execute();

    var_dump($rezultat->fetchAll(PDO::FETCH_OBJ));

    $db->polaczenie->commit();
} catch (Exception $w) {
    $db->polaczenie->rollBack();
    echo "Nieudana transakcja!";
}*/

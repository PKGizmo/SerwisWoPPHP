<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use App\Konfig\Sciezki;
use Dotenv\Dotenv;

use function App\Konfig\{zarejestrujTrase, zarejestrujProgramPosredniczacy};

$dotenv = Dotenv::createImmutable(Sciezki::ROOT);
$dotenv->load();

$app = new App(Sciezki::ZRODLO . "app/definicje-kontenera.php");

//Dodajemy trasy do routera
zarejestrujTrase($app);
zarejestrujProgramPosredniczacy($app);

return $app;

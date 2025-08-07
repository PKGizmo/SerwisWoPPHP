<?php

declare(strict_types=1);

use Framework\{SilnikSzablonow, BazaDanych, Kontener};
use App\Konfig\Sciezki;
use App\Uslugi\{
    UslugaWalidacyjna,
    UslugaUzytkownika,
    UslugaArtykulu,
    UslugaMaila,
    UslugaAdministratora,
    UslugaKomentarzy,
    UslugaObrazow
};

return [
    SilnikSzablonow::class => fn() => new SilnikSzablonow(Sciezki::SZABLON),
    UslugaWalidacyjna::class => fn() => new UslugaWalidacyjna(),
    BazaDanych::class => fn() => new BazaDanych(
        $_ENV['DB_DRIVER'],
        [
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_NAME'],
        ],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
    ),
    UslugaUzytkownika::class => function (Kontener $kontener) {
        $db = $kontener->get(BazaDanych::class);

        return new UslugaUzytkownika($db);
    },
    UslugaArtykulu::class => function (Kontener $kontener) {
        $db = $kontener->get(BazaDanych::class);

        return new UslugaArtykulu($db);
    },
    UslugaMaila::class => function (Kontener $kontener) {
        $db = $kontener->get(BazaDanych::class);

        return new UslugaMaila($db);
    },
    UslugaAdministratora::class => function (Kontener $kontener) {
        $db = $kontener->get(BazaDanych::class);

        return new UslugaAdministratora($db);
    },
    UslugaKomentarzy::class => function (Kontener $kontener) {
        $db = $kontener->get(BazaDanych::class);

        return new UslugaKomentarzy($db);
    },
    UslugaObrazow::class => function (Kontener $kontener) {
        $db = $kontener->get(BazaDanych::class);

        return new UslugaObrazow($db);
    }

];

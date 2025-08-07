<?php

declare(strict_types=1);

namespace App\Kontrolery;

use App\Uslugi\{UslugaArtykulu};
use Framework\SilnikSzablonow;

class ObrazKontroler
{
    public function __construct(
        private SilnikSzablonow $silnikSzablonow,
        private UslugaArtykulu $uslugaArtykulu
    ) {}
}

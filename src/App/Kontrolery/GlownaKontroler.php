<?php

declare(strict_types=1);

namespace App\Kontrolery;

use Framework\SilnikSzablonow;

class GlownaKontroler
{
    public function __construct(private SilnikSzablonow $silnikSzablonow) {}

    public function glowna()
    {
        echo $this->silnikSzablonow->renderujSzablon("/glownaWoP.php");
    }
}

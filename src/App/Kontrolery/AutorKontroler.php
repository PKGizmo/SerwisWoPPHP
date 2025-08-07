<?php

declare(strict_types=1);

namespace App\Kontrolery;

use Framework\SilnikSzablonow;
use App\Konfig\Sciezki;

class AutorKontroler
{
    public function __construct(private SilnikSzablonow $silnikSzablonow) {}

    public function autor()
    {
        echo $this->silnikSzablonow->renderujSzablon("autor.php", [
            'tytul' => 'O autorze'
        ]);
    }
}

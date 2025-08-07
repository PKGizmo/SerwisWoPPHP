<?php

declare(strict_types=1);

namespace Framework\Reguly;

use Framework\Kontrakty\RegulyInterfejs;
use InvalidArgumentException;

class MaxDlugoscRegula implements RegulyInterfejs
{
    public function waliduj(array $daneFormularza, string $pole, array $parametry): bool
    {
        if (empty($parametry[0])) {
            throw new InvalidArgumentException("Nie podano maksymalnej długości!");
        }

        $dlugosc = (int)$parametry[0];

        return strlen($daneFormularza[$pole]) < $dlugosc;
    }

    public function wiadomoscWalidacji(array $daneFormularza, string $pole, array $parametry): string
    {
        $dlugosc = strlen($daneFormularza[$pole]);
        return "Treść pola nie może być dłuższa, niż {$parametry[0]} znaków! Obecnie: {$dlugosc}";
    }
}

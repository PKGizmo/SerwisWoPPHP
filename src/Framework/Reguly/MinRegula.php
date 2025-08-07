<?php

declare(strict_types=1);

namespace Framework\Reguly;

use Framework\Kontrakty\RegulyInterfejs;
use InvalidArgumentException;

class MinRegula implements RegulyInterfejs
{
    public function waliduj(array $daneFormularza, string $pole, array $parametry): bool
    {
        if (empty($parametry[0])) {
            throw new InvalidArgumentException("Nie podano minimalnej wartości!");
        }

        $wartosc = (int)$parametry[0];

        return $daneFormularza[$pole] >= $wartosc;
    }

    public function wiadomoscWalidacji(array $daneFormularza, string $pole, array $parametry): string
    {
        return "Wartość musi wynosić przynajmniej {$parametry[0]}!";
    }
}

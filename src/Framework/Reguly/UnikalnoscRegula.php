<?php

declare(strict_types=1);

namespace Framework\Reguly;

use Framework\Kontrakty\RegulyInterfejs;

class UnikalnoscRegula implements RegulyInterfejs
{
    public function waliduj(array $daneFormularza, string $pole, array $parametry): bool
    {
        $czyJest =  array_keys($parametry, $daneFormularza[$pole]);
        if ($czyJest) {
            return false;
        } else {
            return true;
        }
    }

    public function wiadomoscWalidacji(array $daneFormularza, string $pole, array $parametry): string
    {
        return "Wszystkie wartości muszą być unikalne!";
    }
}

<?php

declare(strict_types=1);

namespace Framework\Reguly;

use Framework\Kontrakty\RegulyInterfejs;

class ZgodnoscRegula implements RegulyInterfejs
{
    public function waliduj(array $daneFormularza, string $pole, array $parametry): bool
    {
        $pole1 = $daneFormularza[$pole];
        $pole2 = $daneFormularza[$parametry[0]];

        return $pole1 === $pole2;
    }

    public function wiadomoscWalidacji(array $daneFormularza, string $pole, array $parametry): string
    {
        return "Musi zgadzać się z polem {$parametry[0]}!";
    }
}

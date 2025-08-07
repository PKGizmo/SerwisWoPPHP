<?php

declare(strict_types=1);

namespace Framework\Reguly;

use Framework\Kontrakty\RegulyInterfejs;

class WRegula implements RegulyInterfejs
{
    public function waliduj(array $daneFormularza, string $pole, array $parametry): bool
    {
        return in_array($daneFormularza[$pole], $parametry);
    }

    public function wiadomoscWalidacji(array $daneFormularza, string $pole, array $parametry): string
    {
        return "Niewłaściwy wybór!";
    }
}

<?php

declare(strict_types=1);

namespace Framework\Reguly;

use Framework\Kontrakty\RegulyInterfejs;

class UrlRegula implements RegulyInterfejs
{
    public function waliduj(array $daneFormularza, string $pole, array $parametry): bool
    {
        return (!strlen($daneFormularza[$pole]) > 0) || (bool)filter_var($daneFormularza[$pole], FILTER_VALIDATE_URL);
    }

    public function wiadomoscWalidacji(array $daneFormularza, string $pole, array $parametry): string
    {
        return "Niepoprawny adres URL!";
    }
}

<?php

declare(strict_types=1);

namespace Framework\Reguly;

use Framework\Kontrakty\RegulyInterfejs;

class TylkoLiczbyRegula implements RegulyInterfejs
{
    public function waliduj(array $daneFormularza, string $pole, array $parametry): bool
    {
        return is_numeric($daneFormularza[$pole]);
    }

    public function wiadomoscWalidacji(array $daneFormularza, string $pole, array $parametry): string
    {
        return "W tym polu dozwolone są tylko liczby!";
    }
}

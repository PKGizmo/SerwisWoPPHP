<?php

declare(strict_types=1);

namespace Framework\Reguly;

use Framework\Kontrakty\RegulyInterfejs;

class FormatDatyRegula implements RegulyInterfejs
{
    public function waliduj(array $daneFormularza, string $pole, array $parametry): bool
    {
        $daneFormularza[$pole] = str_replace('T', ' ', $daneFormularza[$pole]);
        $analizaDaty = date_parse_from_format($parametry[0], $daneFormularza[$pole]);

        return $analizaDaty['warning_count'] === 0 && $analizaDaty['error_count'] === 0;
    }

    public function wiadomoscWalidacji(array $daneFormularza, string $pole, array $parametry): string
    {
        return "Niepoprawny format daty!";
    }
}

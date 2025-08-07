<?php

declare(strict_types=1);

namespace Framework\Kontrakty;

interface RegulyInterfejs
{
    public function waliduj(array $daneFormularza, string $pole, array $parametry): bool;
    public function wiadomoscWalidacji(array $daneFormularza, string $pole, array $parametry): string;
}

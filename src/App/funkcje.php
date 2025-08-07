<?php

declare(strict_types=1);

function dd(mixed $value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function e(mixed $value): string
{
    return htmlspecialchars((string)$value);
}

function przekierujDo(string $sciezka)
{
    header("Location: {$sciezka}");
    http_response_code(302);
    exit;
}

<?php declare(strict_types=1);

namespace HarmonyIO\Validation\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Rule\BankAccount\Iban\Country;

final class Bulgaria extends Country
{
    private const PATTERN = '~^BG\d{2}[A-Z]{4}\d{4}[a-zA-Z0-9]{10}$~';

    public function __construct()
    {
        parent::__construct(self::PATTERN, 'bulgaria');
    }
}

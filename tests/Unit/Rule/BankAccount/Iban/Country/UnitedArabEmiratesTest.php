<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\UnitedArabEmirates;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class UnitedArabEmiratesTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, UnitedArabEmirates::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new UnitedArabEmirates())->validate('XE070331234567890123456');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.UnitedArabEmirates', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new UnitedArabEmirates())->validate('AEx70331234567890123456');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.UnitedArabEmirates', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new UnitedArabEmirates())->validate('AE07x331234567890123456');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.UnitedArabEmirates', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new UnitedArabEmirates())->validate('AE07033123456789012345x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.UnitedArabEmirates', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new UnitedArabEmirates())->validate('AE07033123456789012345');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.UnitedArabEmirates', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new UnitedArabEmirates())->validate('AE0703312345678901234566');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.UnitedArabEmirates', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new UnitedArabEmirates())->validate('AE070331234567890123457');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new UnitedArabEmirates())->validate('AE070331234567890123456');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

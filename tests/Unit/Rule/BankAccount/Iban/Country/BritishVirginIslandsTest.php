<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\BritishVirginIslands;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class BritishVirginIslandsTest extends StringTestCase
{
    /**
     * BritishVirginIslandsTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, BritishVirginIslands::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new BritishVirginIslands())->validate('XG96VPVG0000012345678901');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.BritishVirginIslands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new BritishVirginIslands())->validate('VGx6VPVG0000012345678901');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.BritishVirginIslands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new BritishVirginIslands())->validate('VG96vPVG0000012345678901');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.BritishVirginIslands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new BritishVirginIslands())->validate('VG96VPVG000001234567890x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.BritishVirginIslands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new BritishVirginIslands())->validate('VG96VPVG000001234567890');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.BritishVirginIslands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new BritishVirginIslands())->validate('VG96VPVG00000123456789011');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.BritishVirginIslands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new BritishVirginIslands())->validate('VG96VPVG0000012345678902');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new BritishVirginIslands())->validate('VG96VPVG0000012345678901');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

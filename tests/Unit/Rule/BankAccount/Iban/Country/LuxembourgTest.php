<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Luxembourg;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class LuxembourgTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Luxembourg::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Luxembourg())->validate('XU280019400644750000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Luxembourg', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Luxembourg())->validate('LUx80019400644750000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Luxembourg', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Luxembourg())->validate('LU28x019400644750000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Luxembourg', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Luxembourg())->validate('LU28001940064475000!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Luxembourg', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Luxembourg())->validate('LU28001940064475000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Luxembourg', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Luxembourg())->validate('LU2800194006447500000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Luxembourg', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Luxembourg())->validate('LU280019400644750001');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Luxembourg())->validate('LU280019400644750000');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Norway;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class NorwayTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Norway::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Norway())->validate('XO9386011117947');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Norway', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Norway())->validate('NOx386011117947');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Norway', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Norway())->validate('NO93x6011117947');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Norway', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Norway())->validate('NO938601111794x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Norway', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Norway())->validate('NO938601111794');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Norway', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Norway())->validate('NO93860111179477');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Norway', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Norway())->validate('NO9386011117948');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Norway())->validate('NO9386011117947');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

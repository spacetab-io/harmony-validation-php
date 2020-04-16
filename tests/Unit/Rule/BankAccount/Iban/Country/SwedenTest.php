<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Sweden;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class SwedenTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Sweden::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Sweden())->validate('XE4550000000058398257466');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Sweden', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Sweden())->validate('SEx550000000058398257466');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Sweden', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Sweden())->validate('SE45x0000000058398257466');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Sweden', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Sweden())->validate('SE455000000005839825746x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Sweden', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Sweden())->validate('SE455000000005839825746');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Sweden', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Sweden())->validate('SE45500000000583982574666');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Sweden', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Sweden())->validate('SE4550000000058398257467');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Sweden())->validate('SE4550000000058398257466');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

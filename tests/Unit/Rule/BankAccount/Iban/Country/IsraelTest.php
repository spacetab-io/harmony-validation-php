<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Israel;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class IsraelTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Israel::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Israel())->validate('XL620108000000099999999');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Israel', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Israel())->validate('ILx20108000000099999999');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Israel', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Israel())->validate('IL62x108000000099999999');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Israel', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Israel())->validate('IL62010800000009999999x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Israel', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Israel())->validate('IL62010800000009999999');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Israel', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Israel())->validate('IL6201080000000999999999');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Israel', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Israel())->validate('IL620108000000099999990');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Israel())->validate('IL620108000000099999999');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

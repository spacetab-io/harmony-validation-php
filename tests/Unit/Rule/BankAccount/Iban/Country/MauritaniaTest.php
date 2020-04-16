<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Mauritania;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class MauritaniaTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Mauritania::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Mauritania())->validate('XR1300020001010000123456753');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Mauritania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Mauritania())->validate('MRx300020001010000123456753');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Mauritania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Mauritania())->validate('MR13x0020001010000123456753');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Mauritania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Mauritania())->validate('MR130002000101000012345675x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Mauritania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Mauritania())->validate('MR130002000101000012345675');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Mauritania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Mauritania())->validate('MR13000200010100001234567533');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Mauritania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Mauritania())->validate('MR1300020001010000123456754');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Mauritania())->validate('MR1300020001010000123456753');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Spain;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class SpainTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Spain::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Spain())->validate('XS9121000418450200051332');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Spain', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Spain())->validate('ESx121000418450200051332');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Spain', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Spain())->validate('ES91x1000418450200051332');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Spain', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Spain())->validate('ES912100041845020005133x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Spain', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Spain())->validate('ES912100041845020005133');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Spain', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Spain())->validate('ES91210004184502000513322');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Spain', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Spain())->validate('ES9121000418450200051333');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Spain())->validate('ES9121000418450200051332');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

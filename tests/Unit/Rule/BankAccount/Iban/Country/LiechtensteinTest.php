<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Liechtenstein;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class LiechtensteinTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Liechtenstein::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Liechtenstein())->validate('XI21088100002324013AA');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Liechtenstein', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Liechtenstein())->validate('LIx1088100002324013AA');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Liechtenstein', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Liechtenstein())->validate('LI21x88100002324013AA');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Liechtenstein', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Liechtenstein())->validate('LI21088100002324013A!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Liechtenstein', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Liechtenstein())->validate('LI21088100002324013A');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Liechtenstein', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Liechtenstein())->validate('LI21088100002324013AAA');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Liechtenstein', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Liechtenstein())->validate('LI21088100002324013AB');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Liechtenstein())->validate('LI21088100002324013AA');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

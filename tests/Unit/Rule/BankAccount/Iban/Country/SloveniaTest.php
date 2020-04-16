<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Slovenia;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class SloveniaTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Slovenia::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Slovenia())->validate('XI56263300012039086');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Slovenia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Slovenia())->validate('SI66263300012039086');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Slovenia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Slovenia())->validate('SI56x63300012039086');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Slovenia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Slovenia())->validate('SI5626330001203908x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Slovenia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Slovenia())->validate('SI5626330001203908');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Slovenia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Slovenia())->validate('SI562633000120390866');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Slovenia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Slovenia())->validate('SI56263300012039087');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Slovenia())->validate('SI56263300012039086');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

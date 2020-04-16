<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Qatar;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class QatarTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Qatar::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Qatar())->validate('XA58DOHB00001234567890ABCDEFG');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Qatar', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Qatar())->validate('QAx8DOHB00001234567890ABCDEFG');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Qatar', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Qatar())->validate('QA58dOHB00001234567890ABCDEFG');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Qatar', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Qatar())->validate('QA58DOHB00001234567890ABCDEF!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Qatar', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Qatar())->validate('QA58DOHB00001234567890ABCDEF');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Qatar', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Qatar())->validate('QA58DOHB00001234567890ABCDEFGG');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Qatar', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Qatar())->validate('QA58DOHB00001234567890ABCDEFH');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Qatar())->validate('QA58DOHB00001234567890ABCDEFG');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

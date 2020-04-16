<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Netherlands;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class NetherlandsTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Netherlands::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Netherlands())->validate('XL91ABNA0417164300');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Netherlands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Netherlands())->validate('NLx1ABNA0417164300');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Netherlands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Netherlands())->validate('NL91aBNA0417164300');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Netherlands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Netherlands())->validate('NL91ABNA041716430x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Netherlands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Netherlands())->validate('NL91ABNA041716430');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Netherlands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Netherlands())->validate('NL91ABNA04171643000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Netherlands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Netherlands())->validate('NL91ABNA0417164301');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Netherlands())->validate('NL91ABNA0417164300');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

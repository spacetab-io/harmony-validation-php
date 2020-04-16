<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Monaco;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class MonacoTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Monaco::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Monaco())->validate('XC5811222000010123456789030');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Monaco', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Monaco())->validate('MCx811222000010123456789030');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Monaco', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Monaco())->validate('MC58x1222000010123456789030');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Monaco', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Monaco())->validate('MC581122200001012345678903x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Monaco', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Monaco())->validate('MC581122200001012345678903');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Monaco', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Monaco())->validate('MC58112220000101234567890300');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Monaco', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Monaco())->validate('MC5811222000010123456789031');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Monaco())->validate('MC5811222000010123456789030');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Jordan;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class JordanTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Jordan::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Jordan())->validate('XO94CBJO0010000000000131000302');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Jordan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Jordan())->validate('JOx4CBJO0010000000000131000302');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Jordan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Jordan())->validate('JO94cBJO0010000000000131000302');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Jordan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Jordan())->validate('JO94CBJO001000000000013100030!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Jordan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Jordan())->validate('JO94CBJO001000000000013100030');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Jordan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Jordan())->validate('JO94CBJO00100000000001310003022');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Jordan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Jordan())->validate('JO94CBJO0010000000000131000303');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Jordan())->validate('JO94CBJO0010000000000131000302');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

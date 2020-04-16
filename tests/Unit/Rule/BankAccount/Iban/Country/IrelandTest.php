<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Ireland;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class IrelandTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Ireland::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Ireland())->validate('XE29AIBK93115212345678');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Ireland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Ireland())->validate('IEx9AIBK93115212345678');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Ireland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Ireland())->validate('IE29aIBK93115212345678');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Ireland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Ireland())->validate('IE29AIBK9311521234567x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Ireland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Ireland())->validate('IE29AIBK9311521234567');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Ireland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Ireland())->validate('IE29AIBK931152123456788');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Ireland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Ireland())->validate('IE29AIBK93115212345679');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Ireland())->validate('IE29AIBK93115212345678');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

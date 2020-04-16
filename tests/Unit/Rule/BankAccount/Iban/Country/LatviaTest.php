<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Latvia;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class LatviaTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Latvia::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Latvia())->validate('XV80BANK0000435195001');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Latvia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Latvia())->validate('LVx0BANK0000435195001');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Latvia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Latvia())->validate('LV80bANK0000435195001');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Latvia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Latvia())->validate('LV80BANK000043519500!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Latvia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Latvia())->validate('LV80BANK000043519500');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Latvia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Latvia())->validate('LV80BANK00004351950011');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Latvia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Latvia())->validate('LV80BANK0000435195002');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Latvia())->validate('LV80BANK0000435195001');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

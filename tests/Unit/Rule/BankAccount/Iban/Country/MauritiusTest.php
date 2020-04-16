<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Mauritius;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class MauritiusTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Mauritius::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Mauritius())->validate('XU17BOMM0101101030300200000MUR');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Mauritius', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Mauritius())->validate('MUx7BOMM0101101030300200000MUR');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Mauritius', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Mauritius())->validate('MU17bOMM0101101030300200000MUR');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Mauritius', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Mauritius())->validate('MU17BOMM0101101030300200000MU!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Mauritius', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Mauritius())->validate('MU17BOMM0101101030300200000MU');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Mauritius', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Mauritius())->validate('MU17BOMM0101101030300200000MURR');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Mauritius', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Mauritius())->validate('MU17BOMM0101101030300200000MUS');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Mauritius())->validate('MU17BOMM0101101030300200000MUR');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

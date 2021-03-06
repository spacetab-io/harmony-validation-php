<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Germany;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class GermanyTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Germany::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Germany())->validate('XE89370400440532013000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Germany', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Germany())->validate('DEx9370400440532013000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Germany', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Germany())->validate('DE89x70400440532013000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Germany', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Germany())->validate('DE8937040044053201300x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Germany', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Germany())->validate('DE8937040044053201300');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Germany', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Germany())->validate('DE893704004405320130000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Germany', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Germany())->validate('DE89370400440532013001');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Germany())->validate('DE89370400440532013000');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Moldova;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class MoldovaTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Moldova::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Moldova())->validate('XD24AG000225100013104168');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Moldova', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Moldova())->validate('MDx4AG000225100013104168');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Moldova', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Moldova())->validate('MD24aG000225100013104168');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Moldova', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Moldova())->validate('MD24AG00022510001310416!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Moldova', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Moldova())->validate('MD24AG00022510001310416');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Moldova', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Moldova())->validate('MD24AG0002251000131041688');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Moldova', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Moldova())->validate('MD24AG000225100013104169');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Moldova())->validate('MD24AG000225100013104168');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

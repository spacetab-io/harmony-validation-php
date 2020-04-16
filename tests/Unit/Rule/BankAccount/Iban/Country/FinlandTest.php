<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Finland;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class FinlandTest extends StringTestCase
{
    /**
     * FinlandTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Finland::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Finland())->validate('XI2112345600000785');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Finland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Finland())->validate('FIx112345600000785');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Finland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Finland())->validate('FI21x2345600000785');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Finland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Finland())->validate('FI211234560000078x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Finland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Finland())->validate('FI211234560000078');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Finland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Finland())->validate('FI21123456000007855');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Finland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Finland())->validate('FI2112345600000786');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Finland())->validate('FI2112345600000785');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

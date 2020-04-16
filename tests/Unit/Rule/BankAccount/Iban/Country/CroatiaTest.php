<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Croatia;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class CroatiaTest extends StringTestCase
{
    /**
     * CroatiaTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Croatia::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Croatia())->validate('XR1210010051863000160');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Croatia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Croatia())->validate('HRx210010051863000160');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Croatia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Croatia())->validate('HR12x0010051863000160');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Croatia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Croatia())->validate('HR121001005186300016x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Croatia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Croatia())->validate('HR121001005186300016');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Croatia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Croatia())->validate('HR12100100518630001600');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Croatia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Croatia())->validate('HR1210010051863000161');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateReturnsTrueWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Croatia())->validate('HR1210010051863000160');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

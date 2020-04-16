<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Belgium;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class BelgiumTest extends StringTestCase
{
    /**
     * BelgiumTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Belgium::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Belgium())->validate('XE68539007547034');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Belgium', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Belgium())->validate('BEx8539007547034');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Belgium', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Belgium())->validate('BE68x39007547034');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Belgium', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Belgium())->validate('BE6853900754703x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Belgium', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Belgium())->validate('BE6853900754703');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Belgium', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Belgium())->validate('BE685390075470344');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Belgium', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Belgium())->validate('BE68539007547035');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Belgium())->validate('BE68539007547034');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

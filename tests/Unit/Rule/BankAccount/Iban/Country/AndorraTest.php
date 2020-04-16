<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Andorra;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class AndorraTest extends StringTestCase
{
    /**
     * AndorraTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Andorra::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Andorra())->validate('XD1200012030200359100100');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Andorra', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Andorra())->validate('ADx200012030200359100100');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Andorra', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Andorra())->validate('AD12x0012030200359100100');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Andorra', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Andorra())->validate('AD120001203020035910010x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Andorra', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Andorra())->validate('AD120001203020035910010');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Andorra', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Andorra())->validate('AD12000120302003591001000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Andorra', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Andorra())->validate('AD12000120302003591001001');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Andorra', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Andorra())->validate('AD1200012030200359100100');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

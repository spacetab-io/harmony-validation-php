<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\DominicanRepublic;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class DominicanRepublicTest extends StringTestCase
{
    /**
     * DominicanRepublicTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, DominicanRepublic::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new DominicanRepublic())->validate('XO28BAGR00000001212453611324');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.DominicanRepublic', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new DominicanRepublic())->validate('DOx8BAGR00000001212453611324');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.DominicanRepublic', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new DominicanRepublic())->validate('DO28bAGR00000001212453611324');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.DominicanRepublic', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new DominicanRepublic())->validate('DO28BAGR0000000121245361132x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.DominicanRepublic', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new DominicanRepublic())->validate('DO28BAGR0000000121245361132');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.DominicanRepublic', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new DominicanRepublic())->validate('DO28BAGR000000012124536113244');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.DominicanRepublic', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new DominicanRepublic())->validate('DO28BAGR00000001212453611325');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new DominicanRepublic())->validate('DO28BAGR00000001212453611324');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

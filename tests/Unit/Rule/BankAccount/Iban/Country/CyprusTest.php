<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Cyprus;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class CyprusTest extends StringTestCase
{
    /**
     * CyprusTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Cyprus::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Cyprus())->validate('XY17002001280000001200527600');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Cyprus', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Cyprus())->validate('CYx7002001280000001200527600');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Cyprus', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Cyprus())->validate('CY17x02001280000001200527600');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Cyprus', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Cyprus())->validate('CY1700200128000000120052760!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Cyprus', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Cyprus())->validate('CY1700200128000000120052760');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Cyprus', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Cyprus())->validate('CY170020012800000012005276000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Cyprus', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Cyprus())->validate('CY17002001280000001200527601');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Cyprus())->validate('CY17002001280000001200527600');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

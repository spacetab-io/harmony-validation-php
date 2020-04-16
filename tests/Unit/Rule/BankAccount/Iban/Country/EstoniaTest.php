<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Estonia;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class EstoniaTest extends StringTestCase
{
    /**
     * EstoniaTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Estonia::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Estonia())->validate('XE382200221020145685');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Estonia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Estonia())->validate('EEx82200221020145685');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Estonia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Estonia())->validate('EE38x200221020145685');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Estonia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Estonia())->validate('EE38220022102014568x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Estonia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Estonia())->validate('EE38220022102014568');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Estonia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Estonia())->validate('EE3822002210201456855');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Estonia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Estonia())->validate('EE382200221020145686');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Estonia())->validate('EE382200221020145685');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

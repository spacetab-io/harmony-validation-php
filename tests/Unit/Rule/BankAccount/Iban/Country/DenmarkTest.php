<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Denmark;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class DenmarkTest extends StringTestCase
{
    /**
     * DenmarkTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Denmark::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Denmark())->validate('XK5000400440116243');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Denmark', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Denmark())->validate('DKx000400440116243');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Denmark', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Denmark())->validate('DK50x0400440116243');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Denmark', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Denmark())->validate('DK500040044011624x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Denmark', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Denmark())->validate('DK500040044011624');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Denmark', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Denmark())->validate('DK50004004401162433');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Denmark', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Denmark())->validate('DK5000400440116244');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Denmark())->validate('DK5000400440116243');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

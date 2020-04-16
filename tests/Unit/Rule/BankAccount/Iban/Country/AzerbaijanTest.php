<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Azerbaijan;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class AzerbaijanTest extends StringTestCase
{
    /**
     * AzerbaijanTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Azerbaijan::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Azerbaijan())->validate('XZ21NABZ00000000137010001944');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Azerbaijan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Azerbaijan())->validate('AZx1NABZ00000000137010001944');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Azerbaijan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Azerbaijan())->validate('AZ211ABZ00000000137010001944');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Azerbaijan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Azerbaijan())->validate('AZ21NABZ0000000013701000194!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Azerbaijan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Azerbaijan())->validate('AZ21NABZ0000000013701000194');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Azerbaijan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Azerbaijan())->validate('AZ21NABZ000000001370100019444');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Azerbaijan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Azerbaijan())->validate('AZ21NABZ00000000137010001945');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Azerbaijan())->validate('AZ21NABZ00000000137010001944');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

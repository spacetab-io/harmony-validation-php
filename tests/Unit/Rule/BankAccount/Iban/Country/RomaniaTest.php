<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Romania;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class RomaniaTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Romania::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Romania())->validate('XO49AAAA1B31007593840000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Romania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Romania())->validate('ROx9AAAA1B31007593840000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Romania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Romania())->validate('RO49aAAA1B31007593840000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Romania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Romania())->validate('RO49AAAA1B3100759384000!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Romania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Romania())->validate('RO49AAAA1B3100759384000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Romania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Romania())->validate('RO49AAAA1B310075938400000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Romania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Romania())->validate('RO49AAAA1B31007593840001');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Romania())->validate('RO49AAAA1B31007593840000');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

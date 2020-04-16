<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Montenegro;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class MontenegroTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Montenegro::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Montenegro())->validate('XE25505000012345678951');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Montenegro', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Montenegro())->validate('ME35505000012345678951');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Montenegro', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Montenegro())->validate('ME25x05000012345678951');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Montenegro', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Montenegro())->validate('ME2550500001234567895x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Montenegro', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Montenegro())->validate('ME2550500001234567895');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Montenegro', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Montenegro())->validate('ME255050000123456789511');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Montenegro', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Montenegro())->validate('ME25505000012345678952');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Montenegro())->validate('ME25505000012345678951');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

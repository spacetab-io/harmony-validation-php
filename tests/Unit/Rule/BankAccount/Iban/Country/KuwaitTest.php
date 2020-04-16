<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Kuwait;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class KuwaitTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Kuwait::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Kuwait())->validate('XW81CBKU0000000000001234560101');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kuwait', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Kuwait())->validate('KWx1CBKU0000000000001234560101');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kuwait', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Kuwait())->validate('KW81cBKU0000000000001234560101');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kuwait', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Kuwait())->validate('KW81CBKU000000000000123456010!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kuwait', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Kuwait())->validate('KW81CBKU000000000000123456010');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kuwait', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Kuwait())->validate('KW81CBKU00000000000012345601011');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kuwait', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Kuwait())->validate('KW81CBKU0000000000001234560102');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Kuwait())->validate('KW81CBKU0000000000001234560101');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

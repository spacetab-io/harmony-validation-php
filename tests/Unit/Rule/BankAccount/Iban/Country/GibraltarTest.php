<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Gibraltar;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class GibraltarTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Gibraltar::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Gibraltar())->validate('XI75NWBK000000007099453');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Gibraltar', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Gibraltar())->validate('GIx5NWBK000000007099453');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Gibraltar', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Gibraltar())->validate('GI75nWBK000000007099453');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Gibraltar', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Gibraltar())->validate('GI75NWBK00000000709945!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Gibraltar', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Gibraltar())->validate('GI75NWBK00000000709945');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Gibraltar', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Gibraltar())->validate('GI75NWBK0000000070994533');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Gibraltar', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Gibraltar())->validate('GI75NWBK000000007099454');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Gibraltar())->validate('GI75NWBK000000007099453');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

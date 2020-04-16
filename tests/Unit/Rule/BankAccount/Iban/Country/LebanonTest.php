<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Lebanon;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class LebanonTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Lebanon::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Lebanon())->validate('XB62099900000001001901229114');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Lebanon', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Lebanon())->validate('LBx2099900000001001901229114');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Lebanon', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Lebanon())->validate('LB62x99900000001001901229114');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Lebanon', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Lebanon())->validate('LB6209990000000100190122911!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Lebanon', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Lebanon())->validate('LB6209990000000100190122911');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Lebanon', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Lebanon())->validate('LB620999000000010019012291144');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Lebanon', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Lebanon())->validate('LB62099900000001001901229115');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Lebanon())->validate('LB62099900000001001901229114');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

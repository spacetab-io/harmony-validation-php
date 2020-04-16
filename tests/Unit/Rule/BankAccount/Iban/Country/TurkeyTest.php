<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Turkey;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class TurkeyTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Turkey::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Turkey())->validate('XR330006100519786457841326');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Turkey', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Turkey())->validate('TRx30006100519786457841326');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Turkey', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Turkey())->validate('TR33x006100519786457841326');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Turkey', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveReservedNumber()
    {
        /** @var Result $result */
        $result = yield (new Turkey())->validate('TR330006110519786457841326');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Turkey', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Turkey())->validate('TR33000610051978645784132!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Turkey', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Turkey())->validate('TR33000610051978645784132');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Turkey', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Turkey())->validate('TR3300061005197864578413266');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Turkey', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Turkey())->validate('TR330006100519786457841327');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Turkey())->validate('TR330006100519786457841326');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

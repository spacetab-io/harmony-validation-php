<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Switzerland;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class SwitzerlandTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Switzerland::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Switzerland())->validate('XH9300762011623852957');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Switzerland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Switzerland())->validate('CHx300762011623852957');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Switzerland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Switzerland())->validate('CH93x0762011623852957');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Switzerland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Switzerland())->validate('CH930076201162385295x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Switzerland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Switzerland())->validate('CH930076201162385295');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Switzerland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Switzerland())->validate('CH93007620116238529577');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Switzerland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Switzerland())->validate('CH9300762011623852958');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateReturnsTrueWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Switzerland())->validate('CH9300762011623852957');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

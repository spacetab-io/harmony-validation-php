<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Greenland;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class GreenlandTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Greenland::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Greenland())->validate('XL8964710001000206');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Greenland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Greenland())->validate('GLx964710001000206');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Greenland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Greenland())->validate('GL89x4710001000206');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Greenland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Greenland())->validate('GL896471000100020x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Greenland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Greenland())->validate('GL896471000100020');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Greenland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Greenland())->validate('GL89647100010002066');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Greenland', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Greenland())->validate('GL8964710001000207');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Greenland())->validate('GL8964710001000206');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

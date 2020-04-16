<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\SaudiArabia;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class SaudiArabiaTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, SaudiArabia::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new SaudiArabia())->validate('XA0380000000608010167519');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.SaudiArabia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new SaudiArabia())->validate('SAx380000000608010167519');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.SaudiArabia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new SaudiArabia())->validate('SA03x0000000608010167519');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.SaudiArabia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new SaudiArabia())->validate('SA038000000060801016751!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.SaudiArabia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new SaudiArabia())->validate('SA038000000060801016751');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.SaudiArabia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new SaudiArabia())->validate('SA03800000006080101675199');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.SaudiArabia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksum()
    {
        /** @var Result $result */
        $result = yield (new SaudiArabia())->validate('SA0380000000608010167510');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new SaudiArabia())->validate('SA0380000000608010167519');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Slovakia;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class SlovakiaTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Slovakia::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Slovakia())->validate('XK3112000000198742637541');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Slovakia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Slovakia())->validate('SKx112000000198742637541');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Slovakia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Slovakia())->validate('SK31x2000000198742637541');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Slovakia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Slovakia())->validate('SK311200000019874263754x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Slovakia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Slovakia())->validate('SK311200000019874263754');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Slovakia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Slovakia())->validate('SK31120000001987426375411');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Slovakia', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Slovakia())->validate('SK3112000000198742637542');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Slovakia())->validate('SK3112000000198742637541');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

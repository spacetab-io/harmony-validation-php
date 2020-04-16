<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Guatemala;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class GuatemalaTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Guatemala::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Guatemala())->validate('XT82TRAJ01020000001210029690');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Guatemala', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Guatemala())->validate('GTx2TRAJ01020000001210029690');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Guatemala', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Guatemala())->validate('GT82tRAJ01020000001210029690');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Guatemala', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Guatemala())->validate('GT82TRAJ0102000000121002969!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Guatemala', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Guatemala())->validate('GT82TRAJ0102000000121002969');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Guatemala', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Guatemala())->validate('GT82TRAJ010200000012100296900');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Guatemala', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Guatemala())->validate('GT82TRAJ01020000001210029691');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Guatemala())->validate('GT82TRAJ01020000001210029690');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

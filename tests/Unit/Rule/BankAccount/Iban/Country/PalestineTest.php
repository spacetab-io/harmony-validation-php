<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Palestine;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class PalestineTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Palestine::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Palestine())->validate('XS92PALS000000000400123456702');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Palestine', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Palestine())->validate('PSx2PALS000000000400123456702');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Palestine', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Palestine())->validate('PS92pALS000000000400123456702');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Palestine', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Palestine())->validate('PS92PALS00000000040012345670!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Palestine', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Palestine())->validate('PS92PALS00000000040012345670');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Palestine', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Palestine())->validate('PS92PALS0000000004001234567022');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Palestine', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Palestine())->validate('PS92PALS000000000400123456703');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Palestine())->validate('PS92PALS000000000400123456702');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

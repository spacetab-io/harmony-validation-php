<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Lithuania;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class LithuaniaTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Lithuania::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Lithuania())->validate('XT121000011101001000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Lithuania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Lithuania())->validate('LTx21000011101001000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Lithuania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Lithuania())->validate('LT12x000011101001000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Lithuania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Lithuania())->validate('LT12100001110100100x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Lithuania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Lithuania())->validate('LT12100001110100100');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Lithuania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Lithuania())->validate('LT1210000111010010000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Lithuania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Lithuania())->validate('LT121000011101001001');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Lithuania())->validate('LT121000011101001000');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

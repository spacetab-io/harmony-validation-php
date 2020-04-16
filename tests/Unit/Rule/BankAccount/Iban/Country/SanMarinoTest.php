<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\SanMarino;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class SanMarinoTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, SanMarino::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new SanMarino())->validate('XM86U0322509800000000270100');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.SanMarino', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new SanMarino())->validate('SMx6U0322509800000000270100');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.SanMarino', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new SanMarino())->validate('SM86u0322509800000000270100');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.SanMarino', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new SanMarino())->validate('SM86U032250980000000027010!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.SanMarino', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new SanMarino())->validate('SM86U032250980000000027010');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.SanMarino', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new SanMarino())->validate('SM86U03225098000000002701000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.SanMarino', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new SanMarino())->validate('SM86U0322509800000000270101');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new SanMarino())->validate('SM86U0322509800000000270100');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Brazil;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class BrazilTest extends StringTestCase
{
    /**
     * BrazilTest constructor.
     *
     * @param string|null $name
     * @param array<string> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Brazil::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Brazil())->validate('XR9700360305000010009795493P1');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Brazil', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Brazil())->validate('BRx700360305000010009795493P1');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Brazil', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Brazil())->validate('BR97x0360305000010009795493P1');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Brazil', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Brazil())->validate('BR970036030500x010009795493P1');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Brazil', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAnAccountType(): Generator
    {
        /** @var Result $result */
        $result = yield (new Brazil())->validate('BR970036030500001000979549311');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Brazil', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAndAccountHolderPosition(): Generator
    {
        /** @var Result $result */
        $result = yield (new Brazil())->validate('BR9700360305000010009795493P!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Brazil', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Brazil())->validate('BR970036030500001000979593P1');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Brazil', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Brazil())->validate('BR9700360305000010009795493P11');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Brazil', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Brazil())->validate('BR9700360305000010009795493P2');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Brazil())->validate('BR9700360305000010009795493P1');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

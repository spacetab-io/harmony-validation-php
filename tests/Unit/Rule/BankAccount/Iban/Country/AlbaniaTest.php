<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Albania;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class AlbaniaTest extends StringTestCase
{
    /**
     * AlbaniaTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Albania::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Albania())->validate('XL47212110090000000235698741');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Albania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Albania())->validate('ALx7212110090000000235698741');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Albania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Albania())->validate('AL47x12110090000000235698741');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Albania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Albania())->validate('AL4721211009000000023569874x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Albania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Albania())->validate('AL4721211009000000023569874');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Albania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Albania())->validate('AL472121100900000002356987411');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Albania', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Albania())->validate('AL47212110090000000235698742');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Albania())->validate('AL47212110090000000235698741');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

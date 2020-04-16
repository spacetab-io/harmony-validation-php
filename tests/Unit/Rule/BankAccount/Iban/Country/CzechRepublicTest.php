<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\CzechRepublic;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class CzechRepublicTest extends StringTestCase
{
    /**
     * CzechRepublicTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, CzechRepublic::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new CzechRepublic())->validate('XZ6508000000192000145399');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CzechRepublic', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new CzechRepublic())->validate('CZx508000000192000145399');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CzechRepublic', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new CzechRepublic())->validate('CZ65x8000000192000145399');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CzechRepublic', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new CzechRepublic())->validate('CZ650800000019200014539x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CzechRepublic', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new CzechRepublic())->validate('CZ650800000019200014539');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CzechRepublic', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new CzechRepublic())->validate('CZ65080000001920001453999');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CzechRepublic', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new CzechRepublic())->validate('CZ6508000000192000145390');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new CzechRepublic())->validate('CZ6508000000192000145399');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

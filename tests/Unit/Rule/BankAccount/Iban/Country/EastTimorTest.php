<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\EastTimor;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class EastTimorTest extends StringTestCase
{
    /**
     * EastTimorTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, EastTimor::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new EastTimor())->validate('XL380080012345678910157');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.EastTimor', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new EastTimor())->validate('TL280080012345678910157');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.EastTimor', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new EastTimor())->validate('TL38x080012345678910157');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.EastTimor', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new EastTimor())->validate('TL38008001234567891015x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.EastTimor', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new EastTimor())->validate('TL38008001234567891015');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.EastTimor', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new EastTimor())->validate('TL3800800123456789101577');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.EastTimor', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new EastTimor())->validate('TL380080012345678910158');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new EastTimor())->validate('TL380080012345678910157');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

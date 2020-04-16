<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\FaroeIslands;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class FaroeIslandsTest extends StringTestCase
{
    /**
     * FaroeIslandsTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, FaroeIslands::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new FaroeIslands())->validate('XO6264600001631634');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.FaroeIslands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new FaroeIslands())->validate('FOx264600001631634');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.FaroeIslands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new FaroeIslands())->validate('FO62x4600001631634');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.FaroeIslands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new FaroeIslands())->validate('FO626460000163163x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.FaroeIslands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new FaroeIslands())->validate('FO626460000163163');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.FaroeIslands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new FaroeIslands())->validate('FO62646000016316344');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.FaroeIslands', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new FaroeIslands())->validate('FO6264600001631635');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new FaroeIslands())->validate('FO6264600001631634');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

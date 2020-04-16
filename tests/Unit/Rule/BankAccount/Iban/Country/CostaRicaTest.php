<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\CostaRica;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class CostaRicaTest extends StringTestCase
{
    /**
     * CostaRicaTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, CostaRica::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new CostaRica())->validate('XR05015202001026284066');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CostaRica', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new CostaRica())->validate('CRx5015202001026284066');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CostaRica', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveReserveNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new CostaRica())->validate('CR05115202001026284066');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CostaRica', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new CostaRica())->validate('CR050x5202001026284066');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CostaRica', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new CostaRica())->validate('CR0501520200102628406x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CostaRica', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new CostaRica())->validate('CR0501520200102628406');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CostaRica', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new CostaRica())->validate('CR050152020010262840666');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.CostaRica', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new CostaRica())->validate('CR05015202001026284067');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new CostaRica())->validate('CR05015202001026284066');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\BosniaAndHerzegovina;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class BosniaAndHerzegovinaTest extends StringTestCase
{
    /**
     * BosniaAndHerzegovinaTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, BosniaAndHerzegovina::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new BosniaAndHerzegovina())->validate('XA391290079401028494');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.BosniaAndHerzegovina', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new BosniaAndHerzegovina())->validate('BA291290079401028494');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.BosniaAndHerzegovina', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new BosniaAndHerzegovina())->validate('BA39x290079401028494');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.BosniaAndHerzegovina', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new BosniaAndHerzegovina())->validate('BA39129007940102849x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.BosniaAndHerzegovina', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new BosniaAndHerzegovina())->validate('BA39129007940102849');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.BosniaAndHerzegovina', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new BosniaAndHerzegovina())->validate('BA3912900794010284944');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.BosniaAndHerzegovina', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new BosniaAndHerzegovina())->validate('BA391290079401028495');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new BosniaAndHerzegovina())->validate('BA391290079401028494');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

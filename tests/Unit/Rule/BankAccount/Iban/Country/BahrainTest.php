<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Bahrain;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class BahrainTest extends StringTestCase
{
    /**
     * BahrainTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Bahrain::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bahrain())->validate('XH67BMAG00001299123456');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Bahrain', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bahrain())->validate('BHx7BMAG00001299123456');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Bahrain', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bahrain())->validate('BH671MAG00001299123456');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Bahrain', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bahrain())->validate('BH67BMAG0000129912345!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Bahrain', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bahrain())->validate('BH67BMAG0000129912345');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Bahrain', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bahrain())->validate('BH67BMAG000012991234566');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Bahrain', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bahrain())->validate('BH67BMAG00001299123457');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bahrain())->validate('BH67BMAG00001299123456');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

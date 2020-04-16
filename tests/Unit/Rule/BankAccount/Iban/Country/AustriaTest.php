<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Austria;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class AustriaTest extends StringTestCase
{
    /**
     * AustriaTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Austria::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Austria())->validate('XT611904300234573201');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Austria', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Austria())->validate('ATx11904300234573201');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Austria', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Austria())->validate('AT61x904300234573201');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Austria', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Austria())->validate('AT61190430023457320x');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Austria', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Austria())->validate('AT61190430023457320');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Austria', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Austria())->validate('AT6119043002345732011');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Austria', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Austria())->validate('AT611904300234573202');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Austria())->validate('AT611904300234573201');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

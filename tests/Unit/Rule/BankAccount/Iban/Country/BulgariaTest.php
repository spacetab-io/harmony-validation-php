<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Bulgaria;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class BulgariaTest extends StringTestCase
{
    /**
     * BulgariaTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param mixed $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Bulgaria::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bulgaria())->validate('XG80BNBG96611020345678');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Bulgaria', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bulgaria())->validate('BGx0BNBG96611020345678');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Bulgaria', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bulgaria())->validate('BG80bNBG96611020345678');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Bulgaria', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bulgaria())->validate('BG80BNBG9661102034567!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Bulgaria', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bulgaria())->validate('BG80BNBG9661102034567');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Bulgaria', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bulgaria())->validate('BG80BNBG966110203456788');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Bulgaria', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bulgaria())->validate('BG80BNBG96611020345679');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Bulgaria())->validate('BG80BNBG96611020345678');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

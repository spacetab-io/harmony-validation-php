<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Kazakhstan;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class KazakhstanTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Kazakhstan::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Kazakhstan())->validate('XZ86125KZT5004100100');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kazakhstan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Kazakhstan())->validate('KZx6125KZT5004100100');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kazakhstan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Kazakhstan())->validate('KZ86x25KZT5004100100');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kazakhstan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Kazakhstan())->validate('KZ86125KZT500410010!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kazakhstan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Kazakhstan())->validate('KZ86125KZT500410010');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kazakhstan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Kazakhstan())->validate('KZ86125KZT50041001000');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kazakhstan', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Kazakhstan())->validate('KZ86125KZT5004100101');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Kazakhstan())->validate('KZ86125KZT5004100100');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

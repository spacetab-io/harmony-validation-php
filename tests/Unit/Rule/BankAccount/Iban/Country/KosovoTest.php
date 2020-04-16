<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Kosovo;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class KosovoTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Kosovo::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Kosovo())->validate('YK051212012345678906');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kosovo', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Kosovo())->validate('XKx51212012345678906');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kosovo', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Kosovo())->validate('XK05x212012345678906');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kosovo', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Kosovo())->validate('XK05121201234567890!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kosovo', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Kosovo())->validate('XK05121201234567890');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kosovo', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Kosovo())->validate('XK0512120123456789066');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Kosovo', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Kosovo())->validate('XK051212012345678907');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Kosovo())->validate('XK051212012345678906');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

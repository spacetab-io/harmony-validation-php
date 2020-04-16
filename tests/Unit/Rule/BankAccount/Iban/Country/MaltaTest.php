<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\BankAccount\Iban\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\BankAccount\Iban\Country\Malta;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class MaltaTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Malta::class);
    }

    public function testValidateFailsWhenStringDoesNotStartWithCountryCode()
    {
        /** @var Result $result */
        $result = yield (new Malta())->validate('XT84MALT011000012345MTLCAST001S');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Malta', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveChecksum()
    {
        /** @var Result $result */
        $result = yield (new Malta())->validate('MTx4MALT011000012345MTLCAST001S');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Malta', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveBankAndBranchCode()
    {
        /** @var Result $result */
        $result = yield (new Malta())->validate('MT84mALT011000012345MTLCAST001S');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Malta', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringDoesNotHaveAccountNumber()
    {
        /** @var Result $result */
        $result = yield (new Malta())->validate('MT84MALT011000012345MTLCAST001!');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Malta', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooShort()
    {
        /** @var Result $result */
        $result = yield (new Malta())->validate('MT84MALT011000012345MTLCAST001');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Malta', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenStringIsTooLong()
    {
        /** @var Result $result */
        $result = yield (new Malta())->validate('MT84MALT011000012345MTLCAST001SS');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Country.Malta', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenChecksumFails()
    {
        /** @var Result $result */
        $result = yield (new Malta())->validate('MT84MALT011000012345MTLCAST001T');

        $this->assertFalse($result->isValid());
        $this->assertSame('BankAccount.Iban.Checksum', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidIbanString()
    {
        /** @var Result $result */
        $result = yield (new Malta())->validate('MT84MALT011000012345MTLCAST001S');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

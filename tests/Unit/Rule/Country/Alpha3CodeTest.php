<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Country;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Country\Alpha3Code;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class Alpha3CodeTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Alpha3Code::class);
    }

    public function testValidateFailsOnAnInvalidAlpha2CountryCode()
    {
        /** @var Result $result */
        $result = yield (new Alpha3Code())->validate('XXX');

        $this->assertFalse($result->isValid());
        $this->assertSame('Country.Alpha3Code', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsOnAValidLowercaseAlpha2CountryCode()
    {
        /** @var Result $result */
        $result = yield (new Alpha3Code())->validate('nld');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsOnAValidUppercaseAlpha2CountryCode()
    {
        /** @var Result $result */
        $result = yield (new Alpha3Code())->validate('NLD');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

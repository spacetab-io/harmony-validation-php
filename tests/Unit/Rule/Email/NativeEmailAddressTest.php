<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Email;

use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Email\NativeEmailAddress;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class NativeEmailAddressTest extends StringTestCase
{
    /**
     * @param mixed[] $data
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, NativeEmailAddress::class);
    }

    public function testValidateFailsWhenEmailAddressIsInvalid()
    {
        /** @var Result $result */
        $result = yield (new NativeEmailAddress())->validate('invalid-email-address');

        $this->assertFalse($result->isValid());
        $this->assertSame('Email.NativeEmailAddress', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenEmailAddressIsValid()
    {
        /** @var Result $result */
        $result = yield (new NativeEmailAddress())->validate('test@example.com');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

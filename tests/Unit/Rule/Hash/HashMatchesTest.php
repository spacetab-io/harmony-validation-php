<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Hash;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Hash\HashMatches;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class HashMatchesTest extends StringTestCase
{
    /**
     * HashMatchesTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, HashMatches::class, '1234567890');
    }

    public function testValidateFailsWhenHashIsInvalid(): Generator
    {
        /** @var Result $result */
        $result = yield (new HashMatches('1234567890'))->validate('123456789');

        $this->assertFalse($result->isValid());
        $this->assertSame('Hash.HashMatches', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenHashIsValid(): Generator
    {
        /** @var Result $result */
        $result = yield (new HashMatches('1234567890'))->validate('1234567890');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

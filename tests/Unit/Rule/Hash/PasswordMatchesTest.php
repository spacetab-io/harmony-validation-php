<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Hash;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Hash\PasswordMatches;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class PasswordMatchesTest extends StringTestCase
{
    private const TEST_HASH = '$2y$10$PcRLWTmmlKptOuNnAZfmneSKIL7sSZ.j2ELZuNSncVSzqoovWNVzC';

    /**
     * PasswordMatchesTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, PasswordMatches::class, self::TEST_HASH);
    }

    public function testValidateFailsWhenPasswordIsInvalid(): Generator
    {
        /** @var Result $result */
        $result = yield (new PasswordMatches(self::TEST_HASH))->validate('123456789');

        $this->assertFalse($result->isValid());
        $this->assertSame('Hash.PasswordMatches', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPasswordIsValid(): Generator
    {
        /** @var Result $result */
        $result = yield (new PasswordMatches(self::TEST_HASH))->validate('1234567890');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Uuid;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Uuid\Nil;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class NilTest extends StringTestCase
{
    /**
     * NilTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Nil::class);
    }

    public function testValidateFailsWhenPassingAnInvalidNilUuidString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Nil())->validate('00000000-0000-0000-0000-000000000001');

        $this->assertFalse($result->isValid());
        $this->assertSame('Uuid.Nil', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAValidNilUuidString(): Generator
    {
        /** @var Result $result */
        $result = yield (new Nil())->validate('00000000-0000-0000-0000-000000000000');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

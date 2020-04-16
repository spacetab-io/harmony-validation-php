<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\Type;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Type\StringType;
use HarmonyIO\ValidationTest\Unit\Rule\StringTestCase;

class StringTypeTest extends StringTestCase
{
    /**
     * StringTypeTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, StringType::class);
    }

    public function testValidateSucceedsWhenPassingAString(): Generator
    {
        /** @var Result $result */
        $result = yield (new StringType())->validate('€');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

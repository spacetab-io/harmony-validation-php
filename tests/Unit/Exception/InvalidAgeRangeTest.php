<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Exception;

use Amp\PHPUnit\AsyncTestCase;
use HarmonyIO\Validation\Exception\InvalidAgeRange;

class InvalidAgeRangeTest extends AsyncTestCase
{
    public function testMessageIsFormattedCorrectly(): void
    {
        $typeException = new InvalidAgeRange(21, 18);

        $this->assertSame(
            'The minimum age (`21`) can not be greater than the maximum age (`18`).',
            $typeException->getMessage()
        );
    }
}

<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Exception;

use Amp\PHPUnit\AsyncTestCase;
use HarmonyIO\Validation\Exception\InvalidLongitude;

class InvalidLongitudeTest extends AsyncTestCase
{
    public function testMessageIsFormattedCorrectly(): void
    {
        $typeException = new InvalidLongitude(185);

        $this->assertSame(
            'Provided longitude (`185`) must be within range -180 to 180 (exclusive).',
            $typeException->getMessage()
        );
    }
}

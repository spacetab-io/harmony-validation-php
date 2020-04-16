<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\GeoLocation;

use Generator;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\GeoLocation\Longitude;
use HarmonyIO\ValidationTest\Unit\Rule\NumericTestCase;

class LongitudeTest extends NumericTestCase
{
    /**
     * LongitudeTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, Longitude::class);
    }

    public function testValidateFailsWhenPassingAnIntegerBelowThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate(-180);

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Longitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnIntegerAboveThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate(180);

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Longitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnIntegerAsAStringBelowThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate('-180');

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Longitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnIntegerAsAStringAboveThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate('180');

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Longitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloatBelowThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate(-180.0);

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Longitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloatAboveThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate(180.0);

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Longitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloatAsAStringBelowThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate('-180.0');

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Longitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloatAsAStringAboveThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate('180.0');

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Longitude', $result->getFirstError()->getMessage());
    }

    public function testValidateSucceedsWhenPassingAnIntegerWithInLowerRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate(-179);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnIntegerWithInHigherRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate(179);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnIntegerAsAStringWithInLowerRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate('-179');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnIntegerAsAStringWithInHigherRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate('179');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatWithInLowerRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate(-179.9);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatWithInHigherRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate(179.9);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatAsAStringWithInLowerRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate('-179.9');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatAsAStringWithInHigherRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new Longitude())->validate('179.9');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

<?php declare(strict_types=1);

namespace HarmonyIO\ValidationTest\Unit\Rule\GeoLocation;

use Generator;
use HarmonyIO\Validation\Exception\InvalidLatitude;
use HarmonyIO\Validation\Exception\InvalidNumericalRange;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\GeoLocation\LatitudeRange;
use HarmonyIO\ValidationTest\Unit\Rule\NumericTestCase;

class LatitudeRangeTest extends NumericTestCase
{
    /**
     * LatitudeRangeTest constructor.
     *
     * @param string|null $name
     * @param array<mixed> $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName, LatitudeRange::class, 60, 80);
    }

    public function testConstructorThrowsWhenMinimumValueIsGreaterThanMaximumValue(): void
    {
        $this->expectException(InvalidNumericalRange::class);
        $this->expectExceptionMessage('The minimum (`51`) can not be greater than the maximum (`50`).');

        new LatitudeRange(51, 50);
    }

    public function testConstructorThrowsOnOutOfRangeMinimumValueTooLow(): void
    {
        $this->expectException(InvalidLatitude::class);
        $this->expectExceptionMessage('Provided latitude (`-90`) must be within range -90 to 90 (exclusive).');

        new LatitudeRange(-90, 50);
    }

    public function testConstructorThrowsOnOutOfRangeMinimumValueTooHigh(): void
    {
        $this->expectException(InvalidLatitude::class);
        $this->expectExceptionMessage('Provided latitude (`90`) must be within range -90 to 90 (exclusive).');

        new LatitudeRange(90, 90);
    }

    public function testConstructorThrowsOnOutOfRangeMaximumValueTooLow(): void
    {
        $this->expectException(InvalidLatitude::class);
        $this->expectExceptionMessage('Provided latitude (`-90`) must be within range -90 to 90 (exclusive).');

        new LatitudeRange(-90, -90);
    }

    public function testConstructorThrowsOnOutOfRangeMaximumValueTooHigh(): void
    {
        $this->expectException(InvalidLatitude::class);
        $this->expectExceptionMessage('Provided latitude (`90`) must be within range -90 to 90 (exclusive).');

        new LatitudeRange(50, 90);
    }

    public function testValidateFailsWhenPassingAnIntegerBelowThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(60, 80))->validate(-90);

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Latitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnIntegerAboveThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(60, 80))->validate(90);

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Latitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnIntegerAsAStringBelowThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(60, 80))->validate('-90');

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Latitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnIntegerAsAStringAboveThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(60, 80))->validate('90');

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Latitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloatBelowThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(60, 80))->validate(-90.0);

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Latitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloatAboveThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(60, 80))->validate(90.0);

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Latitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloatAsAStringBelowThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(60, 80))->validate('-90.0');

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Latitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAFloatAsAStringAboveThreshold(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(60, 80))->validate('90.0');

        $this->assertFalse($result->isValid());
        $this->assertSame('GeoLocation.Latitude', $result->getFirstError()->getMessage());
    }

    public function testValidateFailsWhenPassingAnIntegerSmallerThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(13, 16))->validate(12);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Minimum', $result->getFirstError()->getMessage());
        $this->assertSame('minimum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(13.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAnIntegerBiggerThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(13, 16))->validate(17);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Maximum', $result->getFirstError()->getMessage());
        $this->assertSame('maximum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(16.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAnIntegerAsAStringSmallerThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(13, 16))->validate('12');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Minimum', $result->getFirstError()->getMessage());
        $this->assertSame('minimum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(13.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAnIntegerAsAStringBiggerThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(13, 16))->validate('17');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Maximum', $result->getFirstError()->getMessage());
        $this->assertSame('maximum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(16.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAFloatSmallerThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(13, 16))->validate(12.9);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Minimum', $result->getFirstError()->getMessage());
        $this->assertSame('minimum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(13.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAFloatBiggerThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(13, 16))->validate(16.1);

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Maximum', $result->getFirstError()->getMessage());
        $this->assertSame('maximum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(16.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAFloatAsAStringSmallerThanMinimum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(13, 16))->validate('12.9');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Minimum', $result->getFirstError()->getMessage());
        $this->assertSame('minimum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(13.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateFailsWhenPassingAFloatAsAStringBiggerThanMaximum(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(13, 16))->validate('16.1');

        $this->assertFalse($result->isValid());
        $this->assertSame('Numeric.Maximum', $result->getFirstError()->getMessage());
        $this->assertSame('maximum', $result->getFirstError()->getParameters()[0]->getKey());
        $this->assertSame(16.0, $result->getFirstError()->getParameters()[0]->getValue());
    }

    public function testValidateSucceedsWhenPassingAnIntegerWithinRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(13, 16))->validate(13);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAnIntegerAsStringWithinRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(13, 16))->validate('13');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatWithinRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(13, 16))->validate(13.0);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }

    public function testValidateSucceedsWhenPassingAFloatAsStringWithinRange(): Generator
    {
        /** @var Result $result */
        $result = yield (new LatitudeRange(13, 16))->validate('13.0');

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getFirstError());
    }
}

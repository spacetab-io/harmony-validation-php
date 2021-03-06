<?php declare(strict_types=1);

namespace HarmonyIO\Validation\Rule\GeoLocation;

use Amp\Promise;
use HarmonyIO\Validation\Exception\InvalidLongitude;
use HarmonyIO\Validation\Exception\InvalidNumericalRange;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Numeric\Range;
use HarmonyIO\Validation\Rule\Rule;
use function Amp\call;

class LongitudeRange implements Rule
{
    /** @var int */
    private $minimumLongitude;

    /** @var int */
    private $maximumLongitude;

    public function __construct(float $minimumLongitude, float $maximumLongitude)
    {
        if ($minimumLongitude > $maximumLongitude) {
            throw new InvalidNumericalRange($minimumLongitude, $maximumLongitude);
        }

        if (!$this->isLongitudeValid($minimumLongitude)) {
            throw new InvalidLongitude($minimumLongitude);
        }

        if (!$this->isLongitudeValid($maximumLongitude)) {
            throw new InvalidLongitude($maximumLongitude);
        }

        $this->minimumLongitude = $minimumLongitude;
        $this->maximumLongitude = $maximumLongitude;
    }

    private function isLongitudeValid(float $longitude): bool
    {
        return $longitude > -180 && $longitude < 180;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value): Promise
    {
        return call(function () use ($value) {
            /** @var Result $result */
            $result = yield (new Longitude())->validate($value);

            if (!$result->isValid()) {
                return $result;
            }

            return (new Range($this->minimumLongitude, $this->maximumLongitude))->validate($value);
        });
    }
}

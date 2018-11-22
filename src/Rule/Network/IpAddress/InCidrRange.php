<?php declare(strict_types=1);

namespace HarmonyIO\Validation\Rule\Network\IpAddress;

use Amp\Promise;
use Amp\Success;
use HarmonyIO\Validation\Exception\InvalidCidrRange;
use HarmonyIO\Validation\Rule\Rule;
use Wikimedia\IPSet;

class InCidrRange implements Rule
{
    /** @var IPSet */
    private $cidrRanges;

    public function __construct(string ...$cidrRanges)
    {
        $currentErrorHandler = set_error_handler(function(int $errorNumber, string $errorMessage) {
            throw new InvalidCidrRange($errorMessage, $errorNumber);
        }, E_WARNING | E_USER_WARNING);

        $this->cidrRanges = new IPSet($cidrRanges);

        set_error_handler($currentErrorHandler);
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value): Promise
    {
        if (!is_string($value)) {
            return new Success(false);
        }

        return new Success($this->cidrRanges->match($value));
    }
}
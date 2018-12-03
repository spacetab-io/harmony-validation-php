<?php declare(strict_types=1);

namespace HarmonyIO\Validation\Rule\FileSystem;

use Amp\Promise;
use Amp\Success;
use HarmonyIO\Validation\Rule\Rule;
use function Amp\File\isdir;

final class Directory implements Rule
{
    /**
     * {@inheritdoc}
     */
    public function validate($value): Promise
    {
        if (!is_string($value)) {
            return new Success(false);
        }

        return isdir($value);
    }
}
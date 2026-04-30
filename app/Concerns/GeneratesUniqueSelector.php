<?php

namespace App\Concerns;

use Illuminate\Support\Str;

trait GeneratesUniqueSelector
{
    /**
     * Generate a unique selector.
     */
    protected static function generateUniqueSelector(string $projectName, string $resourceName): string
    {
        return Str::slug("$projectName-$resourceName-".Str::random(8));
    }
}

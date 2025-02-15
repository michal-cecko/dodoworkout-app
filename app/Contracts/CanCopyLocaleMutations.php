<?php

namespace App\Contracts;

use App\Enum\Locale;

interface CanCopyLocaleMutations
{
    public function copyMutation(Locale $sourceLocale, Locale $targetLocale): void;
}

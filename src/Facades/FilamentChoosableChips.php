<?php

namespace VitisStudio\FilamentChoosableChips\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VitisStudio\FilamentChoosableChips\FilamentChoosableChips
 */
class FilamentChoosableChips extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \VitisStudio\FilamentChoosableChips\FilamentChoosableChips::class;
    }
}

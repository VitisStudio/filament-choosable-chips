<?php

namespace VitisStudio\FilamentChoosableChips\Commands;

use Illuminate\Console\Command;

class FilamentChoosableChipsCommand extends Command
{
    public $signature = 'filament-choosable-chips';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

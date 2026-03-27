<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:generate-weekly-report')]
#[Description('Command description')]
class GenerateWeeklyReport extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}

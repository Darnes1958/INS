<?php

namespace App\Listeners;

use App\Events\ExcelLoaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IfExcelLoaded
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ExcelLoaded  $event
     * @return void
     */
    public function handle(ExcelLoaded $event)
    {
     return $event->ffilename;
    }
}

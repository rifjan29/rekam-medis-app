<?php

namespace App\Console\Commands;

use App\Http\Controllers\ReminderController;
use Illuminate\Console\Command;

class SendReturnReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-return-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reminder = new ReminderController;
        $reminder->sendWhatsAppMessage();

    }
}

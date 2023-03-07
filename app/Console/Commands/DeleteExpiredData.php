<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DeleteExpiredData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredData = Transaction::where('expire', '<=', Carbon::now())->get();
        foreach ($expiredData as $data) {
            $data->delete();
            if (session('notif') == 1) {
                session()->forget('notif');
            }else{
                $notif = session('notif') - 1;
                session()->put('notif',$notif);
            }
        }
        
    }
}

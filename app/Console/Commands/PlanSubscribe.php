<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Order;
use Carbon\Carbon;

class PlanSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Subscribe for user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Word of the Day sent to All Users');
        $expiry = Carbon::now()->format('Y-m-d');
        Log::info('Showing user profile for user:'. $expiry);
        $orders = Order::where('is_active', 1)
                    ->where("expiry_date", trim($expiry))->get();
        if (sizeof($orders) > 0) {
            $newExpiry = Carbon::now();
            foreach ($orders as &$order) {
                $paymentStatus = $this->triggerPayment();
                $order->is_active = 0;
                $order->save();
                if($paymentStatus === true) {
                    $newExpiry->addDays($order->plan_id == 1 ? 1 : 2);
                    $newExpiry = $newExpiry->format('Y-m-d');
                    Order::create([
                        'user_id' => $order->user_id,
                        'plan_id' => $order->plan_id,
                        'expiry_date' => $newExpiry,
                        'is_active' => 1,
                    ]);
                }
                // Log::info(json_encode($order->is_active));
            }
        } else {
            Log::info("No Records for today");
        }
    }

    public function triggerPayment() {
        Log::info('Trigger payment');
        return true;
    }
}

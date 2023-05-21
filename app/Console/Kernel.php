<?php

namespace App\Console;

use App\Models\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Función para anular las ordenes pendientes cada 10 minutos
        $schedule->call(function () {

            $hora = now()->subMinute(1);
            $orders = Order::where('status', 1)->whereTime('created_at', '<=', $hora)->get();

            foreach ($orders as $order) {
                $items = json_decode($order->content);
                foreach ($items as $item) {
                    increate($item); //llamamos a la funcion en helpers
                }
                $order->status = 5;
                $order->save();
            }
        })->everyMinute(); //este codigo se genera cada minuto
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

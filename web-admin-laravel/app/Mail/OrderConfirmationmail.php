<?php

namespace App\Mail;

use App\Models\CMSModels\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user_address;
    public $orders_products;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (count($this->order->order_addresses) > 0) {
            $this->user_address = $this->order->order_addresses[0]->address;

        } else {
            $this->user_address = $this->order->vendor_order_addresses[0]->address;

        }
        $this->orders_products = '';
        if (count($this->order->order_products) > 0) {
            $this->orders_products = $this->order->order_products;

        } else {
            if(count( $this->order->vendor_order_products) > 0){
                $this->orders_products = $this->order->vendor_order_products;
            }
        }
        return $this->subject('Order Confirmation Email')->view('mails.order-confirmation-mail');
    }
}

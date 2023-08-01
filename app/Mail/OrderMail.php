<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\model\Order;
use App\model\ProductCart;
use App\model\FoodMenu;
use App\model\Store;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        $bill_number = Order::orderBy('id','desc')->value('bill_number');
        $product_id = ProductCart::where('bill_number',$bill_number)->value('product_id');
        $store_id = FoodMenu::where('id',$product_id)->value('store_id');
        $store = Store::where('id',$store_id)->value('name');
        return $this->subject('['.$store.' Delivery] คำสั่งซื้อหมายเลข '.$bill_number)->view('emails.OrderMail');
    }
}

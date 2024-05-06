<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\User;


class DeliveryController extends Controller
{

   public function deliverydetail($username)
   {
       $deliveries = Delivery::where('recipient_name', $username)->get();

       return view('delivery.deliverydetail', compact('deliveries'));
   }

    /////////// submit the successful form //////
    public function deliverySuccess(Request $request, $order_id)
{
    // Find the existing delivery record
    $delivery = Delivery::where('order_id', $order_id)->first();

    // If the delivery record exists, update its status to "delivered"
    if ($delivery) {
        $delivery->delivery_status = 'delivered';
        $delivery->payment_status= 'Paid';
    } else {
        // If the delivery record does not exist, create a new one
        $delivery = new Delivery();
        $delivery->order_id = $order_id;
        $delivery->delivery_status = 'delivered';
        $delivery->payment_status = 'Paid'; // Set the delivery status to "delivered"
        // Assuming you have a user_id column
        $delivery->delivery_person_id = Auth::user()->id;
    }

    // Set the message from the request
    $delivery->message = $request->input('message');

    // Save the new Delivery instance to the database
    $delivery->save();

    // update payment status in the order table
    $order = Order::find($order_id);
    $order->payment_status = 'paid';
    $order->delivery_status = 'delivered';
     // Assuming payment is considered paid upon successful delivery
    $order->save();

    // Retrieve all deliveries to pass to the view
    $deliveries = Delivery::all(); // Adjust this query as needed

    // Return the view with the $deliveries variable
    return view('delivery.delivery_success', compact('deliveries'));
}


    /////////// back to the delivery home page ////////////
    public function showDeliveryHomePage()
    {
        $deliveries = Delivery::all();
        $username = $deliveries->recipient_name;


        $user = User::where('username', $username)->first();

        return view('delivery.delivery', compact('user', 'delivery'));
    }

    public function edit($order_id)
    {
        $deliveries = Delivery::where('order_id', $order_id)->get();
        return view('delivery.signature_submit', compact('deliveries'));
    }

    /////////// Failed to form to submit///////////

    public function showReasonForFail(Request $request, $order_id)
    {
        // Find the existing delivery record
        $delivery = Delivery::where('order_id', $order_id)->first();

        // If the delivery record exists, update its status to "fail"
        if ($delivery) {
            $delivery->delivery_status = 'fail';
            $delivery->message = $request->input('message');
            $delivery->save();
        } else {
            // If the delivery record does not exist, create a new one and set status to "fail"
            $delivery = new Delivery();
            $delivery->order_id = $order_id;
            $delivery->delivery_status = 'fail'; // Set the delivery status to "fail"
            // Assuming you have a user_id column
            $delivery->delivery_person_id = Auth::user()->id;
            $delivery->save();
        }

        // Update the order status to "Fail" in the orders table
        $order = Order::find($order_id);
        if ($order) {
            $order->delivery_status = 'Fail';
            $order->save();
        }

        // Retrieve all deliveries to pass to the view
        $deliveries = Delivery::all(); // Adjust this query as needed

        // Return the view with the $delivery and $deliveries variables
        return view('delivery.fail_delivery', compact('delivery', 'deliveries'));
    }


    ///////// cancel back to the signature submit/////



    //////// fail signature to confirm///

    public function handleFormSubmission(Request $request)
{
    // Your form submission logic here

    return view('delivery.fail_delivery');
}

///////////// in fail page click back to the delivery home page ///////////////


}



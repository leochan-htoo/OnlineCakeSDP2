<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

use Stripe;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Delivery;
use Carbon\Carbon;

class HomeController extends Controller
{

///////////// after click on the image on the order table will views details about images

    public function index()
    {
        if (Auth::check()) {

        $userId = Auth::user()->id;
        $totalQuantity = Cart::where('user_id', $userId)->count();

        }
        else
        {
            $totalQuantity=0;
        }
        // can limit data product category in user viewpage "$product=Product::paginate(10);"
        $product=Product::paginate(6);

        $comment=comment::orderby('id','desc')->get();

        $reply=reply::all();

        return view('home.userpage', compact('product', 'totalQuantity','comment','reply'));
    }
    public function redirect()
        {
            $usertype = Auth::user()->usertype;

            // create total price from user of record in Admin panel
            if ($usertype == '1') {

                //it is count total amout of product display in admin panel
                $total_product = Product::all()->count();

                //it is count total amout of  total order product
                $total_order = Order::all()->count();

                //it is count total amout of user
                $total_user = User::all()->count();

                $order = Order::all();

                $total_revenue = 0;

                foreach ($order as $order) {
                    $total_revenue = $total_revenue + $order->price;
                }

                //it is count total amout of total of delivery
                $total_delivered=order::where('delivery_status','=','delivered')->get()->count();

                //it is count total amout of total processing
                $total_processing=order::where('delivery_status','=','processing')->get()->count();


                return view('admin.home', compact('total_product', 'total_order', 'total_user', 'total_revenue','total_delivered', 'total_processing'));
            } elseif ($usertype == '0') {

                // Cart number logic
                $userId = Auth::user()->id;
                $totalQuantity = Cart::where('user_id', $userId)->count();

                // Use the same product of home.userpage to view product
                $product = Product::paginate(6);
                // use this for comment defined
                $comment=comment::orderby('id','desc')->get();
                $reply=reply::all();

                return view('home.userpage', compact('product', 'totalQuantity','comment','reply'));
            } else {
                // $users = User::where('usertype', "0")->get();

                // $delivery = collect(); // Initialize $delivery as a collection
                // $delivery = Delivery::all();
                // foreach ($users as $user) {
                //     $delivery_user = Delivery::where('recipient_name', $user->name)->get();

                //     if ($delivery_user->isEmpty()) { // Use isEmpty() to check if collection is empty
                //         // If there are no deliveries for this user, you might want to process this case
                //         // For example, you could set a default delivery status or action
                //     } else {
                //         // Merge delivery_user into $delivery collection
                //         $delivery = $delivery->merge($delivery_user);
                //     }
                // }

                // return view('delivery.delivery', compact('users', 'delivery'));
                $users = User::where('usertype', "0")->get();
                $delivery = Delivery::all();
                $statusMessages = []; // Initialize an array to store status messages for each user

                foreach ($users as $user) {
                    $delivery_user = Delivery::where('recipient_name', $user->name)->get();
                    $processingCount = 0; // Initialize the count of processing deliveries for this user

                    if ($delivery_user->isEmpty()) {
                        // If no deliveries for this user, handle it accordingly, for example:
                        // $statusMessages[$user->name] = "No deliveries";
                    } else {
                        foreach ($delivery_user as $item) {
                            if ($item->delivery_status == "processing") {
                                $processingCount++; // Increment processing count if delivery is still processing
                            }
                        }
                    }

                        // Store the processing count and status message for this user
                        $statusMessages[$user->name] = [
                            'processingCount' => $processingCount,
                            'status' => $processingCount > 0 ? "Processing" : ($delivery_user->isEmpty() ? "No deliveries" : "Delivered")
                        ];




                }

                return view('delivery.delivery', compact('users', 'delivery', 'statusMessages'));



            }
        }


    // this controller function logic is for view product_details before buying
    public function product_details($id)

    {
        if (Auth::id()) {
        $user = Auth::user();
        $userid = $user->id;
        $product=product::find($id);
        $totalQuantity = Cart::where('user_id', $userid)->count();
        $orders = Order::where('user_id', $userid)->latest()->get();
        return view('home.product_details', compact('product','totalQuantity'));
        }
    }

// This Functionality is used for add

    // add this route function to add product in the cart
    public function add_cart(Request $request, $id)
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $product = Product::find($id);

            // Check if the product exists
            if (!$product) {
                return redirect()->back()->with('message', 'Product not found');
            }

            // Check if the product quantity is zero
            if ($product->quantity === 0) {
                return redirect()->back()->with('message', 'Product is out of stock');
            }

            // Check if the requested quantity is zero
            $requestedQuantity = $request->quantity;
            if ($requestedQuantity <= 0) {
                return redirect()->back()->with('message', 'Invalid quantity');
            }

            $product_exist_id = Cart::where('product_id', '=', $id)->where('user_id', '=', $userid)->first();

            if ($product_exist_id) {
                $cart = Cart::find($product_exist_id->id);

                // Check if adding the requested quantity exceeds the available quantity
                $newQuantity = $cart->quantity + $requestedQuantity;


                $cart->quantity = $newQuantity;

                if ($product->dis_price != null) {
                    $cart->price = $product->discount_price * $newQuantity;
                } else {
                    $cart->price = $product->price * $newQuantity;
                }

                $cart->save();

                // Assuming you have a method to decrease the product quantity in your database
                $this->decreaseProductQuantity($product, $requestedQuantity);

                return redirect()->back()->with('message', 'Product Added Successfully');
            } else {
                $cart = new Cart;
                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->phone = $user->phone;
                $cart->address = $user->address;
                $cart->user_id = $user->id;

                $cart->Product_title = $product->title;

                // Check if the requested quantity exceeds the available quantity
                if ($requestedQuantity > $product->quantity) {
                    return redirect()->back()->with('error', 'Quantity exceeds available stock');
                }

                if ($product->dis_price != null) {
                    $cart->price = $product->discount_price * $requestedQuantity;
                } else {
                    $cart->price = $product->price * $requestedQuantity;
                }

                $cart->image = $product->image;
                $cart->Product_id = $product->id;

                $cart->quantity = $requestedQuantity;

                $cart->save();

                // Assuming you have a method to decrease the product quantity in your database
                $this->decreaseProductQuantity($product, $requestedQuantity);

                return redirect()->back()->with('message', 'Product Added Successfully');
            }
        } else {
            return redirect('login');
        }
    }

    // Add this method to decrease the product quantity in the database
    private function decreaseProductQuantity($product, $quantity)
    {
        // Your logic to decrease the product quantity in the database goes here
        // For example, you can decrement the 'quantity' column in the 'products' table
        $product->quantity -= $quantity;
        $product->save();
    }

    //this function will show cart notification sign after user add card
    //use this logic function "$id=Auth::user()->id;" makesure to know user
    //authticate user add cart after login
    public function show_cart()
    {
        //use "if(Auth::id())" to check which user is auth adding cart
        if(Auth::id())
        {
            $userId = Auth::user()->id;

            $totalQuantity = Cart::where('user_id', $userId)->count();


            $id=Auth::user()->id;
            $cart=cart::where('user_id','=',$id)->get();
            return view('home.showcart', compact('cart', 'totalQuantity'));
        }
        // if no user login authenticate will require to login page
        else
        {
            return redirect('login');
        }

    }
    //this function will remove product after adding product in package cart
    public function remove_cart($id)
    {
        $cart=cart::find($id);

        $cart->delete();

        return redirect()->back();
    }

    //this function will use for order payment for order items for order database to record in database attribute
    public function cash_order(Request $request)
{
    $user = Auth::user();
    $userid = $user->id;

    $data = cart::where('user_id', '=', $userid)->get();

    foreach ($data as $item) {
        $order = new Order;

        $order->name = $item->name;
        $order->email = $item->email;
        $order->phone = $item->phone;
        $order->address = $item->address;
        $order->user_id = $item->user_id;

        $order->product_title = $item->product_title;
        $order->price = $item->price;
        $order->quantity = $item->quantity;
        $order->image = $item->image;
        $order->product_id = $item->product_id;

        $order->payment_status = 'cash on delivery';
        $order->delivery_status = 'processing';

        $order->save();

        $cart = cart::find($item->id);
        $cart->delete();

        //SAVE IN DELIVERY TABLE
        $delivery = new Delivery;

        $delivery->order_id = $order->id; // Use the newly created order's ID
        $delivery->recipient_name = $order->name;
        $delivery->phone_number = $order->phone;
        $delivery->price = $order->price;
        $delivery->quantity = $order->quantity;
        $delivery->image = $order->image;
        $delivery->payment_status = $order->payment_status;

        $delivery->delivery_person_id = Auth::user()->id;

        // Check if TextArea1 is set and not null
        if ($request->has('TextArea1') && $request->TextArea1 !== null) {
            $delivery->message = $request->TextArea1;
        } else {
            $delivery->message = ''; // or any default message you want to set
        }

        $delivery->address = $order->address;
        $delivery->delivery_status = $order->delivery_status;
        $delivery->delivery_date = Carbon::today();

        $delivery->save();
    }

    return redirect()->back()->with('message', 'We have received your order. We will connect with you soon...');
}

// This function logic is for payment stripe
public function stripe($totalprice)
{
    $userId = Auth::user()->id;
    $totalQuantity = Cart::where('user_id', $userId)->count();


    return view('home.stripe', compact('totalprice','totalQuantity'));
}

public function stripePost(Request $request, $totalprice)
{
    // dd(env('STRIPE_SECRET'));
    // stripe_secret API key is set up in env
    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    \Stripe\Charge::create([
        "amount" => $totalprice * 100,
        "currency" => "thb",
        "source" => $request->stripeToken,
        "description" => "Thank you for payment."
    ]);

            $user = Auth::user();
            $userid = $user->id;

            $data = cart::where('user_id', '=', $userid)->get();

            foreach ($data as $item) {
                $order = new Order;

                $order->name = $item->name;
                $order->email = $item->email;
                $order->phone = $item->phone;
                $order->address = $item->address;
                $order->user_id = $item->user_id;

                $order->product_title = $item->product_title;
                $order->price = $item->price;
                $order->quantity = $item->quantity;
                $order->image = $item->image;
                $order->product_id = $item->product_id;

                $order->payment_status = 'paid';
                $order->delivery_status = 'processing';

                $order->save();

                $cart = cart::find($item->id);
                $cart->delete();

                $delivery = new Delivery;

        $delivery->order_id = $order->id; // Use the newly created order's ID
        $delivery->recipient_name = $order->name;
        $delivery->phone_number = $order->phone;
        $delivery->price = $order->price;
        $delivery->quantity = $order->quantity;
        $delivery->image = $order->image;
        $delivery->payment_status = $order->payment_status;

        $delivery->delivery_person_id = Auth::user()->id;

        // Check if TextArea1 is set and not null
        if ($request->has('TextArea1') && $request->TextArea1 !== null) {
            $delivery->message = $request->TextArea1;
        } else {
            $delivery->message = ''; // or any default message you want to set
        }

        $delivery->address = $order->address;
        $delivery->delivery_status = $order->delivery_status;
        $delivery->delivery_date = Carbon::today();

        $delivery->save();

            }
            Session::flash('success', 'Payment successful!');

            return back();
        }
        // // Process delivery creation
        // foreach ($cartItems as $item) {
        //     $delivery = new Delivery;

        //     // Populate delivery details
        //     $delivery->order_id = $order->id;
        //     $delivery->recipient_name = $order->name;
        //     $delivery->phone_number = $order->phone;
        //     $delivery->price = $order->price;
        //     $delivery->quantity = $order->quantity;
        //     $delivery->image = $order->image;
        //     $delivery->payment_status = $order->payment_status;
        //     $delivery->delivery_person_id = Auth::id(); // Assuming delivery person ID is the current user ID
        //     $delivery->message = $request->input('TextArea1', ''); // Check if TextArea1 exists
        //     $delivery->address = $order->address;
        //     $delivery->delivery_status = $order->delivery_status;
        //     $delivery->delivery_date = Carbon::today();

        //     $delivery->save();
        // }


        // This function logic is for view product for user
        public function product()
        {
            // Check if user is authenticated
            if (Auth::check()) {
                $userId = Auth::user()->id;

                // Paginate products with 6 products per page
                $product = Product::paginate(6);

                // Total quantity in cart for the user
                $totalQuantity = Cart::where('user_id', $userId)->count();

                // Get comments ordered by id in descending order
                $comment = Comment::orderBy('id', 'desc')->get();

                // Get all replies
                $replies = Reply::all();

                // Pass data to the view, including pagination data
                return view('home.all_product', compact('product', 'totalQuantity', 'comment', 'replies'));

            } else {
                // Handle the case where no user is authenticated
                return redirect()->route('login')->with('error', 'Please login to view this page.');
            }
        }




            // This function logic is for show user order in card
            public function show_order()
                {
                    if (Auth::id()) {
                        $user = Auth::user();
                        $userid = $user->id;

                        // Retrieve total quantity from the Cart model (assuming you have a Cart model)
                        $totalQuantity = Cart::where('user_id', $userid)->count();

                        // Retrieve orders from the Order model (assuming the model is named Order)
                        $orders = Order::where('user_id', $userid)->latest()->get();

                        return view('home.order', compact('orders', 'totalQuantity'));
                    } else {
                        return redirect('login');
                    }
                }


                // This function logic is for cancel after user order a few minute
                public function cancel_order(Request $request, $id)
{
    // Find the order
    $order = Order::find($id);

    // Check if order cancellation is allowed
    $allowedToCancel = $this->checkCancellationTime($order);

    if ($allowedToCancel) {
        // Update delivery status in the order table
        $order->delivery_status = 'You cancel the order';
        $order->save();

        // Find the associated delivery or create a new one if it doesn't exist
        $delivery = Delivery::where('order_id', $order->id)->first();
        if (!$delivery) {
            $delivery = new Delivery();
            $delivery->order_id = $order->id;
        }

        // Set recipient name or provide a default value if applicable
        $delivery->recipient_name = $order->name;
        $delivery->address = $order->address;
        $delivery->phone_number = $order->phone;
        $delivery->price = $order->price;

        // Check if message exists in the request
        if ($request->has('message')) {
            $delivery->message = $request->input('message');
        } else {
            $delivery->message = ''; // or provide a default value
        }

        $delivery->delivery_person_id = Auth::user()->id;

        // Set a delivery date (you can adjust this as needed)
        $delivery->delivery_date = now(); // Or use any specific date you want to set

        // Save cancellation message in the delivery table
        $delivery->delivery_status = 'You cancel the order';
        $delivery->save();

        // Redirect back
        return redirect()->back();
    } else {
        return redirect()->back()->with('error', 'Not allowed to cancel yet.');
    }
}

private function checkCancellationTime($order)
{
    // Check if current time is greater than 1 minute from order creation time
    $creationTime = strtotime($order->created_at);
    $currentTime = time();
    $timeDifference = $currentTime - $creationTime;
    $maxCancellationTime = 60; // 1 minute in seconds

    return $timeDifference <= $maxCancellationTime;
}




                // This function logic is for adding comment from user
                public function add_comment(Request $request)
                {
                    if(Auth::id())
                    {

                        $comment=new comment;
                        $comment->name=Auth::user()->name;
                        $comment->user_id=Auth::user()->id;
                        $comment->comment=$request->comment;

                        $comment->save();
                        return redirect()->back();
                    }
                    else
                    {
                        return redirect('login');
                    }
                }
                public function add_reply(Request $request)
                {
                    if(Auth::id())
                    {
                        $reply=new reply;
                        $reply->name=Auth::user()->name;
                        $reply->user_id=Auth::user()->id;
                        $reply->comment_id=$request->commentId;
                        $reply->reply=$request->reply;
                        $reply->save();
                        return redirect()->back();
                    }
                    else
                    {
                        return redirect('login');
                    }
                }
                ////////////what is
                // public function product_search(Request $request)
                // {
                //     $comment=comment::orderby('id','desc')->get();

                //     $reply=reply::all();
                //     $search_text=$request->search;



                //     return view('home.all_product',compact('product','comment','reply'));

                // }

                public function search_product(Request $request)
            {
                $comment = comment::orderby('id','desc')->get();
                $replies = reply::all(); // Renamed $reply to $replies
                $search_text = $request->search;

                $product = Product::where('title', 'LIKE', "%$search_text%")
                    ->orWhere('price', 'LIKE', "%$search_text%")
                    ->paginate(6);
                    if (Auth::id()) {
                        $user = Auth::user();
                        $userid = $user->id;

                        $totalQuantity = Cart::where('user_id', $userid)->count();

                    }


                return view('home.all_product', compact('product', 'comment', 'replies','totalQuantity')); // Passed $replies instead of $reply
            }



    }







<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/logo.png" type="">
      <title>Online Bakery Shop System</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
      <!-- font awesome style -->
      <link href="home/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="home/css/style.css" rel="stylesheet" />
      <!-- responsive style -->
      <link href="home/css/responsive.css" rel="stylesheet" />

      <style type="text/css">
        /* Custom styles for the cart icon and count */
        .cart-icon {
            display: flex;
            align-items: center;
            position: relative;
        }

        #cartCount {
            position: absolute;
            top: -10px; /* Adjust the top position to move the number higher */
            right: 5px;
            background-color: red; /* Customize the background color */
            color: white; /* Customize the text color */
            padding: 2px 6px;
            border-radius: 50%;
            font-size: 10px;
        }

        .center {
            margin: auto;
            width: 80%; /* Increase the width to make the table wider */
            padding: 10px;
            text-align: center;
        }

        table, th, td {
            border: 1px solid green;
        }

        .th_deg {
            padding: 10px;
            background-color: skyblue;
            font-size: 20px;
            font-weight: bold;
        }

        .product-image-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .product-image {
            max-width: 120px; /* Change the value to the desired maximum width */
            max-height: 120px; /* Change the value to the desired maximum height */
        }
    </style>
    </head>
    <body>
        <!-- header section starts -->
        @include('home.header')

        <div class="center">
            <table style="width: 100%; max-width: 1600px;">
                <tr>
                    <th class="th_deg">Product Title</th>
                    <th class="th_deg">Quantity</th>
                    <th class="th_deg">Price</th>
                    <th class="th_deg">Payment Status</th>
                    <th class="th_deg">Delivery Status</th>
                    <th class="th_deg">Image</th>

                    <th class="th_deg">Cancel Order</th>
                </tr>

                @foreach ($orders->sortByDesc('created_at') as $orderItem)
                <tr>

                    <td><a href="{{ route('product_details', $orderItem->product_id) }}" style="color: blue; text-decoration: underline;">{{ $orderItem->product_title }}</a>
                    </td>


                    <td>{{$orderItem->quantity}}</td>
                    <td>{{$orderItem->price}} THB</td>
                    <td>{{$orderItem->payment_status}}</td>
                    <td>{{$orderItem->delivery_status}}</td>
                    <td class="product-image-container">
                        <img src="product/{{$orderItem->image}}" class="product-image">
                    </td>

                    <td>
                        @if($orderItem->delivery_status == 'processing')



                        @if($orderItem->created_at->diffInMinutes() <= 1)
                                <a onclick="return confirm('Are you sure you want to cancel this order?')" class="btn btn-danger" href="{{ route('cancel.order', $orderItem->id) }}">Cancel Order</a>
                            @else
                                <button class="btn btn-secondary" disabled>Not Allowed to Cancel Yet</button>
                            @endif



                        @else
                        <p style="color: blue">Not Allowed</p>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </body>

      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   </body>
</html>

<!DOCTYPE html>
<html>
<head>
    <!-- this line code is for show css function connection '<base href="/public">' -->
    {{-- <base href="/public"> --}}

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="images/favicon.png" type="">
    <title>Online Cake App</title>
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/bootstrap.css')}}" />
    <!-- font awesome style -->
    <link href="{{asset('home/css/font-awesome.min.css')}}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{asset('home/css/style.css')}}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{asset('home/css/responsive.css')}}" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 10px; /* Reduced margin top */
            margin-bottom: 10px; /* Reduced margin bottom */
        }
        .product-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Center content horizontally */
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 10px; /* Reduced margin top */
            margin-bottom: 10px; /* Reduced margin bottom */
        }
        .product-img {
            text-align: center;
        }
        .product-img img {
            max-width: 300px; /* Adjust this value as needed */
            max-height: 200px; /* Adjust this value as needed */
            width: auto;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .product-details {
            margin-top: 20px;
        }
        .product-details h5 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }
        .product-price {
            margin-top: 10px;
        }
        .product-price h6 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
            margin-top: 20px;
        }
        .product-table th,
        .product-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .product-table th {
            background-color: #f2f2f2;
        }
        .add-to-cart {
            margin-top: 20px;
        }
        .add-to-cart input[type="number"] {
            width: 100px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }
        .add-to-cart input[type="submit"] {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        .add-to-cart input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-to-products {
            margin-top: 20px;
            text-align: center;
        }
        .back-to-products a {
            color: #007bff;
            text-decoration: none;
            font-size: 1rem;
        }
        .back-to-products a:hover {
            text-decoration: underline;
        }
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


    </style>


</head>
<body>
<div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="product-container">
                <div class="product-img">
                    <img src="/product/{{$product->image}}" alt="{{$product->title}}">
                </div>
                <div class="product-details">
                    <h5>{{$product->title}}</h5>
                    <div class="product-price">
                        @if ($product->discount_price)
                            <h6 style="color: red;">Discount price: {{$product->discount_price}} THB</h6>
                            <h6 style="text-decoration: line-through; color: #888;">Price: {{$product->price}} THB</h6>
                        @else
                            <h6>Price: {{$product->price}} BTH</h6>
                        @endif
                    </div>
                    <table class="product-table">
                        <tr>
                            <th>Product Category</th>
                            <td>{{$product->category}}</td>
                        </tr>
                        <tr>
                            <th>Product Details</th>
                            <td>{{$product->description}}</td>
                        </tr>
                        <tr>
                            <th>Available Quantity</th>
                            <td>{{$product->quantity}}</td>
                        </tr>
                    </table>
                    <div class="add-to-cart">
                        <form action="{{url('add_cart', $product->id)}}" method="POST">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1">
                            <input type="submit" value="Add to Cart">
                        </form>
                    </div>
                </div>
            </div>
            <div class="back-to-products">
                <a href="{{ route('products') }}">Back to Products</a>
            </div>
        </div>
    </div>
</div>

<!-- footer start -->
@include('home.footer')
<!-- footer end -->

</body>
</html>

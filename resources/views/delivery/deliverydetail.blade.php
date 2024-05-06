<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Delivery Details</title>
    <link rel="stylesheet" href="Delivery_Interface.css">
    <link rel="stylesheet" href="Delivery.css">
    <style>
        /* Your CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2; /* Light background color */
        }

        .container {
            max-width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff; /* White background for content */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
            border-radius: 8px; /* Rounded corners */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px 0;
            border-bottom: 1px solid #ddd; /* Bottom border */
        }

        .header img {
            width: 70px;
            height: auto;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info a {
            text-decoration: none;
            color: #333;
            margin-left: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd; /* Border color */
        }

        th {
            background-color: #f2f2f2; /* Light background for table headers */
        }

        #ButtonContainer {
            text-align: right;
            margin-top: 20px;
        }

        #Button1 {
            background-color: #f44336; /* Red button */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        #Button1:hover {
            background-color: #d32f2f; /* Darker red on hover */
        }

        @media only screen and (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            .header img {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <a href="./index.html">
            <img src="{{ asset('delivery/images/Birthday-Cake-PNG-File.png')}}" alt="Logo">
        </a>
        @auth
        <x-app-layout class="user-info">
            <a href="./index.html" class="mr-4 flex items-center"></a>
            <div>
                <!-- Your user name display code -->
            </div>
        </x-app-layout>
        @endif
    </div>
    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Order ID</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Price</th>
                <th>Phone</th>
                <th>Payment Type</th>
                <th>Date</th>
                <th>Address</th>
                <th>Delivery Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through delivery data -->
            @foreach($deliveries as $delivery)
            <tr>
                <td>{{ $delivery->recipient_name }}</td>
                <td>{{ $delivery->order_id }}</td>
                <td>{{ $delivery->quantity }}</td>
                <td><img src="/product/{{ $delivery->image }}" alt="Product Image" width="45"></td>
                <td>{{ $delivery->price }}</td>
                <td>{{ $delivery->phone_number }}</td>
                <td>{{ $delivery->payment_status }}</td>
                <td>{{ $delivery->delivery_date }}</td>
                <td>{{ $delivery->address }}</td>
                <td>{{ $delivery->delivery_status }}</td>
                <td>
                    <a href="{{ route('edit.signature', ['order_id' => $delivery->order_id]) }}" style="color: blue;">Edit</a>
                    {{-- <a href="{{ route('edit.signature', ['username' => $delivery->recipient_name]) }}" style="color: blue;">Edit</a> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div id="ButtonContainer">
        <a id="Button1" href="{{ route('redirect') }}">Close</a>
    </div>
</div>
</body>
</html>

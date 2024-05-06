<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delivery Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('delivery/css/Delivery_Interface.css') }}" rel="stylesheet">
    <link href="{{ asset('delivery/css/index.css') }}" rel="stylesheet">
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination li {
            list-style: none;
            margin: 0 5px;
        }

        .pagination a {
            display: block;
            padding: 8px 16px;
            background-color: #f2f2f2;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #71b640;
            color: white;
        }

        .pagination .active a {
            background-color: #71b640;
            color: white;
        }
        .user-info {
            margin-bottom: 20px;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
        }

        .header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-container {
            width: 80%;
            max-height: 400px; /* Set a max height for vertical scrolling */
            overflow-y: auto; /* Enable vertical scrolling */
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #71b640;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: #63b954;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .search-box {
            position: absolute;
            top: 44px;
            right: 155px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 6px 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-box input[type="text"] {
            width: 200px;
            padding: 4px;
            border: none;
            outline: none;
            font-size: 14px;
            color: #333;
        }

        .search-box input[type="text"]::placeholder {
            color: #999;
        }

        .search-box input[type="text"]:focus {
            border: 1px solid #71b640;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <a href="#" onclick="handleImageClick()">
            <img src="{{ asset('delivery/images/Birthday%2dCake%2dPNG%2dFile.png')}}" alt="" width="61" height="61">
        </a>
        <div class="auth-section">
            @auth
                <x-app-layout class="user-info">
                    <!-- Your user info display code here -->
                </x-app-layout>
            @endif
        </div>
    </div>
    <hr>
    <h1>Delivery Home page</h1>

    <!-- Search Box -->
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search...">
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Delivery Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->address }}</td>
                    <td>
                        @if(isset($statusMessages[$user->name]))
                            <p>{{ $statusMessages[$user->name]['status'] }}</p>
                        @else
                            <p>No data available for user: {{ $user->name }}</p>
                        @endif
                    </td>
                    <td>
                        @if ($delivery->isEmpty() || $delivery->where('recipient_name', $user->name)->isEmpty())
                            No records
                        @else
                            @php
                                $user_delivery = $delivery->where('recipient_name', $user->name)->first();
                            @endphp
                            @if ($user_delivery->recipient_name == $user->name)
                                <a href="{{ route('view.deliverydetail', ['username' => $user_delivery->recipient_name]) }}" style="color: blue;">View</a>
                            @else
                                Recipient name does not match
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="container">
        <!-- Your existing content here -->

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

</div>

<script>
    // Filter table rows based on input text
    document.getElementById("searchInput").addEventListener("keyup", function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("tableBody");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            let found = false;
            for (var j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }
            if (found) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    });
</script>

</body>
</html>

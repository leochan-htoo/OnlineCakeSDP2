<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>signature_submit</title>
    <meta name="generator" content="WYSIWYG Web Builder 19 Trial Version - https://www.wysiwygwebbuilder.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Delivery_Interface.css" rel="stylesheet">
    <link href="Signature_submit.css" rel="stylesheet">
    <style>
        /* Responsive styles */
        #Layer1_Container {
            max-width: 100%;
            width: auto;
            padding: 0 10px;
        }

        #wb_Text1, #wb_Text2 {
            font-size: 1em;
        }

        #Button3, #Button4 {
            width: 25%;
            /* Adjusted width */
            max-width: 200px;
            margin: 10px 0;
            display: block;
            text-align: center;
            line-height: 40px;
            padding: 0; /* Added to shorten the button shape */
        }

        #TextArea1 {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            height: 100px;
        }

        #HorizontalLine1 {
            width: 100%;
        }
    </style>
</head>
<body>


    <div id="Layer1" style="position:fixed;text-align:center;left:0;top:0;right:0;bottom:0;z-index:10;">
        <div id="Layer1_Container" style="width:100%;max-width:1514px;height:549px;position:relative;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto;text-align:left;">
            <div id="wb_Image1" style="position:absolute;left:0;top:0;width:61px;height:61px;z-index:0;">
                <a href="#">
                    <img src="{{ asset('delivery/images/Birthday-Cake-PNG-File.png')}}" id="Image1" alt="" width="61" height="61"></a>
            </div>
            <div id="wb_Image2" style="position:absolute;left:27px;top:93px;width:34px;height:32px;z-index:1;">
                <a href="{{ route('redirect') }}">
                    <img src="{{ asset('delivery/images/arrowback.png')}}" id="Image2" alt="" width="34" height="34">
                </a>
            </div>

            @foreach ($deliveries as $delivery)
            <div id="wb_Text2" style="position:absolute;left:80px;top:100px;width:100px;height:19px;z-index:2;">
                <span style="color:#000000;font-family:Arial;font-size:17px;">Order_ID: {{ $delivery->order_id }} </span>
            </div>
            @endforeach

            <form id="deliveryForm" method="POST">
                @csrf
                @foreach ($deliveries as $delivery)
                <div class="delivery">
                    <input type="hidden" name="order_id[]" value="{{ $delivery->order_id }}">
                    <textarea name="message[]" style="position:absolute;left:10%;top:229px;width:77%;height:150px;z-index:4;" rows="4" cols="41" spellcheck="false"></textarea>
                    <div id="wb_Text1" style="position:absolute;left:10%;top:199px;width:156px;height:19px;z-index:5;">
                        <span style="color:#000000;font-family:Arial;font-size:17px;">Capture Signature</span>
                    </div>
                    <button type="button" class="failButton" style="position:absolute;left:10%;top:410px;background-color:red;color:white;">Failed</button>
                    <button type="button" class="submitButton" style="position:absolute;right:13%;top:410px;background-color:green;color:white;">Submit</button>
                </div>
                @endforeach
            </form>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const form = document.getElementById('deliveryForm');
                    const failButtons = document.querySelectorAll('.failButton');
                    const submitButtons = document.querySelectorAll('.submitButton');

                    failButtons.forEach((button, index) => {
                        button.addEventListener('click', function () {
                            const message = form.querySelectorAll('textarea[name="message[]"]')[index].value;
                            const orderId = form.querySelectorAll('input[name="order_id[]"]')[index].value;

                            const formData = new FormData();
                            formData.append('order_id', orderId);
                            formData.append('message', message);

                            form.action = "{{ route('failed.page', ':order_id') }}".replace(':order_id', orderId);
                            form.method = "POST"; // Set method to POST
                            form.submit();
                        });
                    });

                    submitButtons.forEach((button, index) => {
                        button.addEventListener('click', function () {
                            const orderId = form.querySelectorAll('input[name="order_id[]"]')[index].value;

                            form.action = "{{ route('delivery.success', ':order_id') }}".replace(':order_id', orderId);
                            form.method = "POST"; // Set method to POST
                            form.submit();
                        });
                    });
                });
            </script>

            <div id="wb_CssMenu1" style="position:absolute;left:80%;top:13px;z-index:8;">
                @auth
                <x-app-layout class="flex items-center">
                    <a href="./index.html" class="mr-4 flex items-center">
                        <!-- You can add more styling to the img tag if necessary -->
                    </a>
                    <div class="user-info">
                        <!-- Your user name display code -->
                    </div>
                </x-app-layout>
                @endif
            </div>
        </div>
        <hr id="HorizontalLine1" style="position:absolute;left:2px;top:62px;width:100%;z-index:11;">
    </div>
</body>
</html>

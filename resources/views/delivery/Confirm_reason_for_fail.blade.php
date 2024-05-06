<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirm_reason_for_fail</title>
    <meta name="generator" content="WYSIWYG Web Builder 19 Trial Version - https://www.wysiwygwebbuilder.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Delivery_Interface.css" rel="stylesheet">
    <link href="Confirm_reason_for_fail.css" rel="stylesheet">
    <style>
        /* Make it responsive */
        @media (max-width: 768px) {
            #Layer1_Container {
                width: 100%;
                max-width: 100%;
                height: auto;
            }
            #wb_Image1, #wb_Image2, #wb_Text2, #TextArea1, #wb_Text1, #Button1, #Button4 {
                width: 100%;
                margin-left: auto;
                margin-right: auto;
            }
            #wb_CssMenu1 {
                display: none;
            }
            #TextArea1 {
                width: 90%;
            }
            #Button1, #Button4 {
                position: absolute;
                width: 90px;
                height: 15%;
                display: flex;
                justify-content: center;
                align-items: center;
                text-align: center;
            }
            #Button1 {
                left: 5%;
                top: 400px;
                background-color: red;
                color: white;
            }
            #Button4 {
                right: 5%;
                top: 400px;
                background-color: green;
                color: white;
            }
            #wb_Text1 span {
                color: red;
            }
        }
    </style>
</head>
<body>
<a href="https://www.wysiwygwebbuilder.com" target="_blank">
    <img src="images/builtwithwwb19.png" alt="WYSIWYG Web Builder" style="position:absolute;left:441px;top:967px;margin: 0;border-width:0;z-index:250" width="88" height="31">
</a>
<div id="Layer1" style="position:fixed;text-align:center;left:0;top:0;right:0;bottom:0;z-index:11;">
    <div id="Layer1_Container" style="width:100%;height:auto;position:relative;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto;text-align:left;">
        <div id="wb_Image1" style="position:absolute;left:0;top:0;width:61px;height:61px;z-index:0;">
            <a href="./index.html">
                <img src="images/Birthday%2dCake%2dPNG%2dFile.png" id="Image1" alt="" width="61" height="61">
            </a>
        </div>
        <div id="wb_CssMenu1" style="position:absolute;left:1241px;top:13px;width:139px;height:34px;z-index:1;">
            <ul id="CssMenu1" role="menubar" class="nav">
                <!-- Menu items go here -->
            </ul>
        </div>
        <div id="wb_Image2" style="position:absolute;left:13px;top:93px;width:34px;height:32px;z-index:2;">

            <a href="{{ route( 'back')}}">
                <img src="images/arrowback.png" id="Image2" alt="" width="34" height="34">
            </a>

        </div>
        <div id="wb_Text2" style="position:absolute;left:80px;top:100px;width:100px;height:19px;z-index:3;">
            <span style="color:#000000;font-family:Arial;font-size:17px;">#Order_ID:</span>
        </div>

        @foreach ($deliveries as $delivery)
            <form action="{{ route('/failed', ['order_id' => $delivery->order_id]) }}" method="POST">


                @csrf

                <div id="wb_Text1" style="position:absolute;left:5%;top:190px;width:246px;height:19px;z-index:5;">
                    <span style="color:#FF0000;font-family:Arial;font-size:17px;">Reason for failed delivery</span>
                </div>

                <textarea name="TextArea1" id="TextArea1" style="position:absolute;left:5%;top:215px;width:90%;height:157px;z-index:4;" rows="8" cols="41" spellcheck="false"></textarea>

                <a id="Button1" href="{{ route('signature_submit') }}" style="position:absolute;left:5%;top:400px;width:90px;height:30px;z-index:6;background-color:red;color:white;display:flex;justify-content:center;align-items:center;">Cancel</a>

                <button type="submit" id="Button4" style="position:absolute;right:5%;top:400px;width:90px;height:30px;z-index:7;background-color:green;color:white;display:flex;justify-content:center;align-items:center;">Submit</button>
            </form>
        @endforeach

        <div id="wb_Image3" style="position:absolute;left:90%;top:10px;width:34px;height:34px;z-index:8;">
            <!-- Auth section -->
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
        <hr id="HorizontalLine1" style="position:absolute;left:0px;top:60px;width:100%;z-index:9;">
    </div>
</div>
</body>
</html>

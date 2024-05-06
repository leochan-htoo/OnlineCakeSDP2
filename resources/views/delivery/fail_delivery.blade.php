<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Fail Delivery</title>
<meta name="generator" content="WYSIWYG Web Builder 19 Trial Version - https://www.wysiwygwebbuilder.com">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="Delivery_Interface.css" rel="stylesheet">
<link href="Fail_delivery.css" rel="stylesheet">
<style>
/* Add your custom CSS here for responsive adjustments */
#Layer1_Container {
    width: 90%; /* Adjusted container width for smaller screens */
    max-width: 970px; /* Added max-width to limit container size on larger screens */
    margin: auto; /* Center the container horizontally */
    position: relative; /* Removed margin auto and relative positioning from inline style */
}

/* Adjustments for smaller screens */
@media only screen and (max-width: 768px) {
  #Layer1_Container {
    width: 80%; /* Adjusted container width for mobile devices */
  }

  #wb_CssMenu1 {
    display: none; /* Hide the menu on smaller screens */
  }

  #wb_Image3 {
    display: none; /* Hide the user info image on smaller screens */
  }
}
</style>
</head>
<body>

<div id="Layer1" style="position:fixed;text-align:center;left:0;top:0;right:0;bottom:0;z-index:8;">
<div id="Layer1_Container">
<div id="wb_Image1" style="position:absolute;left:0px;top:0px;width:61px;height:61px;z-index:0;">
<img src="{{ asset('delivery/images/Birthday%2dCake%2dPNG%2dFile.png')}}" id="Image1" alt="" width="61" height="61"></div>
<div id="wb_CssMenu1" style="position:absolute;left:1241px;top:13px;width:139px;height:34px;z-index:1;">
<ul id="CssMenu1" role="menubar" class="nav">

</ul>
</div>
<div id="wb_Image2" style="position:absolute;left:13px;top:93px;width:34px;height:32px;z-index:2;">
</div>
<div id="wb_Image3" style="position: absolute; top: 10px; z-index: 3; right: 10px;">
    @auth
      <x-app-layout class="flex items-center" style="display: flex; flex-direction: row; align-items: center;">
        <a href="./index.html" class="mr-2">
          <!-- Your user image here -->
        </a>
        <div class="user-info" style="font-size: 14px;">
          <!-- Your user name display code here -->
        </div>
      </x-app-layout>
    @endif
  </div>

<hr id="HorizontalLine1" style="position:absolute;left:0px;top:60px;width:1529px;z-index:4;">
<div id="wb_Image4" style="position:absolute;left:50%;transform: translateX(-50%);top:200px;width:130px;height:130px;z-index:5;">
<img src="{{ asset ('delivery/images/icons8%2ddelivery%2dfailed%2d64.png')}} " id="Image4" alt="" width="130" height="130"></div>
<div id="wb_Text1" style="position:absolute;left:50%;transform: translateX(-50%);top:360px;width:120px;height:18px;z-index:6;">
<span style="color:#000000;font-family:Arial;font-size:16px;">Delivery Failed</span></div>
</div>
</div>
</body>
</html>

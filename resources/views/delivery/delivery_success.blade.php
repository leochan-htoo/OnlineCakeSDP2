<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Delivery Successful</title>
<meta name="generator" content="WYSIWYG Web Builder 19 Trial Version - https://www.wysiwygwebbuilder.com">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="Delivery_Interface.css" rel="stylesheet">
<link href="Delivery_Success1.css" rel="stylesheet">
<style>
/* CSS for responsive design */
@media screen and (max-width: 1200px) {
    #wb_Image3 { left: 90%; }
    #wb_Image4 { left: 60%; }
}

@media screen and (max-width: 768px) {
    #wb_Image3 { left: 80%; }
    #wb_Image4 { left: 50%; }
}

@media screen and (max-width: 480px) {
    #wb_Image3 { left: 70%; }
    #wb_Image4 { left: 40%; }
}
</style>
</head>
<body>

<div id="Layer1" style="position:fixed;text-align:center;left:0;top:0;right:0;bottom:0;z-index:8;">
<div id="Layer1_Container" style="width:100%;height:100%;position:relative;text-align:left;">
<div id="wb_Image1" style="position:absolute;left:20px;top:10px;width:61px;height:61px;z-index:0;">
<a href=""><img src="{{ asset ('delivery/images/Birthday%2dCake%2dPNG%2dFile.png')}}" id="Image1" alt="" width="61" height="61"></a></div>
<div id="wb_CssMenu1" style="position:absolute;left:90%;top:30px;width:139px;height:34px;z-index:1;">
<ul id="CssMenu1" role="menubar" class="nav">

</ul>
</div>
<div id="wb_Image2" style="position:absolute;left:5%;top:90px;width:34px;height:32px;z-index:2;">
</div>
<div id="wb_Image3" style="position:absolute;left:78%;top:23px;width:34px;height:34px;z-index:3;">
    @auth
    <x-app-layout class="flex items-center">
        <a href="./index.html" class="mr-4 flex items-center">
            <!-- Your user image here -->
        </a>
        <div class="user-info">
            <!-- Your user name display code here -->
        </div>
    </x-app-layout>
@endif
</div>
<hr id="HorizontalLine1" style="position:absolute;left:0;top:71px;width:100%;z-index:4;">
<div id="wb_Image4" style="position:absolute;left:42%;top:180px;width:80px;height:80px;z-index:5;">
    <img src="{{ asset('delivery/images/success%2dtransparent%2d3.png')}}" id="Image4" alt="" width="80" height="80"></div>
<div id="wb_Text1" style="position:absolute;left:37%;top:280px;width:318px;height:19px;z-index:6;">
    <span style="color:#000000;font-family:Arial;font-size:17px;">Delivery Successful Completed </span></div>
</div>
</div>
</body>
</html>

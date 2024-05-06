<section class="slider_section">
    <div class="slider_bg_box">
        <img src="{{ asset("images/11slider-bg.png") }}" alt="" id="sliderImage" width="1842" height="600" style="width: 1842px; height: 600px; horizontal-resolution: 80dpi; vertical-resolution: 80dpi; bit-depth: 24;">
    </div>
</section>

<script>
    let images = [
        "{{ asset("images/11slider-bg.png") }}",
        // "{{ asset("images/1slider-bg.jpg") }}",

        // Add more image paths here
    ];

    let currentImageIndex = 0;
    let sliderImage = document.getElementById("sliderImage");

    function changeImage() {
        if (currentImageIndex < images.length - 1) {
            currentImageIndex++;
        } else {
            currentImageIndex = 0;
        }

        sliderImage.src = images[currentImageIndex];
    }

    // Change image every 3 seconds (3000 milliseconds)
    setInterval(changeImage, 3000);
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Store</title>
    <style>
        /* General hero section styles */
        .hero {
            background-color: #77efb5; /* เปลี่ยนพื้นหลังเป็นสีเทาเข้ม */
            color: #fff; /* เปลี่ยนสีตัวอักษรในส่วนนี้ให้เป็นสีขาว */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border-radius: 10px;
        }

        .title {
            font-size: 3em;
            text-align: center;
            margin: 0;
            color: #fff; /* ตั้งค่าตัวอักษรสีขาว */
            font-weight: bold;
        }

        .subtitle {
            font-size: 1.5em;
            text-align: center;
            margin: 10px 0 20px;
            color: white; /* ปรับสี subtitle ให้เป็นสีขาวหม่น */
            font-weight: 500;
        }

        /* Slider styles */
        .slider {
            position: relative;
            width: 100%;
            max-width: 100%;
            height: 500px; /* สามารถปรับเปลี่ยนตามความต้องการ */
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .slide {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            object-fit: cover; /* ให้ภาพครอบคลุมพื้นที่สไลเดอร์ */
        }

        .slide.active {
            opacity: 1;
        }

    </style>
</head>
<body>
<header>
<section class="hero">
  <div class="hero-body">
    <div class="text-content">
      <p class="title">CHICFOOT</p>
      <p class="subtitle">Best Shoes shop website in the world</p>
    </div>
    <div class="slider">
      <img src="./sphoto/shoe1.jpg" class="slide" alt="Shoe 1">
      <img src="./sphoto/shoe2.jpg" class="slide" alt="Shoe 2">
      <img src="./sphoto/shoe3.jpg" class="slide" alt="Shoe 3">
    </div>
  </div>
</section>
</header>

<script>
    // Internal JavaScript
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    // Start the slider when the content is fully loaded
    document.addEventListener('DOMContentLoaded', () => {
        showSlide(currentSlide); // Show the first slide
        setInterval(nextSlide, 5000); // Change slide every 5 seconds
    });
</script>
</body>
</html>

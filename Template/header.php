<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Store</title>
    <style>
        
        .hero {
            
            color: #fff; 
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border-radius: 10px;
        }

        

        /* Slider styles */
        .slider {
            position: relative;
            width: 600px;
            height: 200px;
             
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        /* Tablets */
        @media (min-width: 768px) {
            .slider {
                width: 1000px;
                height: 500px; 
            }
        }

        /* desktop */
        @media (min-width: 1024px) {
            .slider {
                width: 1900px; 
                height: 900px; 
            }
        }

        .slide {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            object-fit: cover; 
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
    
    <div class="slider">
      <img src="https://cdn.discordapp.com/attachments/1138506358900138004/1302966912820449310/Design_a_promotional_banner_for_ChicFoot_featuring.jpg?ex=672a09ff&is=6728b87f&hm=c4c0c480fc86eba5beed05be1751b577f7988694ee41bf90fe5347cd4582611b&" class="slide" alt="Placeholder Image 1">
      <img src="https://cdn.discordapp.com/attachments/1138506358900138004/1302966913240010813/Create_a_promotional_banner_for_ChicFoot_featuring.jpg?ex=672a0a00&is=6728b880&hm=389dfd05d24270479d4e2521799d20ea6a061f3468a0d5ed3f5ee53aa8fcb8c2&" class="slide" alt="Placeholder Image 2">
      <img src="https://cdn.discordapp.com/attachments/1138506358900138004/1302966913688670218/Create_a_promotional_banner_for_the_brand_ChicFoo.jpg?ex=672a0a00&is=6728b880&hm=e08e46880555f53fb2bafa000148361bfcf91723a3c2e64abb5f4240b6e2f8dc&" class="slide" alt="Placeholder Image 3">
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

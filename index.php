<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/index.css">
    <title>Bem-vindo ao Sistema de Compras</title>
    <link rel="shortcut icon" href="./img/Logo2.png" type="image/Logo2.png">
</head>

<body>
    <div class="slideshow-container">
        <!-- Imagens do slide -->
        <div class="slide" style="background-image: url('img/slide1.jpg');"></div>
        <div class="slide" style="background-image: url('img/slide2.jpg');"></div>
        <div class="slide" style="background-image: url('img/slide3.jpg');"></div>
        <div class="slide" style="background-image: url('img/slide4.heic');"></div>
        <div class="slide" style="background-image: url('img/slide5.jpg');"></div>
        <div class="slide" style="background-image: url('img/slide6.jpg');"></div>
        <div class="slide" style="background-image: url('img/slide7.jpg');"></div>


        <!-- Sobreposição com texto e botão -->
        <div class="overlay">
            <h1>Bem-vindo ao Sistema de Compras Roma</h1>
            <p>Gerencie suas compras de forma prática e eficiente.</p>
            <button onclick="window.location.href='login.php'">Entrar</button>
        </div>
    </div>

    <script>
        // Script para alternar slides
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove('active');
                if (i === index) slide.classList.add('active');
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        // Iniciar slides
        showSlide(currentSlide);
        setInterval(nextSlide, 5000); // Troca a cada 5 segundos
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/65427daacc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styl.css">
    <link rel="stylesheet" href="media-1024.css">
    <link rel="stylesheet" href="media-768.css">
    <link rel="shortcut icon" href="img/icons/favicon.jpg" type="image/x-icon">
    <title>Podmiejski Styl</title>
</head>

<body>
    <nav>
    <div class="logo">
            <a href="index.php">Podmiejski <br> Styl</a>
        </div>
        <div class="main_nav">
            <div class="main_nav_content">
                <a href="aktualnosci.php"> Aktualności</a>
                <a href="projekty_domow.html"> Projekty domów</a>
                <a href="lokalizacje.html"> Lokalizacje</a>
                <a href="o_nas.html"> O nas</a>
                <a href="kontakt.html"> Kontakt</a>
            </div>
            <div class="main-mobile-nav-toggle">
                
                <a class="mobile-nav-toggle">&#9776;</a>
            </div>
        </div>
    </nav>
    <div class="mobile-nav ">
        <!-- Przycisk otwierający menu -->
        <div class="mobile-nav-content ">
            <!-- Zawartość menu -->
            <a href="index.php">Podmiejski Styl</a>
            <a href="aktualnosci.php">Aktualności</a>
            <a href="projekty_domow.html">Projekty domów</a>
            <a href="lokalizacje.html">Lokalizacje</a>
            <a href="o_nas.html">O nas</a>
            <a href="kontakt.html">Kontakt</a>
        </div>
    </div>
    <main>
        <section class="slider_section">
            <div class="media media-text">
                <div class="stick stick-text"></div>
                <a target="_blank" href="https://www.facebook.com/podmiejskistyl/"><i
                        class="fa-brands fa-square-facebook"></i></a>
                <div class="stick stick-text"></div>
            </div>
            <div class="slider-box slider-box-text">
                <div class="slider">
                    <div class="slider2 text-slider">
                      <p>Aktualności</p>
                    </div>

                </div>

                
            </div>
        </section>
        <div class="aktualnosci-main-container">
          <?php
        require_once 'cms/db.php';

function formatPolishDate($date) {
    $months = array(
        'stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca',
        'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'
    );
    
    $parsedDate = date_parse($date);
    $formattedDate = $parsedDate['day'] . ' ' . $months[$parsedDate['month'] - 1] . ' ' . $parsedDate['year'];
    
    return $formattedDate;
}

$newsQuery = $db->query("SELECT id, date, title, description, images FROM news ORDER BY id DESC");

if ($newsQuery) {
  $newsArray = $newsQuery->fetchAll(PDO::FETCH_ASSOC);

    foreach ($newsArray as $news) {
        $imagePaths = json_decode($news['images'], true);

        // Zamieniamy \/ na /
        $fixedImagePaths = array_map(function ($path) {
            return str_replace('\/', '/', $path);
        }, $imagePaths);

        echo '<div class="aktualnosci-full-box">';
        echo '<div class="aktualnosci-full-box-text">';
        echo '<h6>' . formatPolishDate($news['date']) . '</h6>';
        echo '<h1>' . $news['title'] . '</h1>';
        echo '<p>' . nl2br($news['description']) . '</p>';
        echo '</div>';
        echo '<div class="aktualnosci-full-box-img-slider">';
        foreach ($fixedImagePaths as $imagePath) {
            echo '<img src="' . $imagePath . '" alt="Zdjęcie">';
        }
        echo '</div>';
        echo '</div>';
    }
}
?>
         
            

        </div>
        </div>
        
        <footer>
            <div class="kontakt-dane">
                <h2>Kontakt</h2>
                <a href="tel:+48798907888">tel. 798-907-888</a>
                <a href="mailto:biuro@tawoinv.pl">gmail: biuro@tawoinv.pl</a>
                <a target="_blank" href="https://www.facebook.com/podmiejskistyl/"><i
                        class="fa-brands fa-square-facebook"></i></a>
            </div>
            <div class="kontakt-logo">
                <img src="img/TAWO-logo 1.png" alt="">
            </div>
        </footer>



    </main>
    <script>





        // //////////////////////////////////////////////
        var mobileNav = document.querySelector('.mobile-nav');
        var mobileNavToggle = document.querySelector('.mobile-nav-toggle');

        // Obsługa kliknięcia przycisku otwierającego menu
        mobileNavToggle.addEventListener('click', function () {
            mobileNav.classList.toggle('open'); // Dodanie lub usunięcie klasy 'open' dla wysuwanego menu
        });


// Skrypt obsługujący slider

var sliders = document.querySelectorAll('.aktualnosci-full-box-img-slider');
var touchStartX = 0;
var touchEndX = 0;

function showSlide(slider, index) {
  var slides = slider.querySelectorAll('img');

  if (index >= slides.length) {
    index = 0;
  } else if (index < 0) {
    index = slides.length - 1;
  }

  for (var i = 0; i < slides.length; i++) {
    slides[i].style.display = 'none';
  }

  slides[index].style.display = 'block';
}

function nextSlide(slider) {
  var slides = slider.querySelectorAll('img');
  var currentIndex = Array.from(slides).findIndex((slide) => slide.style.display === 'block');
  var nextIndex = currentIndex + 1;

  showSlide(slider, nextIndex);
}

function prevSlide(slider) {
  var slides = slider.querySelectorAll('img');
  var currentIndex = Array.from(slides).findIndex((slide) => slide.style.display === 'block');
  var prevIndex = currentIndex - 1;

  showSlide(slider, prevIndex);
}

function handleTouchStart(event) {
  touchStartX = event.touches[0].clientX;
}

function handleTouchEnd(event, slider) {
  touchEndX = event.changedTouches[0].clientX;
  var swipeThreshold = 50; // Minimalny przeskok w pikselach, aby uznano to za przewinięcie

  if (touchStartX - touchEndX > swipeThreshold) {
    nextSlide(slider);
  } else if (touchEndX - touchStartX > swipeThreshold) {
    prevSlide(slider);
  }
}

sliders.forEach(function (slider) {
  var slides = slider.querySelectorAll('img');
  var slideIndex = 0;

  // Dodanie przycisków nawigacji
  var nav = document.createElement('div');
  nav.classList.add('slider-nav');
  nav.innerHTML = '<span class="prev">&#8249;</span><span class="next">&#8250;</span>';
  slider.appendChild(nav);

  var prevButton = slider.querySelector('.prev');
  var nextButton = slider.querySelector('.next');

  prevButton.addEventListener('click', function () {
    prevSlide(slider);
  });

  nextButton.addEventListener('click', function () {
    nextSlide(slider);
  });

  slider.addEventListener('touchstart', handleTouchStart);
  slider.addEventListener('touchend', function (event) {
    handleTouchEnd(event, slider);
  });

  // Automatyczna zmiana slajdów co 3 sekundy
  setInterval(function () {
    nextSlide(slider);
  }, 7000);

  // Wyświetlenie pierwszego slajdu
  showSlide(slider, slideIndex);
});




    </script>
</body>

</html>
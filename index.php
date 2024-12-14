<?php include 'header.php'; ?>

$menu_items = [
    ['url' => 'index.php', 'name' => 'Kezdőlap'],
    ['url' => 'about.php', 'name' => 'Rólunk'],
    ['url' => 'services.php', 'name' => 'Szolgáltatások'],
    ['url' => 'faq.php', 'name' => 'GYIK'], // Új menüpont
    ['url' => 'contact.php', 'name' => 'Kapcsolat']
];

foreach ($menu_items as $item) {
    echo '<li><a href="' . $item['url'] . '">' . $item['name'] . '</a></li>';
}



<body class="index-page">

  <header id="header" class="header fixed-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-cente">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.png" alt=""> -->
          <h1 class="sitename">Tankönyrendelés</h1>
          <span>.</span>
        </a>

        <?php include 'menubar.php'; ?>

      </div>

    </div>

  </header>

  <main class="main">

    
    <!-- Clients Section -->
    <section id="clients" class="clients section">

      <div class="container">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 40
                },
                "480": {
                  "slidesPerView": 3,
                  "spaceBetween": 60
                },
                "640": {
                  "slidesPerView": 4,
                  "spaceBetween": 80
                },
                "992": {
                  "slidesPerView": 6,
                  "spaceBetween": 120
                }
              }
            }
          </script>
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><img src="assets/img/clients/client-1.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-2.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-3.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-4.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-5.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-6.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-7.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid" alt=""></div>
          </div>
        </div>

      </div>

    </section><!-- /Clients Section -->

    <!-- Stats Section -->
<section id="stats" class="stats section">

<div class="container" data-aos="fade-up" data-aos-delay="100">

  <div class="row gy-4 align-items-center">

    <div class="col-lg-5">
      <img src="assets/img/tankonyv-stats.svg" alt="Tankönyv statisztikák" class="img-fluid">
    </div>

    <div class="col-lg-7">

      <div class="row gy-4">

        <div class="col-lg-6">
          <div class="stats-item d-flex">
            <i class="bi bi-book flex-shrink-0"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="500" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Elérhető tankönyvek</strong></p>
            </div>
          </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-6">
          <div class="stats-item d-flex">
            <i class="bi bi-cart flex-shrink-0"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="1200" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Leadott rendelések</strong></p>
            </div>
          </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-6">
          <div class="stats-item d-flex">
            <i class="bi bi-person-check flex-shrink-0"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="300" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Iskolák együttműködésben</strong></p>
            </div>
          </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-6">
          <div class="stats-item d-flex">
            <i class="bi bi-calendar-check flex-shrink-0"></i>
            <div>
              <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Év tapasztalat</strong></p>
            </div>
          </div>
        </div><!-- End Stats Item -->

      </div>

    </div>

  </div>

</div>

</section><!-- /Stats Section -->


    <!-- Call To Action Section -->
<section id="call-to-action" class="call-to-action section dark-background">

<div class="container">
  <img src="assets/img/tankonyv-cta-bg.jpg" alt="Tankönyvrendelés">
  <div class="content row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
    <div class="col-xl-10">
      <div class="text-center">
        <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox play-btn"></a>
        <h3>Rendeld meg tankönyveidet most!</h3>
        <p>Ne hagyd az utolsó pillanatra a rendelést! Válogass a legjobb tankönyvek közül, és biztosítsd helyed időben a jövő tanévre.</p>
        <a class="cta-btn" href="order.php">Tankönyvek rendelése</a>
      </div>
    </div>
  </div>
</div>

</section><!-- /Call To Action Section -->


    <!-- Testimonials Section -->
<section id="testimonials" class="testimonials section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>Vásárlói vélemények</h2>
  <p>Olvasd el, mit mondanak a vásárlók a tankönyvrendelési szolgáltatásunkról!</p>
</div><!-- End Section Title -->

<div class="container" data-aos="fade-up" data-aos-delay="100">

  <div class="swiper init-swiper">
    <script type="application/json" class="swiper-config">
      {
        "loop": true,
        "speed": 600,
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": "auto",
        "pagination": {
          "el": ".swiper-pagination",
          "type": "bullets",
          "clickable": true
        },
        "breakpoints": {
          "320": {
            "slidesPerView": 1,
            "spaceBetween": 40
          },
          "1200": {
            "slidesPerView": 3,
            "spaceBetween": 10
          }
        }
      }
    </script>
    <div class="swiper-wrapper">

      <div class="swiper-slide">
        <div class="testimonial-item">
          <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
          <h3>Saul Goodman</h3>
          <h4>Szülő</h4>
          <div class="stars">
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
          </div>
          <p>
            <i class="bi bi-quote quote-icon-left"></i>
            <span>Gyors és egyszerű rendelési folyamat! A tankönyvek időben megérkeztek, és az árak is kedvezőek voltak. Nagyon elégedett vagyok.</span>
            <i class="bi bi-quote quote-icon-right"></i>
          </p>
        </div>
      </div><!-- End testimonial item -->

      <div class="swiper-slide">
        <div class="testimonial-item">
          <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
          <h3>Sara Wilsson</h3>
          <h4>Tanár</h4>
          <div class="stars">
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
          </div>
          <p>
            <i class="bi bi-quote quote-icon-left"></i>
            <span>Egyszerűvé tette a rendelést az egész osztály számára. Az ügyfélszolgálat is rendkívül segítőkész volt.</span>
            <i class="bi bi-quote quote-icon-right"></i>
          </p>
        </div>
      </div><!-- End testimonial item -->

      <div class="swiper-slide">
        <div class="testimonial-item">
          <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
          <h3>Jena Karlis</h3>
          <h4>Diák</h4>
          <div class="stars">
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
          </div>
          <p>
            <i class="bi bi-quote quote-icon-left"></i>
            <span>Imádom, hogy minden tankönyv egy helyen elérhető. A rendelés gyors volt, és a könyvek tökéletes állapotban érkeztek meg.</span>
            <i class="bi bi-quote quote-icon-right"></i>
          </p>
        </div>
      </div><!-- End testimonial item -->

    </div>

  </div>

</div>

</section><!-- /Testimonials Section -->


          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->


        </div>

      </div>  

    <!-- Recent Posts Section -->
<section id="recent-posts" class="recent-posts section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>Legfrissebb hírek</h2>
  <p>Olvass a tankönyvrendelési folyamatokról, újdonságokról és tippekről!</p>
</div><!-- End Section Title -->

<div class="container">

  <div class="row gy-4">

    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
      <article>

        <div class="post-img">
          <img src="assets/img/blog/blog-1.jpg" alt="Újdonságok a rendelésben" class="img-fluid">
        </div>

        <p class="post-category">Újdonságok</p>

        <h2 class="title">
          <a href="blog-details.html">Hogyan rendeld meg egyszerűen a tankönyveidet?</a>
        </h2>

        <div class="d-flex align-items-center">
          <img src="assets/img/blog/blog-author.jpg" alt="" class="img-fluid post-author-img flex-shrink-0">
          <div class="post-meta">
            <p class="post-author">Maria Doe</p>
            <p class="post-date">
              <time datetime="2022-01-01">2024. december 1.</time>
            </p>
          </div>
        </div>

      </article>
    </div><!-- End post list item -->

    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
      <article>

        <div class="post-img">
          <img src="assets/img/blog/blog-2.jpg" alt="Tippek és trükkök" class="img-fluid">
        </div>

        <p class="post-category">Tippek</p>

        <h2 class="title">
          <a href="blog-details.html">5 tipp a tankönyvrendelés gyors lebonyolításához</a>
        </h2>

        <div class="d-flex align-items-center">
          <img src="assets/img/blog/blog-author-2.jpg" alt="" class="img-fluid post-author-img flex-shrink-0">
          <div class="post-meta">
            <p class="post-author">Allisa Mayer</p>
            <p class="post-date">
              <time datetime="2022-01-01">2024. december 5.</time>
            </p>
          </div>
        </div>

      </article>
    </div><!-- End post list item -->

    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
      <article>

        <div class="post-img">
          <img src="assets/img/blog/blog-3.jpg" alt="Iskolai együttműködések" class="img-fluid">
        </div>

        <p class="post-category">Együttműködések</p>

        <h2 class="title">
          <a href="blog-details.html">300 iskolával dolgozunk együtt a tankönyvek biztosításáért</a>
        </h2>

        <div class="d-flex align-items-center">
          <img src="assets/img/blog/blog-author-3.jpg" alt="" class="img-fluid post-author-img flex-shrink-0">
          <div class="post-meta">
            <p class="post-author">Mark Dower</p>
            <p class="post-date">
              <time datetime="2022-01-01">2024. december 10.</time>
            </p>
          </div>
        </div>

      </article>
    </div><!-- End post list item -->

  </div><!-- End recent posts list -->

</div>

</section><!-- /Recent Posts Section -->


            </div>

          </div>

          <div class="col-lg-8">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade" data-aos-delay="100">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="8" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>
<?php include 'footer.php'; ?>
<!-- <?php
session_start();

?> -->
<?php include 'header.php'; ?>


<body class="index-page">

  <header id="header" class="header fixed-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a
              href="mailto:contact@example.com">kapcsolat@tankonyvrendeles.hu</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+3612345678 </span></i>
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
    <!-- Miért válasszon minket szekció -->
    <section id="why-choose-us" class="why-choose-us section py-5 bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h2>Miért válasszon minket?</h2>
            <p>A tankönyvrendelési rendszerünk segít a középiskolás diákok számára, hogy a következő tanévre szükséges
              tankönyveket egyszerűen és gyorsan megkapják. A rendszerben rögzített adatok segítik a tanárokat abban,
              hogy minden diák számára a megfelelő könyveket rendeljék meg.</p>
            <ul>
              <li><i class="bi bi-check-circle"></i> Időben történő rendelés biztosítja a megfelelő könyvek
                megérkezését.</li>
              <li><i class="bi bi-check-circle"></i> Könnyen kezelhető rendszer minden iskolai típushoz.</li>
              <li><i class="bi bi-check-circle"></i> Rendszeres frissítések és gyors ügyfélszolgálat.</li>
            </ul>
          </div>
          <div class="col-lg-6">
            <img src="assets/img/why-choose-us.jpg" class="img-fluid" alt="Miért válassz minket">
          </div>
        </div>
      </div>
    </section>

    <!-- Hogyan működik a rendelés szekció -->
    <section id="how-it-works" class="how-it-works section py-5">
      <div class="container">
        <div class="text-center mb-5">
          <h2>Hogyan működik a rendelés?</h2>
          <p>A rendelési folyamat gyors és egyszerű. Nézd meg, hogyan tudsz könnyedén rendelni!</p>
        </div>
        <div class="row text-center">
          <div class="col-lg-4">
            <div class="step">
              <i class="bi bi-person-check-fill fs-1 mb-3"></i>
              <h4>1. Regisztráció</h4>
              <p>A tanárok regisztrálnak az oldalon, hogy elérjék a rendelési felületet.</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="step">
              <i class="bi bi-book-fill fs-1 mb-3"></i>
              <h4>2. Tankönyvek kiválasztása</h4>
              <p>A tanárok kiválasztják a diákoknak szükséges tankönyveket és feltöltik őket a rendszerbe.</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="step">
              <i class="bi bi-cart-fill fs-1 mb-3"></i>
              <h4>3. Rendelés leadása</h4>
              <p>A kiválasztott tankönyveket a rendszer automatikusan megrendeli és rögzíti.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Miért érdemes időben rendelni szekció -->
    <section id="why-order-on-time" class="why-order-on-time section py-5 bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h2>Miért érdemes időben rendelni?</h2>
            <p>Időben történő rendelés esetén biztosítani tudjuk, hogy minden diák megkapja a következő évhez szükséges
              tankönyveket. Az oldalon történő rendelés egy egyszerű és gyors folyamat, amely segít elkerülni a
              késlekedéseket.</p>
            <ul>
              <li><i class="bi bi-check-circle"></i> Az időben leadott rendelések prioritást élveznek.</li>
              <li><i class="bi bi-check-circle"></i> Rendelje meg a tankönyveket már most, hogy ne maradjon le semmiről!
              </li>
            </ul>
          </div>
          <div class="col-lg-6">
            <img src="assets/img/why-order-on-time.jpg" class="img-fluid" alt="Miért érdemes időben rendelni">
          </div>
        </div>
      </div>
    </section>

    <!-- Regisztráció előnyei szekció -->
    <section id="registration-benefits" class="registration-benefits section py-5">
      <div class="container">
        <div class="text-center mb-5">
          <h2>A regisztráció előnyei</h2>
          <p>Regisztrálj az oldalunkon és élvezd a következő előnyöket:</p>
        </div>
        <div class="row text-center">
          <div class="col-lg-4">
            <div class="benefit">
              <i class="bi bi-file-earmark-check fs-1 mb-3"></i>
              <h4>Nyomon követheted rendeléseidet</h4>
              <p>Rendszerünk segítségével könnyen követheted rendeléseid állapotát.</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="benefit">
              <i class="bi bi-people-fill fs-1 mb-3"></i>
              <h4>Csoportos rendelés</h4>
              <p>Rendeld meg egyszerre az egész osztály tankönyveit gyorsan és egyszerűen.</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="benefit">
              <i class="bi bi-cash fs-1 mb-3"></i>
              <h4>Kedvezményes árak</h4>
              <p>Regisztrált felhasználóink számára kedvezményeket biztosítunk a tankönyvek rendelésekor.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Call to Action szekció -->
    <section id="cta" class="cta section bg-primary text-white py-5">
      <div class="container text-center">
        <h3>Ne hagyd az utolsó pillanatra!</h3>
        <p>Rendeld meg a szükséges tankönyveket időben, és biztosítsd helyed a következő tanévre!</p>
        <a href="order.php" class="btn btn-light btn-lg">Rendeld meg most</a>
      </div>
    </section>


    <!-- Stats Section -->
    <section id="stats" class="stats section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 align-items-center">



          <div class="col-lg-12">

            <div class="row gy-4">

              <div class="col-lg-6">
                <div class="stats-item d-flex">
                  <i class="bi bi-book flex-shrink-0"></i>
                  <div>
                    <span data-purecounter-start="0" data-purecounter-end="500" data-purecounter-duration="1"
                      class="purecounter"></span>
                    <p><strong>Elérhető tankönyvek</strong></p>
                  </div>
                </div>
              </div><!-- End Stats Item -->

              <div class="col-lg-6">
                <div class="stats-item d-flex">
                  <i class="bi bi-cart flex-shrink-0"></i>
                  <div>
                    <span data-purecounter-start="0" data-purecounter-end="1200" data-purecounter-duration="1"
                      class="purecounter"></span>
                    <p><strong>Leadott rendelések</strong></p>
                  </div>
                </div>
              </div><!-- End Stats Item -->

              <div class="col-lg-6">
                <div class="stats-item d-flex">
                  <i class="bi bi-person-check flex-shrink-0"></i>
                  <div>
                    <span data-purecounter-start="0" data-purecounter-end="300" data-purecounter-duration="1"
                      class="purecounter"></span>
                    <p><strong>Iskolák együttműködésben</strong></p>
                  </div>
                </div>
              </div><!-- End Stats Item -->

              <div class="col-lg-6">
                <div class="stats-item d-flex">
                  <i class="bi bi-calendar-check flex-shrink-0"></i>
                  <div>
                    <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1"
                      class="purecounter"></span>
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
              <p>Ne hagyd az utolsó pillanatra a rendelést! Válogass a legjobb tankönyvek közül, és biztosítsd helyed
                időben a jövő tanévre.</p>
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
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Gyors és egyszerű rendelési folyamat! A tankönyvek időben megérkeztek, és az árak is kedvezőek
                    voltak. Nagyon elégedett vagyok.</span>
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
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Egyszerűvé tette a rendelést az egész osztály számára. Az ügyfélszolgálat is rendkívül
                    segítőkész volt.</span>
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
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Imádom, hogy minden tankönyv egy helyen elérhető. A rendelés gyors volt, és a könyvek tökéletes
                    állapotban érkeztek meg.</span>
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


    </div>

    </div>

    </section><!-- /Contact Section -->

  </main>
  <?php include 'footer.php'; ?>
@extends('layouts.app')
@section('welcome')
<body> 
  <section class="p-0 mt-0" id="carrusel">
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/trabajo.png') }}" class="d-block w-100" alt="">
                <div class="carousel-container position-absolute top-50 start-50 translate-middle text-center text-white">
                    
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/pozo.jpg') }}" class="d-block w-100" alt="">
                <div class="carousel-container position-absolute top-50 start-50 translate-middle text-center text-white">
                    {{-- <h2>40 Años de Excelencia</h2>
                    <p class="text-light bg-lime-900">Nos enorgullece ofrecer equipos de alta calidad y el mejor servicio al cliente desde hace cuatro décadas.</p> --}}
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/Imagen4.jpg') }}" class="d-block w-100" alt="">
                <div class="carousel-container position-absolute top-50 start-50 translate-middle text-center text-white">
                    {{-- <h2>Temporibus autem quibusdam</h2>
                    <p>Beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.</p> --}}
                </div>
            </div>
        </div>

        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        <!-- Indicadores del carrusel -->
        <ol class="carousel-indicators">
            <li data-bs-target="#carouselExampleFade" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#carouselExampleFade" data-bs-slide-to="1"></li>
            <li data-bs-target="#carouselExampleFade" data-bs-slide-to="2"></li>
        </ol>
    </div>
</section>
<br>

<section id="about" class="about section">

  <div class="container">

  <!-- Section Title -->
 <br>
 <div class="container section-title text-center reveal" data-aos="fade-up">
  <h2>Acerca de Nosotros</h2>
  {{-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> --}}
</div>

    <div class="row g-4 g-lg-5 reveal" data-aos="fade-up" data-aos-delay="200">

      <div class="col-lg-5">
        <div class="about-img">
          <img src="{{ asset('images/about.jpg') }}" class="img-fluid" alt="">
        </div>
      </div>

      <div class="col-lg-7">
        <h3 class="pt-0 pt-lg-5">Explora nuestra Misión y Visión</h3>

        <!-- Tabs -->
        <ul class="nav nav-pills mb-3">
          <li><a class="nav-link active" data-bs-toggle="pill" href="#mission-tab">Misión</a></li>
          <li><a class="nav-link" data-bs-toggle="pill" href="#vision-tab">Visión</a></li>
          <li><a class="nav-link" data-bs-toggle="pill" href="#about-tab3">Politica Integral</a></li>
        </ul><!-- End Tabs -->

        <!-- Tab Content -->
        <div class="tab-content">

          <div class="tab-pane fade show active" id="mission-tab">
            <p class="fst-italic">Brindar servicios de Arrendamiento de herramientas especiales para operaciones de Pesca, Molienda y Percusión. </p>
               
            <p>Con un enfoque en la mejora continua y la preservación del medio ambiente, nuestro personal especializado se asegura de que cada proyecto sea un éxito.</p>
          </div><!-- End Mission Tab Content -->

          <div class="tab-pane fade" id="vision-tab">
            <p class="fst-italic">Continuar siendo la primera opción para el cliente en la industria petrolera y geotérmica.</p>
            <p>Fortalecemos alianzas estratégicas para incrementar nuestro alcance en el mercado, siempre enfocados en un proceso de mejora continua.</p>
          </div><!-- End Vision Tab Content -->

          <div class="tab-pane fade" id="about-tab3">
            <p class="fst-italic">"Hot Hed México se cimpromete a lograr la conformidad en los servicios y la satisfacción de los requisitos de los clientes y demás partes interesadas"</p>
            <p>"Por lo que se ha establecido un sistema de gestión integral basado en las normas ISO 14001 e ISO 45001 enfocados en la mejora continua de todos sus procesos"</p>
          </div><!-- End About Tab 3 Content -->

        </div>

      </div>

    </div>

  </div>
</div>
</section><!-- /Misión y Visión Section -->



{{-- <br>
<!-- Services 2 Section -->
<section id="services-2" class="services-2 section dark-background">
  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
      <h2>Services</h2>
      <p>Necessitatibus eius consequatur</p>
  </div><!-- End Section Title -->

  <div class="services-carousel-wrap">
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
                      "navigation": {
                          "nextEl": ".js-custom-next",
                          "prevEl": ".js-custom-prev"
                      },
                      "breakpoints": {
                          "320": {
                              "slidesPerView": 1,
                              "spaceBetween": 40
                          },
                          "1200": {
                              "slidesPerView": 3,
                              "spaceBetween": 40
                          }
                      }
                  }
              </script>
              <button class="navigation-prev js-custom-prev">
                  <i class="bi bi-arrow-left-short"></i>
              </button>
              <button class="navigation-next js-custom-next">
                  <i class="bi bi-arrow-right-short"></i>
              </button>
              <div class="swiper-wrapper">
                  <div class="swiper-slide">
                      <div class="service-item">
                          <div class="service-item-contents">
                              <a href="#">
                                  <span class="service-item-category">We do</span>
                                  <h2 class="service-item-title">Planting</h2>
                              </a>
                          </div>
                          <img src="{{ asset('images/about.jpg') }}" alt="Image" class="img-fluid">
                      </div>
                  </div>
                  <div class="swiper-slide">
                      <div class="service-item">
                          <div class="service-item-contents">
                              <a href="#">
                                  <span class="service-item-category">We do</span>
                                  <h2 class="service-item-title">Mulching</h2>
                              </a>
                          </div>
                          <img src="{{ asset('images/about.jpg') }}" alt="Image" class="img-fluid">
                      </div>
                  </div>
                  <div class="swiper-slide">
                      <div class="service-item">
                          <div class="service-item-contents">
                              <a href="#">
                                  <span class="service-item-category">We do</span>
                                  <h2 class="service-item-title">Watering</h2>
                              </a>
                          </div>
                          <img src="{{ asset('images/about.jpg') }}" alt="Image" class="img-fluid">
                      </div>
                  </div>
                  <div class="swiper-slide">
                      <div class="service-item">
                          <div class="service-item-contents">
                              <a href="#">
                                  <span class="service-item-category">We do</span>
                                  <h2 class="service-item-title">Fertilizing</h2>
                              </a>
                          </div>
                          <img src="{{ asset('images/about.jpg') }}" alt="Image" class="img-fluid">
                      </div>
                  </div>
                  <div class="swiper-slide">
                      <div class="service-item">
                          <div class="service-item-contents">
                              <a href="#">
                                  <span class="service-item-category">We do</span>
                                  <h2 class="service-item-title">Harvesting</h2>
                              </a>
                          </div>
                          <img src="{{ asset('images/about.jpg') }}" alt="Image" class="img-fluid">
                      </div>
                  </div>
                  <div class="swiper-slide">
                      <div class="service-item">
                          <div class="service-item-contents">
                              <a href="#">
                                  <span class="service-item-category">We do</span>
                                  <h2 class="service-item-title">Mowing</h2>
                              </a>
                          </div>
                          <img src="{{ asset('images/about.jpg') }}" alt="Image" class="img-fluid">
                      </div>
                  </div>
                  <div class="swiper-slide">
                      <div class="service-item">
                          <div class="service-item-contents">
                              <a href="#">
                                  <span class="service-item-category">We do</span>
                                  <h2 class="service-item-title">Seeding Plants</h2>
                              </a>
                          </div>
                          <img src="{{ asset('images/about.jpg') }}" alt="Image" class="img-fluid">
                      </div>
                  </div>
              </div>
              <div class="swiper-pagination"></div>
          </div>
      </div>
  </div>
</section><!-- /Services 2 Section -->





<section id="clientes">
  
</section>  --}}

</body>
@endsection

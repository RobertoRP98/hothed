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
</section>


<!--CLIENTES -->
<!-- CARRUSEL CLIENTES -->
<section id="clients">
<div class="container">
<div class="container section-title text-center reveal" data-aos="fade-up">
  <h2>NUESTROS CLIENTES</h2>
  {{-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> --}}
</div>
<div class="logo-slider" data-v-4ef8651c="">
  <div class="logos-slide" data-v-4ef8651c="">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/SLB_Logo_2022.svg/1280px-SLB_Logo_2022.svg.png" data-v-4ef8651c="">
    <img src="https://1000marcas.net/wp-content/uploads/2021/06/Halliburton-Logo.png" data-v-4ef8651c="">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/99/Logo_Petr%C3%B3leos_Mexicanos.svg/1200px-Logo_Petr%C3%B3leos_Mexicanos.svg.png" data-v-4ef8651c="">
    <img src="https://www.wirelinemexico.com/img/gsm-logo.png" data-v-4ef8651c="">
    <img src="https://1000marcas.net/wp-content/uploads/2021/06/Weatherford-Logo-2.png" data-v-4ef8651c="">
    <img src="https://jaguar-ep.com/wp-content/uploads/2020/09/logo_jaguar.png" data-v-4ef8651c="">
    <img src="https://1000logos.net/wp-content/uploads/2020/06/Petrofac-Logo.png" data-v-4ef8651c="">
  </div>
</div>
</div>
</section>

<!--SERVICIOS -->
<!-- CARRUSEL SERVICIOS -->

<section id="services">
<div class="container">

  <div class="container section-title text-center reveal" data-aos="fade-up">
    <h2>NUESTROS SERVICIOS</h2>
    {{-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> --}}
  </div>

  <div id="carouselExampleControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
          
          
  <div class="row">
      
      <div class="col-lg-4">
          <div class="card" style="width: 18rem;">
    <img src="{{ asset('images/about.jpg') }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
  </div>
      </div>
      
      <div class="col-lg-4">
          <div class="card" style="width: 18rem;">
    <img src="{{ asset('images/about.jpg') }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
  </div>
      </div>
      
      
      <div class="col-lg-4">
          <div class="card" style="width: 18rem;">
    <img src="{{ asset('images/about.jpg') }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
  </div>
      </div>
      
  </div>
          
          
          
      </div>
      <div class="carousel-item">
          
          
          
  <div class="row">
      
      <div class="col-lg-4">
          <div class="card" style="width: 18rem;">
    <img src="{{ asset('images/about.jpg') }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
  </div>
      </div>
      
      <div class="col-lg-4">
          <div class="card" style="width: 18rem;">
    <img src="{{ asset('images/about.jpg') }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
  </div>
      </div>
      
      
      <div class="col-lg-4">
          <div class="card" style="width: 18rem;">
    <img src="{{ asset('images/about.jpg') }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
  </div>
      </div>
      
  </div>
      
          
      </div>
      
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  </div>
</section>

</body>
@endsection

@extends('layouts.app')
@section('welcome')
<body> 
<section class="p-0 mt-0"  id="carrusel">
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="{{ asset('images/trabajo.png') }}" class="d-block w-100" alt="">
          </div>
          <div class="carousel-item">
            <img src="{{asset ('images/pozo.jpg')}} " class="d-block w-100" alt="">
          </div>
          <div class="carousel-item">
            <img src="{{asset ('images/Imagen4.jpg') }}" class="d-block w-100" alt="">
          </div>
        </div>
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

{{-- <section class="mt-1" id="misionvision">
  <div id="cardmivi" class="container reveal">    
    <div class="row row-cols-1 row-cols-md-2 g-4">
      <div class="col">
        <div class="card border-white">
         <!-- <img src="" class="card-img-top" alt="..."> -->
          <div class="card-body">
            <h5 class="card-title">Misión</h5>
            <p class="card-text">Brindar servicios de Arrendamiento de herramientas especiales para
              operaciones de Pesca, Molienda y Percusión así como la instalación y
              soldadura de cabezales soldables, para las conexiones superficiales de
              control durante la perforación y reparación de Pozos, con personal
              especializado en la materia, enfocados en la mejora continua y
              promoviendo siempre la seguridad y la preservación del medio
              ambiente. </p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card border-white">
         <!-- <img src="" class="card-img-top" alt="..."> -->
          <div class="card-body">
            <h5 class="card-title">Visión</h5>
            <p class="card-text">Continuar siendo la primera opción para el cliente, generando
              soluciones para la industria petrolera y geotérmica, fortaleciendo
              alianzas estratégicas para incrementar nuestro alcance en el mercado,
              mediante un proceso de mejora continua.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<section id="servicios">
  <br>
  <div class="mt-1 container reveal">
    <h1>NUESTROS SERVICIOS</h1>
  <div id="carouselExampleCaptions" class="carousel carousel-dark slide" data-bs-ride="false">
   
    <div class="carousel-inner">
      <div class="carousel-item active">
       <div class="card-group">
        <div class="card">
         <img src="{{asset('images/luna.jpeg')}}" class="card-img-top img-fluid" alt="...">
         <div class="card-body">
         <h5 class="card-title">Instalación y Soldadura de Cabezales</h5>
      </div>
    </div>
    <div class="card">
      <img src="{{asset('images/luna.jpeg')}}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Renta de Hábitad modular</h5>
      </div>
    </div>
    <div class="card">
      <img src="{{asset('images/luna.jpeg')}}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Arrendamiento de Herammientas de Perforación</h5>
      </div>
    </div>
  </div>
  
      </div>
      <div class="carousel-item">
  <div class="card-group">
    <div class="card">
      <img src="{{asset('images/luna.jpeg')}}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Arrendamiento de Herramientas de Pesca y Molienda</h5>
      </div>
    </div>
    <div class="card">
      <img src="{{asset('images/luna.jpeg')}}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Servicios de Ingenieria para Reparación de Pozos</h5>
      </div>
    </div>
    <div class="card">
      <img src="{{asset('images/luna.jpeg')}}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Servicios de Ingenieria para Incremento de Producción</h5>
      </div>
    </div>
  </div>
      </div>
      <div class="carousel-item"> 
  <div class="card-group">
    <div class="card">
      <img src="{{asset('images/luna.jpeg')}}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Fabricación de Molinos y Zapatas</h5>
      </div>
    </div>
    <div class="card">
      <img src="{{asset('images/luna.jpeg')}}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Soladura para unir Tuberia de Revestimiento</h5>
      </div>
    </div>
    <div class="card">
      <img src="{{asset('images/luna.jpeg')}}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Corte en Frio</h5>
      
      </div>
    </div>
  </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>
</section>


<section id="clientes">
  <br>
  <div class="mt-1 container reveal">
    <h1>NUESTROS CLIENTES</h1>
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <div class="col">
      <div class="card">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        </div>
      </div>
    </div>
  </div>
</div>
</section> --}}

</body>
@endsection

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MiArpro') }}</title>
    <!-- Styles -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="shortcut icon" sizes="192x192" href="{{ asset('/img/favicon.jpg') }}">
  </head>
<body>
<header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-center">
      <img src="{{ asset('img/head2023.png') }}" alt="" style="width: auto; height: 1.5cm; ">
      </div>
    </div>
</header>
  <hr>
<div class="container" >
    <div class="row">
        <div class="col-md-6">
            <div class="bs-component">
                    <div class="card">
                        <h4 class="card-header">CODIGO ACTIVO FIJO: {{$actual->codigo}}</h4>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="card-title">Grupo Contable:</h5>
                                    <h6 class="card-subtitle text-muted">{{$actual->nombre}}</h6> 
                                </div>
                                <div class="col-md-6">
                                <h5 class="card-title">Auxiliar:</h5>
                                    <h6 class="card-subtitle text-muted">{{$actual->nomaux}}</h6> 
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="card-title">Oficina:</h5>
                                    <h6 class="card-subtitle text-muted">{{$actual->nomofic}}</h6> 
                                </div>
                                <div class="col-md-6">
                                <h5 class="card-title">Responsable:</h5>
                                    <h6 class="card-subtitle text-muted">{{$actual->nomresp}}</h6> 
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="card-title">Costo:</h5>
                                    <h6 class="card-subtitle text-muted"><b>Bs.- </b>{{$actual->costo}}</h6> 
                                </div>
                                <div class="col-md-6">
                                <h5 class="card-title">Fecha de incorporación:</h5>
                                    <h6 class="card-subtitle text-muted">{{$actual->incorporacion}}</h6> 
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="card-title">Vida Útil:</h5>
                                    <h6 class="card-subtitle text-muted">{{$actual->vidautil}} año(s)</h6> 
                                </div>
                                <div class="col-md-6">
                                <h5 class="card-title">Estado:</h5>
                                @if ($actual->estado == 1)
                                    <h6 class="card-subtitle text-muted">Bueno</h6> 
                                @elseif ($actual->estado == 2)
                                    <h6 class="card-subtitle text-muted">Regular</h6> 
                                @else
                                    <h6 class="card-subtitle text-muted">Malo</h6> 
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h5 class="card-title">Detalle:</h5>
                                <h6 class="card-subtitle text-muted">{{$actual->descripcion}}</h6>
                            </div>
                        </div>
                        <div class="card-footer text-muted">Ultima Actualización: {{$actual->updated_at}}</div>
                    </div>
            </div>
        </div>
        <div class="col-md-6">
            @if(isset($images))
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach($images as $image) 
                <div class="col">
                    <div class="card">
                    <img src="{{ asset('/images/'.$image->nombre) }}" class="card-img-top img-fluid" alt="{{$image->id}}" style="height: 400px">
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <img src="{{ asset('/assets/img/img.png') }}" class="card-img-bottom img-fluid" alt="imagen de producto">
            @endif

        </div>
    </div>
</div>
</body>
</html>
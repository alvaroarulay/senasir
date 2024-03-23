
@extends('layouts.app')

@section('content')

<section class="login-content">
    <div class="logo">
        <img src="/img/head2021.png" alt="" style="width: 500px; ">
    </div>
    <div class="card mx-6 login-box">
        <div class="card-body p-4">
            <form class="login-form" method="POST" action="{{ route('login.perform') }}">
                @csrf
                <h3 class="login-head"><i class="bi bi-person me-2"></i>Ingreso al Sistema</h3>
                <div class="mb-3 input-group" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="bi bi-person-square"></i></span>
                    </div>
                    <input id="name" 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            name="username" 
                            value="{{ old('name') }}" 
                            required 
                            autocomplete="name" 
                            autofocus 
                            placeholder="Nombre">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 input-group" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="bi bi-key-fill"></i>
                        </span>
                    </div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Contraseña">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 btn-container d-grid">
                    <button class="btn btn-primary btn-block" type="submit"><i class="bi bi-box-arrow-in-right me-2 fs-5"></i>Acceder</button>
                </div>
            </form>
            
       </div> 
    </div>
   
</section>
@endsection

@extends('layouts/public')

@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@if (config('adminlte.use_route_url', false))
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.password_reset_message'))

@section('content')

    <div class="row margin-top-60">
        <div class="col-lg-4 offset-lg-4">
            <div class="card elegant">
                <div class="card-header">
                    <div class="animatedParent animateOnce">
                        <h3 class="head-h3">NOVA</h3>
                        <p class="head-subtitle">senha</p>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ $password_reset_url }}" method="post">
                        {{ csrf_field() }}

                        {{-- Token field --}}
                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- Email field --}}
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                value="{{ $email  }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span style='height:30px;line-height:30px;' class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    <strong>Token inválido</strong>
                                </div>
                            @endif
                        </div>

                        {{-- Password field --}}
                        <div class="input-group mb-3">
                            <input type="password" name="password"
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="Senha">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span style='height:30px;line-height:30px;' class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    <strong>Senha obrigatória</strong>
                                </div>
                            @endif
                        </div>

                        {{-- Password confirmation field --}}
                        <div class="input-group mb-3">
                            <input type="password" name="password_confirmation"
                                class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                placeholder="Confirme a senha">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span style='height:30px;line-height:30px;' class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>
                            @if($errors->has('password_confirmation'))
                                <div class="invalid-feedback">
                                    <strong>Confirmação de senha obrigatória}</strong>
                                </div>
                            @endif
                        </div>

                        {{-- Confirm password reset button --}}
                        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                            <span class="fas fa-sync-alt"></span>
                            Alterar senha
                        </button>

                    </form>
                </div>
            </div>
            <br><br>
        </div>
    </div>

@stop

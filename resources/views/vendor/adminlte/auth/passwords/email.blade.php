@extends('layouts/public')


@php( $password_email_url = View::getSection('password_email_url') ?? config('adminlte.password_email_url', 'password/email') )

@if (config('adminlte.use_route_url', false))
    @php( $password_email_url = $password_email_url ? route($password_email_url) : '' )
@else
    @php( $password_email_url = $password_email_url ? url($password_email_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.password_reset_message'))

@section('content')

    <div class="row margin-top-60">
        <div class="col-lg-4 offset-lg-4">
            <div class="card elegant">
                <div class="card-header">
                    <div class="animatedParent animateOnce">
                        <h3 class="head-h3">{{ __('password.recover') }}</h3>
                        <p class="head-subtitle">{{ __('password.password') }}</p>
                    </div>
                </div>
                <div class="card-body">

                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ __('password.sentsuccess') }}
                        </div>
                    @endif
                
                    <form action="{{ $password_email_url }}" method="post">
                        {{ csrf_field() }}
                
                        {{-- Email field --}}
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span style='height:30px;line-height:30px;' class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    <strong>{{ __('password.waitbeforeretry') }}</strong>
                                </div>
                            @endif
                        </div>
                
                        {{-- Send reset link button --}}
                        <button type="submit" class="btn btn-block btn-secondary }}">
                            <span class="fas fa-share-square"></span>
                            {{ __('password.recovermail') }}
                        </button>
                
                    </form>
                </div>
            </div>
            <br><br>
        </div>
    </div>

@stop

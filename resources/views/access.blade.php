@extends('layouts/public')

@section('content')

    <div class="row margin-top-60">

        <div class="offset-lg-4 col-lg-4">

            <div class="card elegant">
                <div class="card-header">
                    <div class="animatedParent animateOnce">
                        <h3 class="head-h3">{{ __('login.login') }}</h3>
                        <p class="head-subtitle">{{ __('login.access') }}</p>
                    </div>
                </div>
                <div class="card-body">

                    <form action="/login" method="post">
                        {{ csrf_field() }}

                        <input type="hidden" name='redirectback' value={{$redirectback}}>
                        {{-- Email field --}}
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                value="{{ old('email') }}" placeholder="{{ __('login.email') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span style='height:30px;line-height:30px;' class="far  fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif
                        </div>

                        {{-- Password field --}}
                        <div class="input-group mb-3">
                            <input type="password" name="password"
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="{{ __('login.password') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span style='height:30px;line-height:30px;' class="fas fa-lock "></span>
                                </div>
                            </div>
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-lg-3">
                                {{-- Login button --}}
                                <button type="submit" class="btn btn-block btn-secondary">
                                    {{ __('login.enter') }}
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <small><a href='/forgot-password'>{{ __('login.forgotpassword') }}</a></small>
                            </div>
                        </div>
                        <div class="row margin-top-30">
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">{{ __('login.noaccount') }}</label>

                                {{-- Register button --}}
                                <a href='/register' class="btn btn-block btn-success">
                                    {{ __('login.register') }}
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <br><br>
        </div>
    </div>

@stop
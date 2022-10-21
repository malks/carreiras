@extends('layouts/public')

@section('content')
    <div class="row margin-top-30">
        
        <div class="col-10 offset-1">

            <div class="card elegant">
                <div class="card-header">
                    <div class="animatedParent animateOnce">
                        <h3 class="head-h3">{{ __('register.register') }}</h3>
                        <p class="head-subtitle">{{ __('register.firststep') }}</p>
                    </div>
                </div>

                <div class="card-body">
                    <div class="col-8 offset-2">
                        <form action="/register" method="post" class='margin-top-30'>
                            {{ csrf_field() }}

                            {{-- Name field --}}
                            <div class="input-group mb-3">
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    value="{{ old('name') }}" placeholder="Nome Completo" autofocus>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        <strong>{{ __('register.requiredfield') }}</strong>
                                    </div>
                                @endif
                            </div>

                            {{-- Email field --}}
                            <div class="input-group mb-3">
                                <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        <strong>{{ __('register.invalidemail') }}</strong>
                                    </div>
                                @endif
                            </div>

                            {{-- Password field --}}
                            <div class="input-group mb-3">
                                <input type="password" name="password"
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    placeholder="Senha">
                                @if($errors->has('password'))
                                    <div class="invalid-feedback">
                                        <strong>{{ __('register.8charpassword') }}</strong>
                                    </div>
                                @endif
                            </div>

                            {{-- Confirm password field --}}
                            <div class="input-group mb-3">
                                <input type="password" name="password_confirmation"
                                    class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                    placeholder="Confirme a senha">
                                @if($errors->has('password_confirmation'))
                                    <div class="invalid-feedback">
                                        <strong>{{ __('register.unmatchedpasswords') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="input-group mb-3">
                                <input type="checkbox" name='policy_accept' value='1' style='margin-top:5px;'>
                                <label for="">{{ __('register.imawareaccept') }} <a href='/policy' target='_blank'>{{ __('register.termsconditions') }}</a>{{ __('register.privacylunelli') }}</label>
                                @if($errors->has('policy_accept'))
                                    <div class="invalid-feedback">
                                        <strong>{{ __('register.imawareaccept') }}</strong>
                                    </div>
                                @endif
                            </div>
                    
                            {{-- Register button --}}
                            <button type="submit" class="btn btn-block btn-default">
                                {{ __('register.accountcreate') }}
                            </button>

                        </form>
                    </div>
                    <div class="col-8 offset-2">
                        <hr>
                    </div>
                    <div class="col-8 offset-2">
                        <label for="">{{ __('register.gotaccount') }}?</label>
                        <a href="/login" class='btn btn-block btn-success'>{{ __('register.dologin') }}</a>
                    </div>
                </div>


            </div>
        </div>
        <div class="row margin-top-50"></div>
    </div>

@stop
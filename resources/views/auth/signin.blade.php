@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
  <div class="columns">
    <div class="column is-offset-3 is-narrow is-6">
      <div id="login-card" class="card">
        <div class="card-content">
          <div class="content">
            <p class="title is-3">Sign In</p>
            <div id="signin-notification" class="notification is-success is-hidden">
              <button class="delete" onclick="closeNotification()"></button>
              <strong id="messsage">Success</strong>
            </div>
            <form id="signin-form">
              @csrf
              <div class="field">
                <label class="label" for="email">Email Address</label>
                <div class="control has-icons-left">
                  <input id="signin-email" name="email" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" value="{{ old('email') }}">
                  <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                  </span>
                </div>
              </div>
              @if ($errors->has('email'))
              <p class="help is-danger">
                {{ $errors->first('email') }}
              </p>
              @endif
              <div class="field">
                <label class="label" for="password">Password</label>
                <div class="control has-icons-left">
                  <input id="signin-password" name="password" type="password" class="input">
                  <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                </div>
              </div>
              <br>
              <button class="button is-primary is-fullwidth" type="submit" name="action" onclick="signin()">Submit</button>
              <br>
            </form>
            <p>Don't have an account? <a href="{{ url('signup') }}">Sign up</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@extends('layouts.auth')

@section('title', 'Sign Up')

@section('content')
  <div class="columns">
    <div class="column is-offset-3 is-narrow is-6">
      <div id="signup-card" class="card">
        <div class="card-content">
          <div class="content">
            <p class="title is-3">Sign Up</p>
            <form id="signup-form">
            @csrf
            <div class="field">
              <label class="label" for="name">Full Name</label>
              <div class="control">
                <input id="name" name="name" type="text" class="input">
              </div>
            </div>
            <div class="field">
              <label class="label" for="email">Email Address</label>
              <div class="control">
                <input id="signup-email" name="email" type="email" class="input">
              </div>
            </div>
            <div class="field">
              <label class="label" for="registration-number">NI (M/P)</label>
              <div class="control">
                <input id="registration-number" name="registration_number" type="text" class="input">
              </div>
            </div>
            <div class="field">
              <label class="label" for="phone-number">Phone Number</label>
              <div class="control">
                <input id="phone-number" name="phone_number" type="text" class="input">
              </div>
            </div>
            <div class="field">
              <label class="label" for="address">Address</label>
              <div class="control">
                <textarea id="address" name="address" class="textarea"></textarea>
              </div>
            </div>
            <div class="field">
              <label class="label" for="password">Password</label>
              <div class="control">
                <input id="signup-password" name="password" type="password" class="input">
              </div>
            </div>
            <div class="field">
              <label class="label" for="confirm-password">Confirm Password</label>
              <div class="control">
                <input id="confirm-password" name="confirm_password" type="password" class="input" autocomplete="off">
              </div>
            </div>
            <br>
            <button class="button is-primary is-fullwidth" type="submit" name="action" onclick="signup()">Submit</button>
            <br>
            </form>
            <p>Have an account? <a href="{{ url('signin') }}">Sign in</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

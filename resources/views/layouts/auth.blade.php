<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>

  <!-- Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>

  <!-- Bulma -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>

  <!-- Styles -->
  <style>
    #login-card {
      margin-top: 125px;
    }
    #signup-card {
      margin-top: 20px;
    }
  </style>

</head>
<body>
  <div class="section">
    <div class="container">
      @yield("content")
    </div>
  </div>
  <script>
    const signin = () => {
      document.querySelector('#signin-form').addEventListener('submit', async (event) => {
        event.preventDefault();

        const data = {
          email: document.querySelector('#signin-email').value,
          password: document.querySelector('#signin-password').value,
        };

        const url = `${window.location.origin}/api/auth/signin`;
        const token = document.querySelector('meta[name="csrf-token"]').content;

        const responseSignin = await fetch(url, {
          method: 'POST',
          headers: new Headers({
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
          }),
          credentials: 'same-origin',
          body: JSON.stringify(data),
        });

        const responseData = await responseSignin.json();
        let now = new Date();
        let time = now.getTime();
        time += responseData.expires_in * 1000;
        now.setTime(time);

        document.cookie = `jwt=${responseData.access_token}; expires=${now.toUTCString()}; path=/`;
        if (responseData) {
          return window.location.replace('/');
        }
      })
    }

    const signup = () => {
      document.querySelector('#signup-form').addEventListener('submit', async (event) => {
        event.preventDefault();

        const data = {
          name: document.querySelector('#name').value,
          registration_number: document.querySelector('#registration-number').value,
          phone_number: document.querySelector('#phone-number').value,
          address: document.querySelector('#address').value,
          email: document.querySelector('#signup-email').value,
          password: document.querySelector('#signup-password').value,
          confirm_password: document.querySelector('#confirm-password').value,
        };

        const url = `${window.location.origin}/api/auth/signup`;
        const token = document.querySelector('meta[name="csrf-token"]').content;

        const responseSignup = await fetch(url, {
          method: 'POST',
          headers: new Headers({
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
          }),
          credentials: 'same-origin',
          body: JSON.stringify(data),
        });

        const responseData = await responseSignup.json();

        if (responseData) {
          window.location.replace('/signin');
          let element = document.querySelector('#signin-notification');
          return element.classList.add("is-hidden")
        } else {
          return;
        }
      })
    }

    const closeNotification = () => {
      let element = document.querySelector('#signin-notification');
      element.classList.add("is-hidden")
    }
  </script>
</body>
</html>

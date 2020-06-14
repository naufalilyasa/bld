<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sign In</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body class="grey lighten-5">
  <div class="container">
    <div class="row">
      <div class="col s6 push-s3">
        <div class="card">
          <form method="post">
            @csrf
            <div class="card-content">
              <div class="row">
                <div class="input-field col s12">
                  <input type="email" placeholder="Email" name="email">
                  <label for="email">Email</label>
                </div>
                <div class="input-field col s12">
                  <input type="password" placeholder="Password" name="password">
                  <label for="password">Password</label>
                </div>
              </div>
              <div class="row">
                <button class="btn btn-block col s12" type="submit">Sign In</button>
              </div>
            </div>
          </form>
        </div>
        <p>Don't have an account? <a href="/auth/signup">Sign up</a> now!</p>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>

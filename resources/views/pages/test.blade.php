@extends('../master')
@section('title','login')
@section('content')
<div class="container">
<div id="login" class="logintab">
  <div class="flip">
    <div class="form-signup">
      <h1>Trainee Log in</h1>
      <fieldset>
        <form>
          <input type="email" placeholder="Enter your email address" required />
          <input type="password" placeholder="Create a password" required />
          <input type="submit" value="Sign up" />
        </form>
        <a href="#" class="flipper">Login with trainer account</a><br>
        <a href="#">Forgot Password?</a>
      </fieldset>
    </div>
    <div class="form-login">
      <h1>Trainer Log in</h1>
      <fieldset>
        <form>
          <input type="email" placeholder="Enter your email address" required />
          <input type="password" placeholder="Enter your password" required />
          <input type="submit" value="Log in" />
        </form>
        <a href="#" class="flipper">Login with trainee account</a><br>
        <a href="#">Forgot Password?</a>
      </fieldset>
    </div>
  </div>
</div>

</div>

@endsection
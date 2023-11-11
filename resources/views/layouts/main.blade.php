<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/united/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

  <title>@yield('title', 'LMS')</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-black" style="background-color: black;">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
        <a class="nav-item nav-link {{ request()->is('courses') ? 'active' : '' }}" href="/courses">Courses</a>
        <a class="nav-item nav-link {{ request()->is('contact') ? 'active' : '' }}" href="/contact">Contact</a>
        @auth
        @if(Auth::user()->is_teacher)
        <a class="nav-item nav-link" href="{{ route('courses.create') }}">New course</a>
        @else
        <a class="nav-item nav-link" href="{{ route('courses.available') }}">Enroll in a course</a>
        @endif
        @endauth
      </div>
      <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
        @if (Route::has('login'))
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        @endif

        @if (Route::has('register'))
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        </li>
        @endif
        @else
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }}
          </a>

          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </li>
        @endguest
      </ul>
    </div>
  </nav>

  @yield('content')

  <footer>
    <div class="footer">
      <a href="mailto:yousefgalal.alakhali@gmail.com" target="_blank">
        <i class="fa-regular fa-envelope fa-lg" style="padding-right:5px"></i>
      </a>
      <a href="https://twitter.com/home" target="_blank">
        <i class="fab fa-twitter fa-lg" style="padding-right:5px"></i>
      </a>
      <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">
        <i class="fab fa-youtube fa-lg" style="padding-right:5px"></i>
      </a>
      <a href="https://github.com/Yousef-1022" target="_blank">
        <i class="fab fa-github fa-lg" style="padding-right:5px"></i>
      </a>
    </div>
  </footer>

  <style>

    footer {
      bottom: 0;
      position: relative;
      width: 100%;
      margin-top: auto;
    }

    .footer {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      align-content: space-between;
      justify-content: space-around;
      background-color: black;
      margin-top: 1%;
    }

    .footer a {
      color: #f2f2f2;
      text-align: center;
      padding-top: 14px;
      padding-bottom: 14px;
      font-size: 23px;
    }

    .footer i:hover {
      color: red;
    }

    .container {
      width: 100%;
      height: 85.4vh;
      overflow: scroll;
      overflow-x: hidden;
    }

  </style>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
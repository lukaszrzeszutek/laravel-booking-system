<!--The MIT License (MIT)

Copyright (c) 2017 www.netprogs.pl

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.-->
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Enjoy the trip!</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://bootswatch.com/3/readable/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script>
          var base_url ='{{ url('/') }}';
        </script>
    </head>
    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('home') }}">Home</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                  @auth
                    <ul class="nav navbar-nav">
                        <li><p class="navbar-text">Zalogowany jako:</p></li>
                        <li><p class="navbar-text">{{ Auth::user()->name }}</p></li>
                        <li><a href="{{ route('adminHome') }}">admin</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form></li>
                    </ul>
                    @endauth
                    @guest
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ route('login') }}">Zaloguj się</a></li>
                        <li><a href="{{ route('register') }}">Zarejestruj się</a></li>
                    </ul>
                    @endguest
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="jumbotron">
            <div class="container">
                <h1>Enjoy the trip!</h1>
                <p>Platforma dla turystów i właścicieli obiektów turystycznych. Znajdź oryginalne miejsce na wakacje! </p>
                <p>Umieść swój obiekt w serwisie i daj się znaleźć wielu potencjalnym turystom!</p>
                <form method="POST" action="{{ route('roomSearch') }}" class="form-inline">
                    <div class="form-group">
                        <label class="sr-only" for="city">Miejscowość</label>
                        <input name="city" value="{{ old('city') }}" type="text" class="form-control autocomplete" id="city" placeholder="Miejscowość">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="day_in">Data przyjazdu</label>
                        <input name="day_in" value="{{ old('day_in') }}" type="text" class="form-control datepicker" id="day_in" placeholder="Data przyjazdu">
                    </div>

                    <div class="form-group">
                        <label class="sr-only" for="day_out">Data wyjazdu</label>
                        <input name="day_out" value="{{ old('day_out') }}" type="text" class="form-control datepicker" id="day_out" placeholder="Data wyjazdu">
                    </div>
                    <div class="form-group">
                        <select name="room_size" class="form-control">
                            <option>Osób w  pokoju</option>

                            @for($i=1;$i<=5;$i++)
                              @if(old('room_size') == $i)
                              <option selected value="{{ $i }}">{{ $i }}</option>
                              @else
                              <option value="{{ $i }}">{{ $i }}</option>
                              @endif
                            @endfor()


                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning">Szukaj</button>
                    {{ csrf_field() }}
                </form>

            </div>
        </div>

        @yield('content')

        <div class="container-fluid">

            <div class="row mobile-apps">

                <div class="col-md-6 col-xs-12">
                    <img src="{{ asset('images/mobile-app.png') }}" alt="" class="img-responsive center-block">
                </div>

                <div class="col-md-6 col-xs-12">
                    <h1 class="text-center">Pobierz aplikację na&nbsp;telefon.</h1>
                    <a href="#"><img class="img-responsive center-block" src="{{ asset('images/google.png') }}" alt=""></a><br><br>
                    <a href="#"><img class="img-responsive center-block" src="{{ asset('images/apple.png') }}" alt=""></a><br><br>
                    <a href="#"><img class="img-responsive center-block" src="{{ asset('images/windows.png') }}" alt=""></a>

                </div>

            </div>

            <hr>

            <footer>

                <p class="text-center">&copy; 2017 Enjoy the trip!, Inc.</p>

            </footer>

        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>

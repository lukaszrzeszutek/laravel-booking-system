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
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Panel administracyjny</title>

        <!-- Bootstrap core CSS -->
        <link href="https://bootswatch.com/3/readable/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <!-- Custom styles for this template -->
        <link href="http://getbootstrap.com/docs/4.0/examples/dashboard/dashboard.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->


        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
          var base_url ='{{ url('/admin') }}';
          <?php
          if(isset($_COOKIE['scroll_val']))
          {
            echo 'var scroll_val=' .'"'. (int) $_COOKIE['scroll_val'] . '";';

            setcookie('scroll_val','',-3000);
          }
          ?>
        </script>
    </head>

    <body>

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('home') }}">Enjoy the trip!</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                              @if( $ncounter = count($notifications->where('status',0)) )
                              <span id="app-notification-count" class="button__badge">{{ $ncounter }}</span>
                              @else
                              <span id="app-notification-count" class="button__badge hidden">0</span>
                              @endif
                              <span class="glyphicon glyphicon-envelope"></span> <span class="caret"></span></a>
                            <ul id="app-notifications-list" class="dropdown-menu">

                              @foreach($notifications as $notification)

                                @if($notification->status)
                                <li><a>{{ $notification->content }}</a></li>
                                @else
                                <li class="unread_notification"><a href="{{ $notification->id }}">{{ $notification->content }}</a></li>
                                @endif

                              @endforeach

                            </ul>
                        </li>
                        <li><p class="navbar-text">{{ Auth::user()->FullName }}</p></li>
                        <li><a href="{{ route('profile') }}">Profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li class="active"><a href="{{ route('adminHome') }}">Kalendarz rezerwacji <span class="sr-only">(current)</span></a></li>
                        @if(Auth::user()->hasRole(['owner','admin']))
                        <li><a href="{{ route('myObjects') }}">Moje obiekty</a></li>
                        <li><a href="{{ route('saveObject') }}">Dodaj nowy obiekt</a></li>
                        @endif
                        @if(Auth::user()->hasRole(['admin']))
                        <li><a href="{{ route('cities.index') }}">Miasta</a></li>
                        @endif
                    </ul>
                </div>

                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                  @if( $errors->any() )
                  <br />
                  <div class="alert alert-danger">
                    <ul>

                      @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                  @endif

                  @if( Session::has('message') )

                    <br>
                    <div class="alert {{ Session::get('alert-class','alert-info') }} alert-dismissible show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ Session::get('message') }}
                    </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

        <!-- dodane dla działania -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/admin.js') }}"></script>
        @stack('scripts')
        <script>
        $(function(){
          if(typeof scroll_val !== 'undefined')
          {
            $(window).scrollTop(scroll_val);
          }
        });

        function scroll_value(){
          document.cookie = 'scroll_val' + '=' + $(window).scrollTop();
        }

        $(document).on('click','.keep_pos',function(){
          scroll_value();
        });
        </script>


    </body>
</html>

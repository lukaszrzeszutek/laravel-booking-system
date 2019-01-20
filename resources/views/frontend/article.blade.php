@extends('layouts.frontend')

@section('content')

<div class="container">

    <h1>Artykuł <small>nt obiektu: <a href="{{ route('object',['id'=>$article->object->id]) }}">{{ $article->object->name }}</a></small></h1>
    <p>{{ $article->content }}</p>


    <a class="btn btn-primary top-buffer" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Lubią ten artykuł <span class="badge">{{ $article->users->count() }}</span>
    </a>
    <div class="collapse" id="collapseExample">
        <div class="well">

            <ul class="list-inline">
              @foreach( $article->users as $user )
                    <li><a href="{{ route('person',['id'=>$user->id]) }}"><img title="{{ $user->FullName }}" class="media-object img-responsive" width="50" height="50" src="{{ $user->photos->first()->path ?? $placeholder }}" alt="..."> </a></li>
@endforeach
            </ul>


        </div>
    </div>

    <h3>Komentarze</h3>

    @foreach( $article->comments as $comment )
        <div class="media">
            <div class="media-left media-top">
                <a href="{{ route('person', ['id'=>$comment->user->id]) }}">
                    <img class="media-object" width="50" height="50" src="{{ $comment->user->photos->first()->path ?? $placeholder }}" alt="...">
                </a>
            </div>
            <div class="media-body">
                {{ $comment->content }}
            </div>
        </div>
        <hr>
    @endforeach

    @auth

    @if( $article->isLiked() )
    <a href="{{ route('unlike',['id'=>$article->id,'type'=>'App\Article']) }}" class="btn btn-primary btn-xs top-buffer">Odlub ten artykuł</a>

    @else
    <a href="{{ route('like',['id'=>$article->id,'type'=>'App\Article']) }}" class="btn btn-primary btn-xs top-buffer">Polub ten artykuł</a>

    @endif

    @else

        <p>  <a href="{{ route('login') }}" class="btn btn-primary btn-xs top-buffer">Polub ten artykuł</a>  </p>

    @endauth

    <br><br>

    @auth
    <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
        Dodaj komentarz
    </a>
    @else
    <a class="btn btn-primary" role="button" href="{{ route('login') }}">
        Dodaj komentarz
    </a>
    @endauth

    <div class="collapse" id="collapseExample2">
        <div class="well">


            <form method="POST" action="{{ route('addComment',['article_id'=>$article->id, 'App\Article']) }}" class="form-horizontal">
                <fieldset>

                    <div class="form-group">
                        <label for="textArea" class="col-lg-2 control-label">Komentarz</label>
                        <div class="col-lg-10">
                            <textarea required name="content" class="form-control" rows="3" id="textArea"></textarea>
                            <span class="help-block">Dodaj komentarz na temat tego artykułu.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Wyślij</button>
                        </div>
                    </div>
                </fieldset>
                {{ csrf_field() }}
            </form>

        </div>
    </div>


</div>


@endsection

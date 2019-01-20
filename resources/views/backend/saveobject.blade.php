@extends('layouts.backend')

@section('content')

@if( $object ?? false )
<h2>Edycja obiektu {{ $object->name }}</h2>
@else
<h2>Dodawanie nowego obiektu</h2>
@endif


<form {{ $novalidate }} method="POST" action="{{ route('saveObject',['id'=>$object->id ?? null]) }}" enctype="multipart/form-data" class="form-horizontal">
    <fieldset>
        <div class="form-group">
            <label for="city" class="col-lg-2 control-label">Miasto *</label>
            <div class="col-lg-10">
                <select name="city" class="form-control" id="city">
                  @foreach($cities as $city)
                    @if( ($object ?? false ) && $object->city->id == $city->id)
                    <option selected value="{{ $city->id }}">{{ $city->name }}</option>
                    @else
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endif

                  @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-lg-2 control-label">Nazwa *</label>
            <div class="col-lg-10">
                <input name="name" required type="text" value="{{ $object->name ?? old('name') }}" class="form-control" id="name" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="street" class="col-lg-2 control-label">Ulica *</label>
            <div class="col-lg-10">
                <input name="street" required type="text" value="{{ $object->addresses->street ?? old('street') }}" class="form-control" id="street" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="number" class="col-lg-2 control-label">Numer *</label>
            <div class="col-lg-10">
                <input name="number" required type="number" value="{{ $object->addresses->number ?? old('number') }}" class="form-control" id="number" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="descr" class="col-lg-2 control-label">Opis obiektu *</label>
            <div class="col-lg-10">
                <textarea name="description" required class="form-control" rows="3" id="descr">{{ $object->description ?? old('description') }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <label for="objectPictures">Zdjęcia obiektu</label>
                <input type="file" name="objectPictures[]" id="objectPictures" multiple>
                <p class="help-block">Dodaj galerię zdjęć obiektu</p>
            </div>
        </div>

        @if( $object ?? false )

        <div class="col-lg-10 col-lg-offset-2">

            @foreach( $object->photos->chunk(4) as $chanked_photos)

                <div class="row">


                    @foreach($chanked_photos as $photo)

                        <div class="col-md-3 col-sm-6">
                            <div class="thumbnail">
                                <img class="img-responsive" src="{{ $photo->path ?? $placeholder }}" alt="...">
                                <div class="caption">
                                    <p><a href="{{ route('deletePhoto',['id'=>$photo->id]) }}" class="btn btn-primary btn-xs" role="button">Usuń</a></p>
                                </div>

                            </div>
                        </div>

                    @endforeach

                </div>


          @endforeach

        </div>

        <div class="col-lg-10 col-lg-offset-2">
            Artykuły:
            <ul class="list-group">
              @foreach( $object->articles as $article )
                    <li class="list-group-item">
                        {{ $article->title }} <a href="{{ route('deleteArticle',['id'=>$article->id]) }}">usuń</a>
                    </li>
              @endforeach

            </ul>
        </div>

        @endif

        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-primary">Zapisz obiekt</button>
            </div>
        </div>

    </fieldset>
    {{ csrf_field() }}
</form>

<div class="col-lg-10 col-lg-offset-2">

    <form {{ $novalidate }} method="POST" action="{{ route('saveArticle',['id'=>$object->id ?? null]) }}" class="form-horizontal">
        <fieldset>

            <div class="form-group">
                <label for="textTitle" class="col-lg-2 control-label">Tytuł *</label>
                <div class="col-lg-10">
                    <input name="title" value="{{ old('title') }}" required type="text" class="form-control" id="textTitle" placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label for="textArea" class="col-lg-2 control-label">Treść *</label>
                <div class="col-lg-10">
                    <textarea name="content" required class="form-control" rows="3" id="textArea">{{ old('content') }}</textarea>
                    <span class="help-block">Dodaj artykuł na temat tego obiektu.</span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                </div>
            </div>
        </fieldset>
        {{ csrf_field() }}
    </form>

</div>


@endsection

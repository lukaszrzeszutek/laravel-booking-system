@extends('layouts.backend')

@section('content')

<h2>Lista obiektów</h2>
@foreach( $objects as $object )

    <div class="panel panel-success top-buffer">
        <div class="panel-heading">
            <h3 class="panel-title">Obiekt {{ $object->name }} <small><a href="{{ route('saveObject',['id'=>$object->id]) }}" class="btn btn-danger btn-xs">edytuj</a> <a href="{{ route('saveRoom'). '?object_id='.$object->id }}" class="btn btn-danger btn-xs">dodaj pokój</a> <a title="usuń" href="{{ route('deleteObject',['id'=>$object->id]) }}"><span class="glyphicon glyphicon-remove"></span></a></small> </h3>
        </div>

        <div class="panel-body">
            @foreach( $object->rooms as $room )
                <span class="my_objects">
                    Pokój {{ $room->room_number }} <a title="edytuj" href="{{ route('saveRoom',['id'=>$room->id]) }}"><span class="glyphicon glyphicon-edit"></span></a> <a title="usuń" href="{{ route('deleteRoom',['id'=>$room->id]) }}"><span class="glyphicon glyphicon-remove"></span></a> </span>
                    @endforeach
        </div>

    </div>

@endforeach

@endsection

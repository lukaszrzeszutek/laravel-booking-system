@extends('layouts.backend')

@section('content')

<h1>Miasta <small><a class="btn btn-success" href="{{ route('cities.create') }}" data-type="button"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Nowe miasto </a></small></h1>

<div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th>Nazwa miasta</th>
            <th>Edytuj / Usuń</th>
        </tr>
        @foreach( $cities as $city )
            <tr>
                <td>{{ $city->name }}</td>
                <td>
                    <a href="{{ route('cities.edit',['id'=>$city->id]) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    <form style="display: inline;" method="POST" action="{{ route('cities.destroy', ['id'=>$city->id]) }}">
                        <button type="submit" class="btn btn-primary btn-xs" onclick="return confirm('Na pewno usunąć?');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                      {{ method_field('DELETE') }}
                      {{ csrf_field() }}
                    </form>

                </td>
            </tr>
        @endforeach
    </table>
</div>

@endsection

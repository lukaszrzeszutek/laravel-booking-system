@extends('layouts.backend')

@section('content')

<h1>Edytuj miasto</h1>
<form {{ $novalidate }} method="POST" action="{{ route('cities.update',['id'=>$city->id]) }}">
<h3>Nazwa * </h3>
<input class="form-control" value="{{ $city->name }}" type="text" required name="name"><br>
<button class="btn btn-primary" type="submit">Zapisz</button>
{{ csrf_field() }}
{{ method_field('PUT') }}
</form>

@endsection

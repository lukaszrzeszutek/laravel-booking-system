@extends('layouts.frontend')

@section('content')

<div class="container places">
    <h1 class="text-center">Pokój w obiekcie <a href="{{ route('object',['room'=>$room->obiekt_id]) }}">{{ $room->object->name }}</a></h1>

    @foreach( $room->photos->chunk(3) as $chunked_photos )

        <div class="row top-buffer">
          @foreach($chunked_photos as $photo)
            <div class="col-md-4">
                <img class="img-responsive" src="$photo->path ?? $placeholder" alt="">
            </div>
            @endforeach
        </div>

    @endforeach


    <section>

        <ul class="list-group">
            <li class="list-group-item">
                <span class="bolded">Opis:</span> {{ $room->description }}
            </li>
            <li class="list-group-item">
                <span class="bolded">Ilość osób w pokoju:</span> {{ $room->room_size }}
            </li>
            <li class="list-group-item">
                <span class="bolded">Cena za dobę:</span> {{ $room->price }}
            </li>
            <li class="list-group-item">
                <span class="bolded">Adres:</span> {{ $room->object->city->name }} {{ $room->object->addresses->street }} {{$room->object->addresses->number }}
            </li>
        </ul>
    </section>

    <section id="reservation">

        <h3>Rezerwacja</h3>

        <div class="row">
            <div class="col-md-6">
                <form {{$novalidate}} action="{{ route('makeReservation',['room_id'=>$room->id, 'city_id'=>$room->object->city->id]) }}" method="POST">
                    <div class="form-group">
                        <label for="dayin">Data przyjazdu</label>
                        <input required name="dayin" type="text" class="form-control datepicker" id="dayin" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="dayout">Data wyjazdu</label>
                        <input required name="dayout" type="text" class="form-control datepicker" id="dayout" placeholder="">
                    </div>
                    <button type="submit" class="btn btn-primary">Rezerwuj</button>
                    <p class="text-danger">{{ Session::get('reservationMsg') }}</p>
                    {{ csrf_field() }}
                </form>
            </div><br>
            <div class="col-md-6">
                <div id="avaiability_calendar"></div>
            </div>
        </div>


    </section>

</div>

@endsection
@push('scripts')
<script>
function datesBetween(startDt, endDt)
{
  var between = [];
  var currentDate = new Date(startDt);
  var end = new Date(endDt);

  while(currentDate <= end)
  {
    between.push( $.datepicker.formatDate('yy-mm-dd', new Date(currentDate)) );
    currentDate.setDate(currentDate.getDate()+1);
  }

  return between;
}

$.ajax({
  cache: false,
  url: base_url + '/ajaxGetRoomReservations/' + {{ $room->id }},
  type: "GET",
  success: function(response){

    //room.php
    var eventDates = {};
    var dates = [];
    for (var i = 0; i <= response.reservations.length - 1; i++)
    {

      dates.push( datesBetween(new Date(response.reservations[i].day_in), new Date(response.reservations[i].day_out)) );

    }

    dates = [].concat.apply([],dates);

    for (var i = 0; i <= dates.length - 1; i++)
    {
        eventDates[dates[i]] = dates[i];
    }



    $(function () {
        $("#avaiability_calendar").datepicker({
            onSelect: function (data) {

                console.log($('#dayin').val());

                if ($('#dayin').val() == '')
                {
                    $('#dayin').val(data);
                } else if ($('#dayout').val() == '')
                {
                    $('#dayout').val(data);
                } else if ($('#dayout').val() != '')
                {
                    $('#dayin').val(data);
                    $('#dayout').val('');
                }

            },
            beforeShowDay: function (date)
            {
                var tmp = eventDates[$.datepicker.formatDate('yy-mm-dd',date)];
                if (tmp)
                    return [false, 'unavaiable_date'];
                else
                    return [true, ''];
            }


        });
    });

  }

});

</script>
@endpush

@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: -1.5rem; margin-bottom: -1.5rem;">
    <div class="row">
        <div class="col-3">
            <form method="get" action="/bookings" class="py-4 sticky-top">
                <div class="form-row mb-2">
                    <div class="col">
                        <input onchange="this.form.submit();" type="text" name="date" id="date" class="form-control datepicker text-center" value="{{ old('date') ?? $search_params['date'] }}">
                    </div>
                    <div class="col-auto">
                        <a href="/bookings" class="btn btn-primary">Jetzt</a>
                    </div>
                </div>
                <div class="btn-group-vertical w-100 btn-group-toggle mb-2" data-toggle="buttons">
                    <label class="btn btn-secondary">
                        <input onchange="this.form.submit();" type="radio" name="timeslot" id="morning" value="morning"  @if($timeslot == 'morning') checked @endif> 10:00 - 13:30
                    </label>
                    <label class="btn btn-secondary">
                        <input onchange="this.form.submit();" type="radio" name="timeslot" id="noon_evening" value="noon_evening" @if($timeslot == 'noon_evening') checked @endif> 14:00 - 19:30
                    </label>
                </div>
            </form>
        </div>
        <div class="col-9 py-4">
            <h1>Reservierungen</h1>
            <p>Angezeigt Daten vom {{ $search_params['date'] }} Anzahl der Reservierungen: {{ $sum_of_people }}</p>
            @forelse ($bookings as $booking)
                @if ($loop->first)
                <table id="bookingTable" class='table'>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Telefon</th>
                            <th>Personenzahl</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                @endif
                <tr>
                    <td class="action">
                        @if(!$booking->confirmed)
                            <form action="/booking/checkin/{{ $booking->id }}" method="post">
                                @csrf
                                <button title="Einchecken" class="btn btn-success"><i class="fas fa-fw fa-sign-in-alt"></i></button>
                            </form>
                        @else
                            <form action="/booking/checkout/{{ $booking->id }}" method="post">
                                @csrf
                                <button title="Auschecken" class="btn btn-secondary"><i class="fas fa-fw fa-sign-out-alt"></i></button>
                            </form>
                        @endif
                    </td>
                    <td>{{ $booking->last_name }}, {{ $booking->first_name }}</td>
                    <td>{{ $booking->phone }}</td>
                    <td>{{ $booking->amount_of_people }}</td>
                    <td class="action">
                        <button title="Stornieren" data-id="{{ $booking->id }}" class="cancel btn btn-danger"><i class="fas fa-fw fa-trash-alt"></i></button>
                    </td>
                </tr>
                @if ($loop->last)
                </tbody>
                </table>
                @endif
            @empty
                <p>Keine Reservierungen gefunden</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@props(['momento' => null])

@if($momento)
    @php($hora = \Illuminate\Support\Carbon::parse($momento)->timezone('America/Bogota'))
    <time datetime="{{ $hora->toIso8601String() }}">{{ $hora->format('d/m/Y H:i:s') }}</time>
@else
    Hora no registrada
@endif

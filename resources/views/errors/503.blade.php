@extends('errors.plantilla')

@section('codigo', '503')
@section('titulo', isset($mensajeTemporal) ? 'Registro temporalmente ocupado' : 'El sistema está temporalmente en mantenimiento')
@section('mensaje')
    {{ $mensajeTemporal ?? 'Intenta nuevamente dentro de unos minutos.' }}
@endsection

@extends('layouts.administrador')

@section('contenido')
    <div class="card formulario-centrado comprobante"><div class="card-body p-lg-4">
        <p class="d-none d-print-block fw-semibold mb-1">Valtraza · Comprobante de servicio</p>
        <p class="text-success fw-semibold d-print-none">Servicio registrado correctamente</p><h1 class="h3">{{ $servicio->nombre }}</h1>
        <dl class="row mt-4"><dt class="col-sm-4">Código del servicio</dt><dd class="col-sm-8">{{ $servicio->codigo_servicio }}</dd><dt class="col-sm-4">Fecha</dt><dd class="col-sm-8">{{ \Illuminate\Support\Carbon::parse($servicio->fecha)->format('d/m/Y') }}</dd><dt class="col-sm-4">Registrado en Valtraza</dt><dd class="col-sm-8"><x-hora-registro :momento="$servicio->registrado_en" /></dd><dt class="col-sm-4">Computador</dt><dd class="col-sm-8">{{ $servicio->equipo->codigo_equipo }} · {{ $servicio->equipo->modelo ?: 'Modelo no registrado' }}</dd><dt class="col-sm-4">Estado</dt><dd class="col-sm-8"><x-estado :valor="$servicio->estado" /></dd></dl>
        @if(session('envio_seguimiento') === true)
            <p class="alert alert-success d-print-none" role="status">Se envió el código de seguimiento al correo del cliente.</p>
        @elseif(session('envio_seguimiento') === false)
            <p class="alert alert-warning d-print-none" role="status">El servicio está registrado, pero el correo no pudo enviarse. Puedes reenviarlo o entregar el comprobante.</p>
        @elseif(! $servicio->equipo->cliente->correo)
            <p class="text-body-secondary d-print-none">El cliente no tiene correo registrado. Entrégale el comprobante con el código.</p>
        @endif
        <div class="p-3 bg-body-tertiary rounded mb-4"><p class="fw-semibold mb-1">Código de seguimiento para el cliente</p><p class="codigo-seguimiento mb-2">{{ $servicio->codigo_seguimiento }}</p><button class="btn btn-outline-primary btn-sm d-print-none" type="button" data-copiar="{{ $servicio->codigo_seguimiento }}">Copiar código</button><p class="small mb-0 mt-2 d-print-none">Entrega este código al cliente para consultar su servicio.</p><p class="small mb-0 mt-2 d-none d-print-block">Consulta el estado de tu servicio en {{ route('inicio') }} con este código. Guárdalo: no se muestra en ninguna otra parte.</p></div>
        <div class="d-flex flex-wrap gap-2 d-print-none">
            <a class="btn btn-primary" href="{{ route('servicios.asignacion', $servicio->id_servicio) }}">Asignar técnico</a>
            <a class="btn btn-outline-secondary" href="{{ route('servicios.index') }}">Ver servicios</a>
            @if($servicio->equipo->cliente->correo)
                <form method="post" action="{{ route('servicios.reenviar', $servicio->id_servicio) }}">@csrf
                    <button type="submit" class="btn btn-outline-secondary">Reenviar seguimiento</button>
                </form>
            @endif
            <button class="btn btn-outline-secondary" type="button" data-imprimir>Imprimir comprobante</button>
        </div>
    </div></div>
@endsection

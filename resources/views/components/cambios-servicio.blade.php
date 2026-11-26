@props(['cambios'])

<section id="cambios-servicio" class="card mt-4" aria-labelledby="titulo-cambios-servicio">
    <div class="card-body">
        <h2 id="titulo-cambios-servicio" class="h5">Historial de asignación y estado</h2>
        <ul class="list-group list-group-flush">
            @forelse($cambios as $cambio)
                <li class="list-group-item px-0">{{ $cambio->descripcion }} <span class="text-body-secondary"><x-hora-registro :momento="$cambio->registrado_en" /></span></li>
            @empty
                <li class="list-group-item px-0 text-body-secondary">Todavía no hay cambios en el historial.</li>
            @endforelse
        </ul>
        {{ $cambios->fragment('cambios-servicio')->links() }}
    </div>
</section>

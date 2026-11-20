<?php

namespace App\Services\ClientesEquipos;

use App\Models\Cliente;
use App\Models\Equipo;
use App\Support\EntradaFormulario;
use App\Support\GuardarRegistro;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class RegistroClientesEquipos
{
    public function buscar(?string $identificacion): mixed
    {
        return Cliente::query()
            ->when($identificacion, fn ($consulta) => $consulta->where('numero_identificacion', $identificacion))
            ->orderBy('nombre')->orderBy('id_cliente')->paginate(EntradaFormulario::POR_PAGINA)->withQueryString();
    }

    public function listar(): LengthAwarePaginator
    {
        return Cliente::query()->orderBy('nombre')->orderBy('id_cliente')
            ->paginate(EntradaFormulario::POR_PAGINA, ['*'], 'clientes_pagina')->withQueryString();
    }

    public function obtener(int $id): Cliente
    {
        return Cliente::query()->findOrFail($id);
    }

    public function seleccionar(?int $id): ?Cliente
    {
        return $id ? Cliente::query()->find($id) : null;
    }

    public function buscarPorIdentificacion(?string $identificacion): ?Cliente
    {
        return $identificacion ? Cliente::query()->where('numero_identificacion', $identificacion)->first() : null;
    }

    public function registrarCliente(array $datos): Cliente
    {
        return GuardarRegistro::ejecutar(
            fn () => Cliente::query()->create($datos),
            ['numero_identificacion' => 'Este cliente ya existe. Puedes consultar su ficha.']
        );
    }
}

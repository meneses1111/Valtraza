<?php

namespace Tests\Unit;

use App\Http\Requests\ActivarCuentaRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ReglasActivacionTest extends TestCase
{
    private function falla(array $datos): bool
    {
        return Validator::make($datos, (new ActivarCuentaRequest)->rules())->fails();
    }

    private function datos(string $contrasena, ?string $confirmacion = null): array
    {
        return ['codigo_activacion' => 'codigo-ficticio', 'password' => $contrasena, 'password_confirmation' => $confirmacion ?? $contrasena];
    }

    public function test_una_contrasena_de_siete_caracteres_es_rechazada(): void
    {
        $this->assertTrue($this->falla($this->datos('Abcd1!x')));
    }

    public function test_una_contrasena_de_ocho_caracteres_es_aceptada(): void
    {
        $this->assertFalse($this->falla($this->datos('Abcdef1!')));
    }

    public function test_la_contrasena_requiere_letra_numero_y_simbolo(): void
    {
        foreach (['Abcdefg!', 'Abcdefg1', '1234567!', 'Abc1234 '] as $contrasena) {
            $this->assertTrue($this->falla($this->datos($contrasena)));
        }
    }

    public function test_la_confirmacion_debe_coincidir(): void
    {
        $this->assertTrue($this->falla($this->datos('Abcdef1!', 'Abcdef2!')));
    }

    public function test_una_contrasena_de_72_bytes_es_aceptada(): void
    {
        $this->assertFalse($this->falla($this->datos(str_repeat('a', 70).'1!')));
    }

    public function test_una_contrasena_de_73_bytes_es_rechazada(): void
    {
        $this->assertTrue($this->falla($this->datos(str_repeat('a', 71).'1!')));
    }

    public function test_una_contrasena_con_tildes_se_mide_en_bytes(): void
    {
        $this->assertTrue($this->falla($this->datos(str_repeat('ñ', 36).'1!')));
    }

    public function test_una_contrasena_con_caracter_nulo_es_rechazada(): void
    {
        $this->assertTrue($this->falla($this->datos("Abcdef1!\0")));
    }

    public function test_el_codigo_de_activacion_es_obligatorio(): void
    {
        $this->assertTrue($this->falla(['password' => 'Abcdef1!', 'password_confirmation' => 'Abcdef1!']));
    }

    public function test_la_contrasena_es_obligatoria(): void
    {
        $this->assertTrue($this->falla(['codigo_activacion' => 'codigo-ficticio']));
    }
}

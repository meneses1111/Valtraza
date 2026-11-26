<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['cliente', 'tecnico'] as $tabla) {
            Schema::table($tabla, function (Blueprint $table): void {
                $table->string('tipo_identificacion', 2)->nullable();
            });

            DB::statement("ALTER TABLE {$tabla} ADD CONSTRAINT ck_{$tabla}_tipo_identificacion CHECK (
                tipo_identificacion IS NULL
                OR (tipo_identificacion IN ('CC', 'TI', 'CE') AND numero_identificacion ~ '^[0-9]+$')
                OR (tipo_identificacion = 'PA' AND numero_identificacion ~ '^[A-Za-z0-9]+$')
            )");
        }
    }

    public function down(): void
    {
        foreach (['cliente', 'tecnico'] as $tabla) {
            Schema::table($tabla, function (Blueprint $table): void {
                $table->dropColumn('tipo_identificacion');
            });
        }
    }
};

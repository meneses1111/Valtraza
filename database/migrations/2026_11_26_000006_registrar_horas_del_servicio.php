<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servicio', function (Blueprint $table): void {
            $table->timestampTz('registrado_en')->nullable();
        });
        DB::statement('ALTER TABLE servicio ALTER COLUMN registrado_en SET DEFAULT clock_timestamp()');

        Schema::create('cambio_servicio', function (Blueprint $table): void {
            $table->id();
            $table->integer('id_servicio');
            $table->foreign('id_servicio')->references('id_servicio')->on('servicio')->cascadeOnDelete();
            $table->string('descripcion');
            $table->timestampTz('registrado_en')->default(DB::raw('clock_timestamp()'));
            $table->index(['id_servicio', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cambio_servicio');
        Schema::table('servicio', function (Blueprint $table): void {
            $table->dropColumn('registrado_en');
        });
    }
};

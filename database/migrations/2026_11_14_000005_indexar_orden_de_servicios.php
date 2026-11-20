<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servicio', function (Blueprint $table): void {
            $table->index(['fecha', 'id_servicio'], 'idx_servicio_fecha_id');
            $table->index(['id_tecnico', 'fecha', 'id_servicio'], 'idx_servicio_tecnico_fecha_id');
        });
    }

    public function down(): void
    {
        Schema::table('servicio', function (Blueprint $table): void {
            $table->dropIndex('idx_servicio_tecnico_fecha_id');
            $table->dropIndex('idx_servicio_fecha_id');
        });
    }
};

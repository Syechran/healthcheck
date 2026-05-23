<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('disease_name');              // dummy detection result
            $table->string('severity')->default('mild'); // mild | moderate | severe
            $table->unsignedTinyInteger('confidence')->default(0); // 0-100 (%)
            $table->string('detected_area')->nullable();
            $table->string('image_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('detected_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'detected_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detections');
    }
};

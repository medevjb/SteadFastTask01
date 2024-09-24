<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();

            $table->foreignId('form_templete_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('label');
            $table->enum('type', ['text', 'textarea', 'number', 'select', 'checkbox', 'radio', 'file', 'date', 'time', 'datetime']);
            $table->json('options')->nullable();
            $table->string('placeholder')->nullable();

            $table->boolean('is_required')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};

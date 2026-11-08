<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->constrained('users')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

            // jenis pekerjaan menentukan form input/output mana yang dipakai di UI
            $table->enum('job_title', [
                'content_creator',
                'graphic_designer',
                'social_media_specialist',
            ]);

            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->date('deadline')->nullable();
            $table->enum('status', ['todo', 'in_progress', 'review', 'revisi', 'done'])
                  ->default('todo');

            // INPUT: brief/instruksi kerja dari Owner, berbeda struktur per job_title (disimpan JSON)
            $table->json('input_data')->nullable();

            // OUTPUT: hasil kerja yang diisi anggota, berbeda struktur per job_title (disimpan JSON)
            $table->json('output_data')->nullable();

            // progres manual 0-100, diisi anggota saat status in_progress
            $table->unsignedTinyInteger('progress')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

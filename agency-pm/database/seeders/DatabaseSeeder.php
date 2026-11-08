<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ====== USERS ======
        $raffi = User::create([
            'name' => 'Raffi',
            'email' => 'raffi@agency.test',
            'password' => Hash::make('password'),
        ]);

        $rasya = User::create([
            'name' => 'Rasya Chaniago',
            'email' => 'rasya@agency.test',
            'password' => Hash::make('password'),
        ]);

        $melda = User::create([
            'name' => 'Melda Munisa',
            'email' => 'melda@agency.test',
            'password' => Hash::make('password'),
        ]);

        $popita = User::create([
            'name' => 'Popita Sari',
            'email' => 'popita@agency.test',
            'password' => Hash::make('password'),
        ]);

        // ====== WORKSPACE ======
        $workspace = Workspace::create([
            'name' => 'Digital Agency Studio',
            'agency_name' => 'Studio milik Raffi & tim',
            'owner_id' => $raffi->id,
        ]);

        WorkspaceMember::create(['workspace_id' => $workspace->id, 'user_id' => $raffi->id, 'role' => 'owner']);
        WorkspaceMember::create(['workspace_id' => $workspace->id, 'user_id' => $rasya->id, 'role' => 'member', 'job_title' => 'graphic_designer']);
        WorkspaceMember::create(['workspace_id' => $workspace->id, 'user_id' => $melda->id, 'role' => 'member', 'job_title' => 'content_creator']);
        WorkspaceMember::create(['workspace_id' => $workspace->id, 'user_id' => $popita->id, 'role' => 'member', 'job_title' => 'social_media_specialist']);

        // ====== PROJECT (CAMPAIGN KLIEN) ======
        $project = Project::create([
            'workspace_id' => $workspace->id,
            'name' => 'Campaign Media Sosial - Peluncuran Produk',
            'client_name' => 'Kopi Nusantara',
            'brief' => 'Klien ingin campaign peluncuran produk kopi kemasan baru di Instagram, fokus pada audiens muda usia 20-30 tahun.',
            'start_date' => now(),
            'deadline' => now()->addWeeks(2),
        ]);

        // ====== TASKS ======
        Task::create([
            'project_id' => $project->id,
            'assigned_to' => $melda->id,
            'created_by' => $raffi->id,
            'job_title' => 'content_creator',
            'title' => 'Buat 10 ide konten & caption feed Instagram',
            'description' => 'Fokuskan pada keunggulan rasa dan kemasan baru.',
            'priority' => 'high',
            'deadline' => now()->addDays(4),
            'status' => 'todo',
            'input_data' => [
                'content_type' => 'Caption',
                'topic' => 'Peluncuran produk kopi kemasan baru',
                'tone_of_voice' => 'Santai, hangat, anak muda',
                'reference_link' => 'https://instagram.com/kopinusantara',
            ],
        ]);

        Task::create([
            'project_id' => $project->id,
            'assigned_to' => $rasya->id,
            'created_by' => $raffi->id,
            'job_title' => 'graphic_designer',
            'title' => 'Desain 10 visual feed Instagram',
            'description' => 'Sesuaikan dengan brand guideline klien (warna coklat & krem).',
            'priority' => 'high',
            'deadline' => now()->addDays(5),
            'status' => 'in_progress',
            'progress' => 40,
            'input_data' => [
                'design_type' => 'Feed Instagram',
                'dimensions' => '1080x1080px',
                'brand_guideline' => 'https://drive.google.com/brand-kopinusantara',
                'color_notes' => 'Dominan coklat & krem, aksen emas',
            ],
        ]);

        Task::create([
            'project_id' => $project->id,
            'assigned_to' => $popita->id,
            'created_by' => $raffi->id,
            'job_title' => 'social_media_specialist',
            'title' => 'Susun jadwal posting 2 minggu',
            'priority' => 'medium',
            'deadline' => now()->addDays(3),
            'status' => 'review',
            'progress' => 100,
            'input_data' => [
                'platforms' => 'Instagram',
                'post_schedule' => now()->addDays(3)->toDateString(),
                'campaign_goal' => 'Awareness & engagement peluncuran produk',
            ],
            'output_data' => [
                'post_link' => 'https://docs.google.com/jadwal-posting-kopinusantara',
                'report_notes' => 'Jadwal disusun 1x posting/hari selama 14 hari, jam posting disesuaikan jam ramai audiens.',
            ],
        ]);

        $this->command->info('Seeding selesai. Login: raffi@agency.test / rasya@agency.test / melda@agency.test / popita@agency.test — password: password');
    }
}

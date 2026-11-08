<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectManagementWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected User $member;
    protected Workspace $workspace;
    protected Project $project;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup Owner (Raffi)
        $this->owner = User::factory()->create([
            'name' => 'Raffi (Owner)',
            'email' => 'raffi@agency.test',
        ]);

        // Setup Member (Melda)
        $this->member = User::factory()->create([
            'name' => 'Melda (Member)',
            'email' => 'melda@agency.test',
        ]);

        // Workspace
        $this->workspace = Workspace::create([
            'name' => 'Digital Agency Studio',
            'agency_name' => 'Digital Agency Studio',
            'owner_id' => $this->owner->id,
        ]);

        // Attach members
        WorkspaceMember::create([
            'workspace_id' => $this->workspace->id,
            'user_id' => $this->owner->id,
            'role' => 'owner',
        ]);

        WorkspaceMember::create([
            'workspace_id' => $this->workspace->id,
            'user_id' => $this->member->id,
            'role' => 'member',
            'job_title' => 'content_creator',
        ]);

        // Project
        $this->project = Project::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'Campaign Media Sosial - Peluncuran Produk',
            'client_name' => 'Kopi Nusantara',
            'brief' => 'Brief kampanye',
            'start_date' => now()->toDateString(),
            'deadline' => now()->addDays(14)->toDateString(),
        ]);
    }

    public function test_dashboard_renders_for_owner_and_member(): void
    {
        $responseOwner = $this->actingAs($this->owner)->get('/dashboard');
        $responseOwner->assertStatus(200);
        $responseOwner->assertSee('Raffi');

        $responseMember = $this->actingAs($this->member)->get('/dashboard');
        $responseMember->assertStatus(200);
        $responseMember->assertSee('Melda');
    }

    public function test_member_cannot_create_project_in_workspace(): void
    {
        $response = $this->actingAs($this->member)->post(route('projects.store', $this->workspace), [
            'name' => 'Proyek Ilegal',
            'client_name' => 'Klien X',
            'start_date' => now()->toDateString(),
            'deadline' => now()->addDays(5)->toDateString(),
        ]);

        $response->assertStatus(403);
    }

    public function test_owner_can_create_task_and_assign_to_member(): void
    {
        $response = $this->actingAs($this->owner)->post(route('tasks.store', $this->project), [
            'title' => 'Menyusun 10 ide konten beserta caption feed Instagram',
            'description' => 'Konten kampanye Kopi Nusantara',
            'assigned_to' => $this->member->id,
            'priority' => 'high',
            'deadline' => now()->addDays(3)->toDateString(),
            'input' => [
                'content_type' => 'Caption',
                'topic' => 'Kopi',
                'tone_of_voice' => 'Santai',
            ],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'title' => 'Menyusun 10 ide konten beserta caption feed Instagram',
            'assigned_to' => $this->member->id,
            'status' => 'todo',
        ]);
    }

    public function test_full_validation_workflow_todo_to_review_to_revision_to_done(): void
    {
        // 1. Create task
        $task = Task::create([
            'project_id' => $this->project->id,
            'assigned_to' => $this->member->id,
            'created_by' => $this->owner->id,
            'job_title' => 'content_creator',
            'title' => 'Desain Feed Instagram',
            'priority' => 'high',
            'deadline' => now()->addDays(5)->toDateString(),
            'status' => 'todo',
        ]);

        // 2. Member updates progress to in_progress with output data
        $this->actingAs($this->member)->put(route('tasks.work.update', $task), [
            'progress' => 50,
            'output' => [
                'content_text' => 'Ide konten draft 1',
            ],
        ]);
        $this->assertEquals('in_progress', $task->fresh()->status);
        $this->assertEquals(50, $task->fresh()->progress);

        // 3. Member submits review
        $this->actingAs($this->member)->post(route('tasks.submit-review', $task));
        $this->assertEquals('review', $task->fresh()->status);

        // 4. Owner requests revision with note
        $this->actingAs($this->owner)->post(route('tasks.request-revision', $task), [
            'note' => 'Perbaiki palet warna agar sesuai brand guideline',
        ]);
        $this->assertEquals('revisi', $task->fresh()->status);
        $this->assertDatabaseHas('task_revisions', [
            'task_id' => $task->id,
            'note' => 'Perbaiki palet warna agar sesuai brand guideline',
            'created_by' => $this->owner->id,
        ]);

        // 5. Member submits review again
        $this->actingAs($this->member)->post(route('tasks.submit-review', $task));
        $this->assertEquals('review', $task->fresh()->status);

        // 6. Owner approves task (done)
        $this->actingAs($this->owner)->post(route('tasks.approve', $task));
        $this->assertEquals('done', $task->fresh()->status);
    }
}

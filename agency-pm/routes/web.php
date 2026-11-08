<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskValidationController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Workspace
    Route::get('/workspaces', [WorkspaceController::class, 'index'])->name('workspaces.index');
    Route::get('/workspaces/create', [WorkspaceController::class, 'create'])->name('workspaces.create');
    Route::post('/workspaces', [WorkspaceController::class, 'store'])->name('workspaces.store');

    Route::middleware('workspace.member')->group(function () {
        Route::get('/workspaces/{workspace}', [WorkspaceController::class, 'show'])->name('workspaces.show');
        Route::post('/workspaces/{workspace}/members', [WorkspaceController::class, 'addMember'])->name('workspaces.members.store');
        Route::delete('/workspaces/{workspace}/members/{member}', [WorkspaceController::class, 'removeMember'])->name('workspaces.members.destroy');

        // Project (nested di bawah workspace)
        Route::get('/workspaces/{workspace}/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/workspaces/{workspace}/projects', [ProjectController::class, 'store'])->name('projects.store');
    });

    // Project detail & task (otorisasi dicek manual via workspace di controller)
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    Route::get('/projects/{project}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');

    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::put('/tasks/{task}/work', [TaskController::class, 'updateWork'])->name('tasks.work.update');
    Route::post('/tasks/{task}/submit-review', [TaskController::class, 'submitReview'])->name('tasks.submit-review');

    Route::post('/tasks/{task}/approve', [TaskValidationController::class, 'approve'])->name('tasks.approve');
    Route::post('/tasks/{task}/request-revision', [TaskValidationController::class, 'requestRevision'])->name('tasks.request-revision');
});

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Home;
use App\Http\Livewire\Tags;
use App\Http\Livewire\Skills;
use App\Http\Livewire\Clients;
use App\Http\Livewire\Contacts;
use App\Http\Livewire\Users;
use App\Http\Livewire\Projects;
use App\Http\Livewire\TaskGroups;
use App\Http\Livewire\Tasks;
use App\Http\Livewire\TimeEntries;
use App\Http\Livewire\Comments;
use App\Http\Livewire\Holidays;
use App\Http\Livewire\Documents;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Home::class);

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {

    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');

    /**
     * TAGS
    */
    Route::prefix('/tags')->name('settings.tags.')->group(function () {
        Route::get('/', Tags\Index::class)->name('index');
        Route::get('/add', Tags\Add::class)->name('create');
        Route::get('{tag}/edit', Tags\Edit::class)->name('edit');
    });

    /**
     * SKILLS
    */
    Route::prefix('/skills')->name('settings.skills.')->group(function () {
        Route::get('/', Skills\Index::class)->name('index');
        Route::get('/add', Skills\Add::class)->name('create');
        Route::get('{skill}/edit', Skills\Edit::class)->name('edit');
    });

    /**
     * CLIENTS
    */
    Route::prefix('/clients')->name('clients.')->group(function () {
        Route::get('/', Clients\Index::class)->name('index');
        Route::get('/add', Clients\Add::class)->name('create');
        Route::get('{client}/edit', Clients\Edit::class)->name('edit');
        Route::get('{client}/show', Clients\Show::class)->name('show');
    });

    /**
     * CONTACTS
    */
    Route::prefix('/contacts')->name('contacts.')->group(function () {
        Route::get('/', Contacts\Index::class)->name('index');
        Route::get('/add', Contacts\Add::class)->name('create');
        Route::get('/{contact}/edit', Contacts\Edit::class)->name('edit');
        Route::get('/{contact}/show', Contacts\Show::class)->name('show');
    });

    /**
     * PROJECTS
    */
    Route::prefix('/projects')->name('projects.')->group(function () {
        Route::get('/', Projects\Index::class)->name('index');
        Route::get('/add', Projects\Add::class)->name('create');
        Route::get('/{project}/edit', Projects\Edit::class)->name('edit');
        Route::get('/{project}/show', Projects\Show::class)->name('show');
    });

    /**
     * TASK GROUPS
    */
    Route::prefix('/task-groups')->name('task_groups.')->group(function () {
        Route::get('/', TaskGroups\Index::class)->name('index');
        Route::get('/add', TaskGroups\Add::class)->name('create');
        Route::get('/{taskGroup}/edit', TaskGroups\Edit::class)->name('edit');
        Route::get('/{taskGroup}/show', TaskGroups\Show::class)->name('show');
    });

    /**
     * TASKS
    */
    Route::prefix('/tasks')->name('tasks.')->group(function () {
        Route::get('/', Tasks\Index::class)->name('index');
        Route::get('/add', Tasks\Add::class)->name('create');
        Route::get('/{task}/edit', Tasks\Edit::class)->name('edit');
        Route::get('/{task}/show', Tasks\Show::class)->name('show');
    });
    
    /**
     * TIME ENTRIES
    */
    Route::prefix('/time-entries')->name('time_entries.')->group(function () {
        Route::get('/', TimeEntries\Index::class)->name('index');
        Route::get('/add', TimeEntries\Add::class)->name('create');
        Route::get('/{timeEntry}/edit', TimeEntries\Edit::class)->name('edit');
    });

    /**
     * COMMENTS
    */
    Route::prefix('/comments')->name('comments.')->group(function () {
        Route::get('/', Comments\Index::class)->name('index');
        Route::get('/add', Comments\Add::class)->name('create');
        Route::get('/{comment}/edit', Comments\Edit::class)->name('edit');
    });

    /**
     * USERS
    */
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', Users\Index::class)->name('index');
        Route::get('/add', Users\Add::class)->name('create');
        Route::get('/{user}/edit', Users\Edit::class)->name('edit');
        Route::get('/{user}/show', Users\Show::class)->name('show');
    });

    /**
     * HOLIDAYS
    */
    Route::prefix('/holidays')->name('holidays.')->group(function () {
        Route::get('/', Holidays\Index::class)->name('index');
        Route::get('/add', Holidays\Add::class)->name('create');
        Route::get('/{holiday}/edit', Holidays\Edit::class)->name('edit');
    });

    /**
     * DOCUMENTS
    */
    Route::prefix('/documents')->name('documents.')->group(function () {
        Route::get('/', Documents\Index::class)->name('index');
        Route::get('/add', Documents\Add::class)->name('create');
        Route::get('/{document}/edit', Documents\Edit::class)->name('edit');
    });
});

<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Unauthenticated group
Route::group([], function () {
    Route::post('/create', [AccountController::class, 'postCreate'])->name('account-create-post');
    Route::post('/sign-in', [AccountController::class, 'postSignIn'])->name('account-sign-in-post');
    Route::post('/student-registration', [StudentController::class, 'postRegistration'])->name('student-registration-post');
});

Route::get('/', [AccountController::class, 'getSignIn'])->name('account-sign-in');
Route::get('/create', [AccountController::class, 'getCreate'])->name('account-create');
Route::get('/student-registration', [StudentController::class, 'getRegistration'])->name('student-registration');

Route::get('/book', [BooksController::class, 'searchBook'])->name('search-book');

// Main books Controlller left public so that it could be used without logging in too
Route::resource('/books', BooksController::class);

// Authenticated group
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/add-books', [BooksController::class, 'renderAddBooks'])->name('add-books');
    Route::get('/add-book-category', [BooksController::class, 'renderAddBookCategory'])->name('add-book-category');
    Route::post('/bookcategory', [BooksController::class, 'BookCategoryStore'])->name('bookcategory.store');
    Route::get('/all-books', [BooksController::class, 'renderAllBooks'])->name('all-books');
    Route::get('/bookBycategory/{cat_id}', [BooksController::class, 'BookByCategory'])->name('bookBycategory');
    Route::get('/registered-students', [StudentController::class, 'renderStudents'])->name('registered-students');
    Route::get('/students-for-approval', [StudentController::class, 'renderApprovalStudents'])->name('students-for-approval');
    Route::get('/settings', [StudentController::class, 'Setting'])->name('settings');
    Route::post('/setting', [StudentController::class, 'StoreSetting'])->name('settings.store');
    Route::resource('/student', StudentController::class);
    Route::post('/studentByattribute', [StudentController::class, 'StudentByAttribute'])->name('studentByattribute');
    Route::get('/issue-return', [LogController::class, 'renderIssueReturn'])->name('issue-return');
    Route::get('/currently-issued', [LogController::class, 'renderLogs'])->name('currently-issued');
    Route::resource('/issue-log', LogController::class);
    Route::get('/sign-out', [AccountController::class, 'getSignOut'])->name('account-sign-out');
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\WebtvController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [ReaderController::class, 'register']);
Route::post('/login', [ReaderController::class, 'login']);

// Reader routes with auth:sanctum middleware
Route::post('/logout', [ReaderController::class, 'logout'])->middleware('auth:sanctum');
Route::put('/readers/update/{id}', [ReaderController::class, 'updateReader'])->middleware('auth:sanctum');
Route::delete('/readers/delete/{id}', [ReaderController::class, 'deleteReader'])->middleware('auth:sanctum');

// Webtv routes
Route::get('/webtvs', [WebtvController::class, 'getWebtvs']); // tested
Route::get('/webtv/id/{id}', [WebtvController::class, 'getWebtvById']); // tested
Route::get('/webtv/category/{categorie}', [WebtvController::class, 'getWebtvByCategory']); // tested

// Event routes  
Route::get('/events', [EventController::class, 'getEvents']); // tested
Route::get('/event/id/{id}', [EventController::class, 'getEventById']); // tested
Route::get('/event/category/{categorie}', [EventController::class, 'getEventByCategory']); // tested
Route::get('/event/recent', [EventController::class, 'getRecentEvents']); // tested
Route::get('/event/comming', [EventController::class, 'getCommingEvents']); // tested
Route::get('/event/past', [EventController::class, 'getPastEvents']); // tested


// Post routes
Route::get('/posts', [PostController::class, 'getPosts']); // tested
Route::get('/post/id/{id}', [PostController::class, 'getPostById']); // tested
Route::get('/post/category/{categorie}', [PostController::class, 'getPostByCategory']); // tested
Route::get('/post/recent', [PostController::class, 'getRecentPosts']); // tested

// Comment routes
Route::post('/comment/new', [CommentController::class, 'addComment'])->middleware('auth:sanctum'); // tested4

// Categorie routes
Route::get('/categories', [CategorieController::class, 'getCategories']); // tested


// Newsletter routes
Route::post('/newsletter', [NewsletterController::class, 'subscribe']); // tested
Route::delete('/newsletter', [NewsletterController::class, 'unsubscribe']); // tested

// Contact routes
Route::post('/contact', [ContactController::class, 'storeContact']); // tested
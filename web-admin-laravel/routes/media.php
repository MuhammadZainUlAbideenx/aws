<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('customers/profile_images/{path}', function ($path)
{
  $path = public_path('customers/profile_images/'.$path);
  if (!File::exists($path)) {
    abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
});

Route::get('customers/reviews_images/{path}', function ($path)
{
  $path = public_path('customers/reviews_images/'.$path);
  if (!File::exists($path)) {
    abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
});
Route::get('admins/profile_images/{path}', function ($path)
{
  $path = public_path('admins/profile_images/'.$path);
  if (!File::exists($path)) {
    abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
});

Route::get('vendors/profile_images/{path}', function ($path)
{
  $path = public_path('vendors/profile_images/'.$path);
  if (!File::exists($path)) {
    abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
});
Route::get('riders/profile_images/{path}', function ($path)
{
  $path = public_path('riders/profile_images/'.$path);
  if (!File::exists($path)) {
    abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
});
Route::get('static_images/{path}', function ($path)
{
  $path = public_path('static_images/'.$path);
  if (!File::exists($path)) {
    abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
});

Route::get('media/{type}/thumbnails/{filename}', function ($type, $filename)
{
  $path = public_path('media/'.$type. '/thumbnails'.'/' . $filename);
  if (!File::exists($path)) {
    abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
});
Route::get('flags/png100px/{filename}', function ($filename)
{
  $path = public_path('flags/png100px/'. $filename);
  if (!File::exists($path)) {
    abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
});
Route::get('media/{type}/{filename}', function ($type, $filename)
{
  $path = public_path('media/'.$type.'/' . $filename);
  if (!File::exists($path)) {
    abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
});

Route::get('media/samplecsv/{filename}', function ($filename)
{
  $path = public_path('import_sample_csv'.'/' . $filename);
  if (!File::exists($path)) {
    abort(404);
  }

  $file = File::get($path);
  $type = File::mimeType($path);

  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);

  return $response;
});

<?php

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

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');;

// Desactivadas para activar la ruta de Steam
// Auth::routes();

Route::get('/login', 'AuthController@login')->name('login');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'frecuencias'], function() {
	Route::get('/', 'FrequencyController@index')->name('frequencies');
	Route::post('/regenerar', 'FrequencyController@generate')->name('frequencies_new');
});

Route::group(['prefix' => 'ajustes'], function() {
	Route::get('/', 'SettingsController@settings')->name('settings');
	Route::post('/', 'SettingsController@saveSettings');
	Route::post('/correo', 'SettingsController@emailSettings')->name('email-settings');
});


//Route::group(['prefix' => 'post'], function() {
//	Route::get('/new', 'PostController@newForm');
//	Route::post('/new', 'PostController@newPost');
//});

Route::group(['prefix' => 'comunicado'], function() {
	Route::get('/{id}', 'PostController@viewPost')->name('post');
	Route::get('/', 'PostController@listPosts')->name('posts');
});

Route::get('/lista', 'UserController@users')->name('users');

Route::group(['prefix' => 'usuario'], function() {
	Route::get('/{id}', 'UserController@profile')->name('user_profile');
});

Route::get('/about', 'HomeController@about')->name('about');


Route::group(['prefix' => 'admin', 'middleware' => ['admin_only', 'auth']], function() {
	CRUD::resource('user', 'Admin\UserCrudController');
	CRUD::resource('specialty', 'Admin\SpecialtyCrudController');
	CRUD::resource('post', 'Admin\PostCrudController');
	CRUD::resource('badge', 'Admin\BadgeCrudController');
	CRUD::resource('badgegrant', 'Admin\BadgeGrantCrudController');
});

Route::group(['prefix' => 'especializacion'], function() {
	Route::get('/', 'SpecialtyController@listSpecialties')->name('specialties');
	Route::get('/{id}', 'SpecialtyController@view')->name('specialty-view');
});

Route::get('/freq/new', 'FrequencyController@generate')->name('freq-new');

Route::group(['prefix' => 'ticket'], function() {
	Route::get('/nuevo/{id?}', 'TicketController@newTicket')->name('ticket_new');
	Route::post('/nuevo/{id?}', 'TicketController@newTicketPost');
	Route::get('/{id}', 'TicketController@viewTicket')->name('ticket');
	Route::post('/{id}/respuesta', 'TicketController@newReply')->name('ticket_reply');
	Route::post('/{id}/cerrar', 'TicketController@closeTicket')->name('ticket_close');
	Route::post('/{id}/abrir', 'TicketController@openTicket')->name('ticket_open');
});

Route::group(['prefix' => 'tickets'], function() {
	Route::get('/', 'TicketController@listTickets')->name('tickets');
	Route::get('/cerrados', 'TicketController@listClosedTickets')->name('tickets_closed');
	Route::get('/mios', 'TicketController@listUserTickets')->name('my_tickets');
});

Route::group(['prefix' => 'condecoraciones'], function() {
	Route::get('/', 'BadgeController@listBadges')->name('badges');
	Route::get('/{id}', 'BadgeController@viewBadge')->name('badge');
});

Route::group(['prefix' => 'api'], function() {
	Route::get('/users/search/input', 'UserController@searchInput')->name('api_user_search_input');
	Route::get('/frequencies/ems/{key}', 'FrequencyController@emsApi')->name('api_frequency_ems');
	Route::get('/frequencies/check', 'FrequencyController@checkApi')->name('api_frequency_check');
});

// DEBUG
Route::get('/debug', function() {
	abort('403');
	
	

	$freq = new \App\Frequency;
	$freq->content = [];
	$freq->save();

	return redirect('/home');
});


/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/
Route::get('{page}/{subs?}', ['uses' => 'PageController@index'])
    ->where(['page' => '^((?!admin).)*$', 'subs' => '.*']);
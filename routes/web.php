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

use App\User;

Route::get('/', function () {

    $users = User::all();
    $data['users'] = $users;
    return view('welcome', $data);
});

Route::get('/put-db', function () {

    config()->set("dblist.12700180010", [
        "database" => "test10",
        "username" => "debian-sys-maint",
        "password" => "G0H7Xru852X3zl3a",
    ]);

    $dblist = config('dblist');

    // $object = json_decode(json_encode($dblist), true);

    $dblist = (object) $dblist;

    $text = '<?php return ' .  var_export($dblist, true) . ';';

    file_put_contents(config_path('dblist.php'), $text);
});

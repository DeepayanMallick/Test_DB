<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class SetDatabaseController extends Controller
{

    private $responseStatus = [

        'status' => [

            'success' => true,

            'code' => 200,

            'message' => '',

        ]

    ];

    private $token;


    public function __construct()
    {
        $this->token = "TJYPYDTB44iHyDMGH2HjPzgwA33hu41Qsf3FTKjGAQQfiRiisgiBV5MBg2IQ";
    }


    // Returns the response with only status key

    public function sendResponseStatus($isSuccess = true, $statusCode = 200, $message = [])

    {

        $this->responseStatus['status']['success'] = $isSuccess;

        $this->responseStatus['status']['code'] = $statusCode;

        $this->responseStatus['status']['message'] = $message;

        $json = $this->responseStatus;

        return response()->json($json, $this->responseStatus['status']['code']);
    }


    public function store(Request $request)
    {

        $host_name = $request->host_name;
        $database = $request->database;
        $username = $request->username;
        $password = $request->password;
        $token = $request->token;


        if (empty($_GET['token'])) {
            return $this->sendResponseStatus(false, 401, 'Token must not be empty.');
        }

        if ($token != $this->token) {
            return $this->sendResponseStatus(false, 401, 'Token not valid.');
        }

        if (empty($_GET['host_name'])) {
            return $this->sendResponseStatus(false, 401, 'Host Name must not be empty.');
        }
        if (empty($_GET['database'])) {
            return $this->sendResponseStatus(false, 401, 'Database must not be empty.');
        }
        if (empty($_GET['username'])) {
            return $this->sendResponseStatus(false, 401, 'Username must not be empty.');
        }
        if (empty($_GET['password'])) {
            return $this->sendResponseStatus(false, 401, 'Password must not be empty.');
        }

        $current_dblist = config('dblist');

        if (array_key_exists($host_name, $current_dblist)) {
            return $this->sendResponseStatus(true, 401, ['host_name already exits']);
        } else {
            config()->set("dblist.$host_name", [
                "database" => $database,
                "username" => $username,
                "password" => $password,
            ]);

            $new_dblist = config('dblist');

            $text = '<?php return ' .  var_export($new_dblist, true) . ';';

            file_put_contents(config_path('dblist.php'), $text);

            return $this->sendResponseStatus(true, 201, ['Database credential stored successfully.']);
        }
    }
}

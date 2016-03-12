<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Get the login email to be used by the controller.
     *
     * @return string
     */
    public function loginEmail()
    {
        return property_exists($this, 'email') ? $this->email : 'email';
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                "meta" => [
                    "code" => "550",
                    "error" => "register failed"
                ],
                "data" => [
                    "regInfo" => $validator->getMessageBag()
                ]
            ]);
        }

        $regInfo = $this->create($request->all());
        return response()->json([
            "meta" => [
                "code" => "200"
            ],
            "data" => [
                "regInfo" => $regInfo
            ]
        ]);
    }

//    /**
//     * Show the application login form.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function getLogin()
//    {
//        return response()->json([
//            "meta" => [
//                "code" => "200"
//            ],
//            "data" => [
//                "_token"=> csrf_token()
//            ]
//        ]);
//    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $validator =  $this->validate($request, [
            $this->loginEmail() => 'required', 'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "meta" => [
                    "code" => "550",
                    "error" => "email and password are required"
                ],
                "data" => [
                    "regInfo" => $validator->getMessageBag()
                ]
            ]);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            $lockout = $this->sendLockoutResponse($request);
            return response()->json([
                "meta" => [
                    "code" => "551",
                    "error" => "too many login attempts"
                ],
                "data" => [
                    "lockout" => $lockout
                ]
            ]);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $logInfo = $this->handleUserWasAuthenticated($request, $throttles);
            return response()->json([
                "meta" => [
                    "code" => "200"
                ],
                "data" => [
                    "logInfo" => $logInfo
                ]
            ]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }
        $logInfo =  $request->only($this->loginUsername(), 'remember');
        return response()->json([
            "meta" => [
                "code" => "552",
                "error" => "email or password not right"
            ],
            "data" => [
                "logInfo" => $logInfo
            ]
        ]);

    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return void
     *
     * @throws \Illuminate\Http\Exception\HttpResponseException
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        return $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }
        return Auth::user();
        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }
    }



    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        Auth::logout();

        return response()->json([
            "meta" => [
                "code" => "200"
            ],
            "data" => (object)Array()
        ]);
    }
}

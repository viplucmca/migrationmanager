<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Symfony\Component\HttpFoundation\IpUtils;
use Cookie;
use App\Services\ServiceAccountTokenService;

class AdminLoginController extends Controller
{
	use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Show the application’s login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    protected function guard()
	{
        return Auth::guard('admin');
    }


    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
        'email' => 'required|string',
        'password' => 'required|string',
        'g-recaptcha-response' => 'required',
        ]);
    }

	public function authenticated(Request $request, $user)
    {   //dd($request->all());
        //echo "<pre>";print_r($request->all());
        //echo "<pre>user==";print_r($user);
        //dd('###');

        $recaptcha_response = $request->input('g-recaptcha-response');//dd($recaptcha_response);
        if (is_null($recaptcha_response)) {
            $errors = ['g-recaptcha-response' => 'Please Complete the Recaptcha to proceed'];
            return redirect()->back()
            ->withErrors($errors);
        }

        $url = "https://www.google.com/recaptcha/api/siteverify";

       //echo "secret===".config('services.recaptcha.secret');
        //echo "<br/>";
       // echo "IpUtils===".IpUtils::anonymize($request->ip());
        //die('@@@');
        $body = [
            'secret' => config('services.recaptcha.secret'),
            'response' => $recaptcha_response,
            'remoteip' => IpUtils::anonymize($request->ip()) //anonymize the ip to be GDPR compliant. Otherwise just pass the default ip address
        ];

        $response = Http::get($url, $body); //dd($response);
        $result = json_decode($response); //dd($result);

        if ($response->successful() && $result->success == true) { //dd('ifff');
            //$request->authenticate();

            //$request->session()->regenerate();

            if(!empty($request->remember)) {
                \Cookie::queue(\Cookie::make('email', $request->email, 3600));
                \Cookie::queue(\Cookie::make('password', $request->password, 3600));
            } else {
                \Cookie::queue(\Cookie::forget('email'));
                \Cookie::queue(\Cookie::forget('password'));
            }

            $obj = new \App\UserLog;
            $obj->level = 'info';
            $obj->user_id = @$user->id;
            $obj->ip_address = $request->getClientIp();
            $obj->user_agent = $_SERVER['HTTP_USER_AGENT'];
            $obj->message = 'Logged in successfully';
            $obj->save();

            // Generate service account token in background
            try {
                $tokenService = new ServiceAccountTokenService();
                // Pass the actual login password
                $loginPassword = $request->password;
                
                \Log::info('Starting token generation on login', [
                    'admin_id' => $user->id,
                    'admin_email' => $user->email,
                    'password_length' => strlen($loginPassword)
                ]);
                
                $result = $tokenService->generateTokenSync($user, null, null, $loginPassword);
                if ($result) {
                    \Log::info('Token generated successfully on login', [
                        'admin_id' => $user->id,
                        'admin_email' => $user->email,
                        'token' => $result['token'] ?? 'N/A'
                    ]);
                } else {
                    \Log::error('Token generation failed on login', [
                        'admin_id' => $user->id,
                        'admin_email' => $user->email
                    ]);
                }
                // Also dispatch background job for future use with password
                $tokenService->generateTokenInBackground($user, null, null, $loginPassword);
            } catch (\Exception $e) {
                // Log error but don't interrupt the login process
                \Log::error('Failed to generate token on admin login', [
                    'admin_id' => $user->id,
                    'admin_email' => $user->email,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }

            return redirect()->intended($this->redirectPath());
        } else { //dd('elsee');
            //return redirect()->back()->with('status', 'Please Complete the Recaptcha Again to proceed');
            $errors = ['g-recaptcha-response' => 'Please Complete the Recaptcha Again to proceed'];
            return redirect()->back()->withErrors($errors);
        }
    }

	 protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        // Load user from database
        $user = \App\User::where($this->username(), $request->{$this->username()})->first();

        if ($user && !\Hash::check($request->password, $user->password)) {
            $errors = ['password' => 'Wrong password'];
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
		$obj = new \App\UserLog;
		$obj->level = 'critical';
		$obj->user_id = @$user;
		$obj->ip_address = $request->getClientIp();
		$obj->user_agent = $_SERVER['HTTP_USER_AGENT'];
		$obj->message = 'Invalid Email or Password !';
		$obj->save();
        return redirect()->back()->withInput($request->only($this->username(), 'remember'))->withErrors($errors);
    }

	public function logout(Request $request)
    {
		$user = $request->id;

		$obj = new \App\UserLog;
		$obj->level = 'info';
		$obj->user_id = @$user;
		$obj->ip_address = $request->getClientIp();
		$obj->user_agent = $_SERVER['HTTP_USER_AGENT'];
		$obj->message = 'Logged out successfully';
		$obj->save();
		Auth::guard('admin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();

		return redirect('/admin');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use App\Models\Utility;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Runner\Exception;
use Shei\AwsMarketplaceTools\Models\AwsCustomer;
use Shei\AwsMarketplaceTools\Models\AwsSubscription;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class AwsMarketplaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function show () {
        return view("aws.register");
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function register (Request $request) {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                "customer_id" => "required|string|max:255"
            ]);

            $awsUser = AwsCustomer::where("customer_id", $request->customer_id)->first();
            if (!$awsUser) {
                throw new \Exception("Could not find your associated aws account. Please set up your account through aws or through the app");
            }

            Log::debug("Aws Customer Found");
            $awsSubscription = AwsSubscription::where("aws_customer_id", $awsUser->id)->latest()->first();
            if (!$awsSubscription) {
                throw new \Exception("Could not find an active subscription for your account");
            }
            Log::debug("Aws Customer Subscription Found");
            //Fetch Plan
            $plan = Plan::where("name", $awsSubscription->dimension)->first();
            if (!$plan) {
                throw new \Exception("Something went wrong. PLease contact support");
            }

            //Create new user & Assign PLan
            do {
                $code = rand(100000, 999999);
            } while (DB::table('users')->where('referral_code', $code)->exists());

            if (Utility::getValByName('verification_btn') == 'off') {

                $date = date("Y-m-d H:i:s");
            } else {
                $date = null;
            }


            if (Utility::getValByName('RECAPTCHA_MODULE') == 'yes') {
                $validation['g-recaptcha-response'] = 'required';
            } else {
                $validation = [];
            }
            $this->validate($request, $validation);
            $slug = str_replace(' ', '-', strtolower($request->name));

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => $date,
                'password' => Hash::make($request->password),
                'slug' => $slug,
                'type' => 'Admin',
                'lang' => Utility::getValByName('default_language'),
                'parent' => 1,
                'referral_code'=> $code,
                'referral_used'=> !empty($request->ref_code) ? $request->ref_code : '0',
            ]);
            if (!$user) {
                dd("something went wrong");
            }

            Log::debug("User created successfully");
            AwsCustomer::where("id", $awsUser->id)->update([
                "user_id" => $user->id
            ]);


            Utility::getSMTPDetails(1);
            $adminRole = Role::findByName('Admin');
            $user->assignRole($adminRole);
            $user->userDefaultData();
            $user->assignPlan($plan->id);

            $userDefaultData = Utility::addCustomeField($user->id);
            $userDefaultData = Utility::userDefaultData();

            $user->$userDefaultData;
            $user->userDefaultDataRegister($user->id);

            Log::debug("User updated with aws customer");
            if (Utility::getValByName('verification_btn') == 'on') {
                try {

                    event(new Registered($user));

                    Auth::login($user);
                } catch (\Exception $e) {
                    $user->delete();
                    return redirect('/register')->with('status', __('Email SMTP settings does not configure so please contact to your site admin.'));
                }

            } else {
                $uArr = [
                    'email' => $user->email,
                    'password' => $request->password,
                ];

                Utility::sendEmailTemplate('new_user', [$user->id => $user->email], $uArr, $user->id);
                Auth::login($user);
                return redirect(RouteServiceProvider::HOME);
            }

            if (empty($lang)) {
                $lang = Utility::getValByName('default_language');
            }

            \App::setLocale($lang);

            return view('auth.verify-email', compact('lang'));
        } catch (\Exception $e) {
            dd($e);
            return redirect("/register")->with("error", $e->getMessage());
        }
    }
}

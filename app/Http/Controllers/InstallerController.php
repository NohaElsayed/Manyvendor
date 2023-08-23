<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorRequest;
use App\Mail\NewVendorMail;
use App\Models\Settings;
use App\User;
use App\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Alert;

class InstallerController extends Controller
{
    protected function welcome()
    {
        overWriteEnvFile('APP_URL', URL::to('/').'/public');
        return view('install.welcome');
    }

    // permission
    protected function permission()
    {
        $permission['curl_enabled'] = function_exists('curl_version');
        $permission['db_file_write_perm'] = is_writable(base_path('.env'));
        return view('install.permission', compact('permission'));
    }

    // create
    protected function create()
    {
        return view('install.setup');
    }

    //save database information in env file
    //here the get database key or data for env file
    // clear cache
    protected function dbStore(Request $request)
    {


        foreach ($request->types as $type) {
            //here the get database key or data for env file
            overWriteEnvFile($type, $request[$type]);
        }
        return redirect()->route('check.db');
    }

    // checkDbConnection
    protected function checkDbConnection()
    {
        try {
            //check the database connection for import the sql file
            DB::connection()->getPdo();
            return redirect()->route('sql.setup')->with('success', 'Your database connection setup has been successful.');
        } catch (\Exception $e) {
            return redirect()->route('sql.setup')->with('wrong', 'Could not connect to the database. Please check your configuration');

        }
    }


    //import sql page
    protected function importSql()
    {
        return view('install.importSql');
    }

    //import the sql file in database or goto organization setup page
    protected function sqlUpload()
    {
        try {
            $sql_path = base_path('install.sql');
            DB::unprepared(file_get_contents($sql_path)); // uploaded sql
            return view('install.activeApp');
        } catch (\Exception $e) {
            die("Something is not appropriate!, Please check your configuration. error:" . $e);
        }
    }


    protected function sqlUploadDemo()
    {
       try {
            //import the sql file in database
            $sql_path = base_path('demo.sql');
            DB::unprepared(file_get_contents($sql_path)); // uploaded sql
            return view('install.activeApp');
       } catch (\Exception $e) {
           die("Something is not appropriate!, Please check your configuration. error:" . $e);
       }
    }


    /*active apps */
    protected function activeAppStore(Request $request)
    {
        foreach ($request->types as $type) {
            //here the get database key or data for env file
            overWriteEnvFile($type, $request[$type]);

        }


        if (!Schema::hasTable('verify_users')) {

                Schema::create('verify_users', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('user_id');
                    $table->string('token');
                    $table->timestamps();
                });

                \Artisan::call('optimize:clear');
            }

        
        return view('install.setupOrg');
    }

    protected function vendor_store(VendorRequest $request)
    {

        $password_generate = '12345678';
        $slug = Str::slug($request->name);

        $seller_as_user = new User();
        $seller_as_user->name = $request->name;
        $seller_as_user->email = $request->email;
        $seller_as_user->genders = $request->genders;
        $seller_as_user->password = bcrypt($password_generate);
        $seller_as_user->nationality = $request->nationality;
        $seller_as_user->slug = $slug;

        $person = User::where('slug', $slug)->get();
        if ($person->count() > 0) {
            $slug1 = $slug . ($person->count() + 1);
        } else {
            $slug1 = $slug;
        }

        $seller_as_user->user_type = 'Vendor';
        $seller_as_user->created_at = Carbon::now();
        $seller_as_user->save();

        /*assign group*/
        $seller_as_user->assignGroup(3);

        $seller_create = new Vendor();
        $seller_create->shop_name = $request->shop_name;
        $seller_create->name = $request->name;
        $seller_create->email = $request->email;
        $seller_create->phone = $request->phone;
        $seller_create->trade_licence = $request->trade_licence;
        $seller_create->address = $request->address;
        $seller_create->about = $request->about;
        $seller_create->facebook = $request->facebook;
        $seller_create->approve_status = 1;
        $seller_create->user_id = $seller_as_user->id;
        $seller_create->slug = Str::slug($request->shop_name);

        if ($request->hasFile('shop_logo')) {
            $seller_create->shop_logo = fileUpload($request->shop_logo, 'shop_logo');
        }

        $seller_create->save();
        try {
            Mail::to($request->email)->send(new NewVendorMail($password_generate));
        } catch (\Exception $exception) {
        }

        return view('install.setupOrg');
    }

    //store the organization details in db
    protected function orgSetup(Request $request)
    {
        if ($request->hasFile('logo')) {
            $system = Settings::where('name', $request->type_logo)->first();
            $system->value = fileUpload($request->logo, 'site');
            $system->save();
        }
        if ($request->has('f_logo')) {
            $system = Settings::where('name', $request->footer_logo)->first();
            $system->value = fileUpload($request->f_logo, 'site');
            $system->save();
        }
        if ($request->has('f_icon')) {
            $system = Settings::where('name', $request->favicon_icon)->first();
            $system->value = fileUpload($request->f_icon, 'site');
            $system->save();
        }
        if ($request->has('name')) {
            $system = Settings::where('name', $request->type_name)->first();
            $system->value = $request->name;
            $system->save();
            overWriteEnvFile('APP_NAME', $request->name);
        }
        if ($request->has('footer')) {
            $system = Settings::where('name', $request->type_footer)->first();
            $system->value = $request->footer;
            $system->save();
        }
        if ($request->has('fb')) {
            $system = Settings::where('name', $request->type_fb)->first();
            $system->value = $request->fb;
            $system->save();
        }
        if ($request->has('tw')) {
            $system = Settings::where('name', $request->type_tw)->first();
            $system->value = $request->tw;
            $system->save();
        }
        if ($request->has('google')) {
            $system = Settings::where('name', $request->type_google)->first();
            $system->value = $request->google;
            $system->save();
        }
        if ($request->has('address')) {
            $system = Settings::where('name', $request->type_address)->first();
            $system->value = $request->address;
            $system->save();
        }
        if ($request->has('number')) {
            $system = Settings::where('name', $request->type_number)->first();
            $system->value = $request->number;
            $system->save();
        }
        if ($request->has('mail')) {
            $system = Settings::where('name', $request->type_mail)->first();
            $system->value = $request->mail;
            $system->save();
        }

        return redirect()->route('admin.create');
    }

    //admin create page
    protected function adminCreate()
    {
        return view('install.user');
    }

    //create a admin with full access
    //save and add the super access permission
    //replace the RouteService provider when installation is done
    //return the dashboard when all is done
    protected function adminStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ],
            [
                'name.required' => translate('Name is required'),
                'name.unique' => translate('Name already exist'),
                'email.required' => translate('Email is required'),
                'email.email' => translate('invalid email'),
                'email.unique' => translate('Email already exist'),
                'password.unique' => translate('Password is required'),
                'password.min' => translate('Password must have minimum 8 characters'),
                'password.confirmed' => translate('Password did not matched'),
            ]
        );

        //create admin and hash password
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = 'Admin';
        $user->password = Hash::make($request->password);
        $user->email_verified_at = Carbon::now();

        //slug save
        $user->slug = Str::slug($request->name);

        
        $response = $request->purchase_key;

        if($response == "babiato.co"){
            if ($user->save()) {
                $user->assignGroup(1);
                overWriteEnvFile('MIX_PUSHER_APP_CLUSTER_SECURE', '7469a286259799e5b37e5db9296f00b3');
                //replace the env file
                $se = Str::before(env('APP_URL'), '/public');
                overWriteEnvFile('APP_URL', $se);
                return view('install.done');
            } else {
                return redirect()->back()->with('failed', translate('Something is not appropriate! Try again.'));
            }
        }else{
            return redirect()->back()->with('babiato', "You inserted a wrong purchase code, Please visit babiato for a valid code");
        }
    }
}

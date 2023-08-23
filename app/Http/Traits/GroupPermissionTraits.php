<?php


namespace App\Http\Traits;

use App\Mail\MailPassword;
use App\Mail\NewVendorMail;
use App\Models\GroupHasPermission;
use App\Models\Module;
use App\Models\ModuleHasPermission;
use App\Models\UserHasGroup;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Junges\ACL\Http\Models\Group;
use Junges\ACL\Http\Models\Permission;

trait GroupPermissionTraits
{

    private  $privateGroupsID = array(2,3,5);
    private $privatePermissionID = array(110,111,114,118);
    private  $privateModuleID = array(7,8,10,11);
    //users
    public function userIndex(Request  $request)
    {
        if ($request->search != null){
            $users = User::where('email','LIKE','%'.$request->search.'%')->where('user_type','Admin')->get();
        }else{
            $users = User::where('user_type','Admin')->with('groups')->get();
        }
        return view('backend.common.users.user.index')->with('users', $users);
    }

    public function userCreate()
    {

        $groups = Group::whereNotIn('id',$this->privateGroupsID)->get();
        return view('backend.common.users.user.create')->with('groups', $groups);
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ],[
            'name.required'=>'Name is required',
            'email.required'=>'Email is required',
            'email.unique'=>'Email must be unique',
            'password.required'=>'Password must be required',
            'password.confirmed'=>'Password or Confirmed Password not match'
        ]);
        $user = new User();
        $user->name = $request->name;
        //slug save
        $slug =Str::slug($request->name);
        $person = User::where('slug',$slug)->get();
        if($person->count() > 0){
            $user->slug = $slug.($person->count()+1);
        }else{
            $user->slug = $slug;
        }
        $user->genders = $request->genders;
        $user->tel_number = $request->tel_number;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $user->password = Hash::make($request->password);


        try {
            $request->password;
            Mail::to($request->email)->send(new MailPassword($request->password));

        }catch (\Exception $exception){}

        if ($user->save()) {
            if ($request->group_id != null) {
                $user->assignGroup($request->group_id);
                return redirect()->back()->with('success', translate('User has been created successfully with Permission.'));
            }


            return redirect()->back()->with('success', translate('User has been Created successfully.'));
        } else {
            return redirect()->back()->with('failed', translate('Something is not appropriate! Try again. '));
        }
    }

    /*user show*/
    public function userShow($id)
    {
        $user = User::where('id', $id)->with('groups')->first();
        return view('backend.common.users.user.show', compact('user'));
    }


    /*user banned*/
    public function userBanned($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->banned == true){
            $user->banned = false;
        }else{
            $user->banned = true;
        }
        $user->save();
        return back()->with('success',translate('This user has been banned.'));
    }

    /*user modify*/
    public function userModify($id){
        $groups = Group::whereNotIn('id',$this->privateGroupsID)->get();
        $user = User::where('id', $id)->with('groups')->first();
        return view('backend.common.users.user.modify', compact('user', 'groups'));
    }

    public function userModifyUpdate(Request $request){
        try {
            $user =User::where('id',$request->id)->first();
            $user->banned = $request->banned;
            $user->save();

            //delete old data form group_has_permission table
            UserHasGroup::where('user_id', $request->id)->delete();
            //after delete add new data in group_has_permission table
            foreach ($request->group_id as $id) {
                $gpc = new UserHasGroup();
                $gpc->group_id = $id;
                $gpc->user_id = $request->id;
                $gpc->save();
            }

            if ($user) {
                return redirect()->back()->with('success', translate('User updated successfully'));
            } else {
                return redirect()->back()->with('error', translate('Something is not appropriate! Try again. '));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('failed', 'Something is not appropriate! Try again. ' . $e);
        }
    }

    /*user edit*/
    public function userEdit()
    {

        //change hare for auth user
        $user = User::where('id', Auth::id())->with('groups')->first();
        return view('backend.common.users.user.edit', compact('user'));

    }

    public function userUpdate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ],[
            'name.required'=>'Name is required',
            'email.required'=>'Email is required',
        ]);
        try {
            $user =User::where('id',Auth::id())->first();
            $user->name = $request->name;
            if($request->hasFile('avatar')){
                $user->avatar = fileUpload($request->avatar,'user');
            }
            $user->genders = $request->genders;
            $user->tel_number = $request->tel_number;

            if ($request->password != null){
                $request->validate([
                    'password' => ['required', 'string', 'confirmed'],
                ],[
                    'password.confirmed'=>'Password confirmation does not match',
                ]);
                $user->password = Hash::make($request->password);
            }

            $user->user_type = $request->user_type;
            $user->save();

            if ($request->group_id != null){
                //delete old data form group_has_permission table
                UserHasGroup::where('user_id', $request->id)->delete();
                //after delete add new data in group_has_permission table
                foreach ($request->group_id as $id) {
                    $gpc = new UserHasGroup();
                    $gpc->group_id = $id;
                    $gpc->user_id = $request->id;
                    $gpc->save();
                }
            }

            if ($user) {
                return redirect()->back()->with('success', translate('User updated successfully'));
            } else {
                return redirect()->back()->with('error', translate('Something is not appropriate! Try again.'));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('failed', 'Something is not appropriate! Try again. ' . $e);
        }

    }


    public function userDestroy($id)
    {
        /*change here auth delete*/
        User::where('id', $id)->delete() && UserHasGroup::where('user_id', $id)->delete();
        return redirect()->back()->with('success', 'User deleted successfully');

    }

    //todo::permission crud
    public function permissionIndex()
    {
        $permissions = Permission::whereNotIn('id',$this->privatePermissionID)->get();
        return view('backend.common.users.permission.index', compact('permissions'));
    }


    public function permissionCreate()
    {
        return view('backend.common.users.permission.create');
    }


    public function permissionStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:permissions', 'max:255'],
        ],[
            'name.required'=>'Name is required',
        ]);
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->slug = Str::slug($request->name, '-');
        $permission->description = $request->description ?? null;
        $permission->save();
        return redirect()->back()->with('success', translate('Permission Created Successfully'));

    }


    public function permissionShow($id)
    {
        try {
            $permission = Permission::where('id', $id)->first();
            return view('backend.common.users.permission.show', compact('permission'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something is not appropriate! Try again. ' . $e);
        }
    }


    public function permissionEdit($id)
    {
        try {
            $permission = Permission::where('id', $id)->first();
            return view('backend.common.users.permission.edit', compact('permission'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something is not appropriate! Try again. ' . $e);
        }
    }


    public function permissionUpdate(Request $request)
    {
        Permission::where('id', $request->id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect()->back()->with('success', translate('Permission Updated Successfully'));
    }


    public function permissionDestroy($id)
    {
        Permission::where('id', $id)->delete();
        return redirect()->back()->with('success', translate('Permission Deleted Successfully'));
    }
    //end permission

    //group
    public function groupIndex()
    {
        $groups = Group::whereNotIn('id',$this->privateGroupsID)->with('permissions')->get();
        return view('backend.common.users.group.index', compact('groups'));
    }


    public function groupCreate()
    {
        $modules = Module::whereNotIn('id',$this->privateModuleID)->with('permissions')->get();

        return view('backend.common.users.group.create', compact('modules'));
    }


    public function groupStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:groups', 'max:255'],
        ],[
            'name.required'=>'Name is required',
        ]);
        $group = new Group();
        $group->name = $request->name;
        $group->slug = Str::slug($request->name, '-');
        $group->description = $request->description ?? null;
        if ($group->save()) {
            if ($request->permission_id != null) {
                $group->assignPermissions($request->permission_id);
                return redirect()->back()->with('success', translate('Group has been created with Permission successfully.'));
            }
            return redirect()->back()->with('success', translate('Group Created Successfully'));
        } else {
            return redirect()->back()->with('error', 'Something is not appropriate! Try again. ');
        }

    }


    public function groupShow($id)
    {

        $group = Group::whereNotIn('id',$this->privateGroupsID)->where('id', $id)->with('permissions')->first();
        return view('backend.common.users.group.show', compact('group'));
    }


    public function groupEdit($id)
    {


        $group = Group::whereNotIn('id',$this->privateGroupsID)->where('id', $id)->with('permissions')->first();

        $modules = Module::whereNotIn('id',$this->privateModuleID)->with('permissions')->get();
        return view('backend.common.users.group.edit', compact('modules', 'group'));
    }


    public function groupUpdate(Request $request)
    {

        try {
            $group = Group::whereNotIn('id',$this->privateGroupsID)->where('id', $request->id)->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-'),
                'description' => $request->description,
            ]);

            //delete old data form group_has_permission table
            GroupHasPermission::where('group_id', $request->id)->delete();
            //after delete add new data in group_has_permission table
            if($request->permission_id != null){
                foreach ($request->permission_id as $id) {
                    $gpc = new GroupHasPermission();
                    $gpc->group_id = $request->id;
                    $gpc->permission_id = $id;
                    $gpc->save();
                }
            }

            if ($group) {
                return redirect()->back()->with('success', translate('Group Updated Successfully'));
            } else {
                return redirect()->back()->with('error', translate('Something is not appropriate! Try again. '));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something is not appropriate! Try again. ' . $e);
        }
    }


    public function groupDestroy($id)
    {
        if (Group::where('id', $id)->delete() && GroupHasPermission::where('group_id', $id)->delete()) {
            return redirect()->back()->with('success', translate('Group Deleted Successfully'));
        } else {
            return redirect()->back()->with('error', 'Something is not appropriate! Try again. ');
        }
    }
    //end group



    /*permission Module*/
    public function moduleIndex(){
        $modules = Module::with('permissions')->get();

        $permissions =Permission::all();
        return view('backend.common.users.module.index',compact('modules','permissions'));
    }

    /*permission store*/
    public function moduleStore(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ],[
            'name.required'=>'Name is required'
        ]);
        $module =new Module();
        $module->name = $request->name;
        $module->save();
        //save the module ways permission
        foreach ($request->p_id as $id){
            $mp = new ModuleHasPermission();
            $mp->permission_id = $id;
            $mp->module_id = $module->id;
            $mp->save();
        }
        return back()->with('success',translate('Module permission has been created successfully.'));
    }

    /*module edit view*/
    public function moduleEdit($id){
        $module = Module::with('permissions')->findOrFail($id);
        $permissions = Permission::all();
        return view('backend.common.users.module.edit',compact('module','permissions'));
    }

    /*module update*/
    public function moduleUpdate(Request $request){
        $request->validate([
            'id'=>'required',
            'name' => ['required', 'string', 'max:255'],
        ],[
            'name.required'=>'Name is required'
        ]);
        $module = Module::findOrFail($request->id);
        $module->name = $request->name;
        $module->save();

        //delete the module permission
        ModuleHasPermission::where('module_id',$request->id)->delete();

        //save the module ways permission
        foreach ($request->p_id as $id){
            $mp = new ModuleHasPermission();
            $mp->permission_id = $id;
            $mp->module_id = $module->id;
            $mp->save();
        }

        return back()->with('success',translate('Module permission updated successfully.'));
    }

    /*module delete view*/
    public function moduleDestroy($id){
        //delete the module permission
        ModuleHasPermission::where('module_id',$id)->delete();
        //delete the module
        Module::where('id',$id)->delete();
        return back()->with('success',translate('Module permission deleted successfully.'));
    }

}

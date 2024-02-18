<?php 
/**
 *
 * @category zStarter
 *
 * @ref zCURD
 * @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\UserLog;
use App\Models\MailSmsTemplate;
use App\Models\UserKyc;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DataTables;
use Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $length = 10;
        if(request()->get('length')){
            $length = $request->get('length');
        }
        $roles = Role::whereIn('id', [3,2])->get()->pluck('name', 'id');
        $users = User::query();
        $users->notRole(['Super Admin'])->where('id', '!=', auth()->id());
        if($request->get('role')){
            $users->role($request->get('role'));
        }
        if($request->get('search')){
            $users->where('name','like','%'.$request->get('search').'%')
                ->orWhere('email','like','%'.$request->get('search').'%')
                ->orWhere('phone','like','%'.$request->get('search').'%');
        }
         
        $users= $users->paginate($length);
        if ($request->ajax()) {
            return view('user.load', ['users' => $users])->render();  
        }
        return view('user.index', compact('roles','users'));  

        return view('user.users', compact('roles'));
    }
    public function print(Request $request){
        $users = collect($request->records['data']);
        return view('user.print', ['users' => $users])->render();  
    }


    public function show($id=null)
    {
        $user = User::whereId($id)->first();
        $user_kyc = UserKyc::whereUserId($id)->first();
        return view('user.show', compact('id', 'user','user_kyc'));
    }


    public function create()
    {
        try {
            $roles = Role::where('id','!=',1)->pluck('name', 'id');
            return view('user.create-user', compact('roles'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
    
    public function userlog($u_id = null, $role=null)
    {
        try {
            $roles = Role::whereIn('id', [3,10])->get()->pluck('name', 'id');
            if ($role == null) {
                $userids  = User::notRole(['Super Admin','Admin'])->pluck('id');
                $user_log = UserLog::where('user_id', $u_id)->get();
            } else {
                $userids  = User::Role($role)->pluck('id');
                $user_log = UserLog::whereIn('user_id', $userids)->get();
            }
            return view('user.user-logs', compact('user_log', 'roles'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        if(Session::has('last_pay_attempt')){
            $last_attempt = Session::get('last_pay_attempt');
            $difference = $last_attempt->diffInMinutes(\Carbon\Carbon::now());
            $seconds = 120-$last_attempt->diffInSeconds(\Carbon\Carbon::now());
            if($difference < 2){
                return redirect()->back()->with('error', "Hold on, Please try after $seconds seconds.")->withInput($request->all());
            }
        }
        Session::put('last_pay_attempt', \Carbon\Carbon::now());
        // create user
        $validator = Validator::make($request->all(), [
            'fname'     => 'required | string ',
            'lname'     => 'required | string ',
            'email'    => 'required | email | unique:users',
            'password' => 'required',
            'role'     => 'required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        
        try {
            // store user information
            $name = $request->fname .''. $request->lname; 
            $user = User::create([
                        'name'     => $name,
                        'email'    => $request->email,
                        'country'    => $request->country,
                        'state'    => $request->state,
                        'city'    => $request->city,
                        'pincode'    => $request->pincode,
                        'address'    => $request->address,
                        'status'    => $request->status,
                        'password' => Hash::make($request->password),
                    ]);

            // assign new role to the user
            $user->syncRoles($request->role);
            $role = $user->roles[0]->name ?? '';
            return redirect()->route('panel.users.index','?role='.$role)->with('success','Record Created Successfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit($id)
    {
        try {
            $user  = User::with('roles', 'permissions')->find($id);

            if ($user) {
                $user_role = $user->roles->first();
                $roles     = Role::where('id','!=',1)->pluck('name', 'id');

                return view('user.user-edit', compact('user', 'user_role', 'roles'));
            } else {
                return redirect('404');
            }
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function update(Request $request, $id)
    {
        
        if(Session::has('last_pay_attempt')){
            $last_attempt = Session::get('last_pay_attempt');
            $difference = $last_attempt->diffInMinutes(\Carbon\Carbon::now());
            $seconds = 120-$last_attempt->diffInSeconds(\Carbon\Carbon::now());
            if($difference < 2){
                return redirect()->back()->with('error', "Hold on, Please try after $seconds seconds.")->withInput($request->all());
            }
        }
        Session::put('last_pay_attempt', \Carbon\Carbon::now());
        $this->validate($request, [
                'name'     => 'required | string ',
                'email'    => 'required | email',
                ]);
        

        $user = User::whereId($id)->first();
        try {
            $user->name=$request->name;
            $user->email=$request->email;
            $user->dob=$request->dob;
            $user->gender=$request->gender;
            $user->country=$request->country;
            $user->state=$request->state;
            $user->city=$request->city;
            $user->pincode=$request->pincode;
            $user->address=$request->address;
            $user->save();
            $user->syncRoles($request->role);
            $role = $user->roles[0]->name ?? '';
            return redirect()->route('panel.users.index','?role='.$role)->with('success', 'User information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request, $id)
    {
        $this->validate($request, [
                'name'     => 'required | string ',
                'email'    => 'required | email',
                'phone'    => 'required | min:10',
            ]);
        

        $user = User::whereId($id)->first();
        try {
            $user->name=$request->name;
            $user->email=$request->email;
            $user->timezone=$request->timezone;
            $user->language=$request->language;
            $user->dob=$request->dob;
            $user->gender=$request->gender;
            $user->country=$request->country;
            $user->phone=$request->phone;
            $user->state=$request->state;
            $user->city=$request->city;
            $user->pincode=$request->pincode;
            $user->address=$request->address;
            $user->email_verified_at=$request->email_verified_at;
            $user->is_verified=$request->is_verified;
            $user->save();

            return redirect()->back()->with('success', 'User information updated succesfully!');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
    public function updateUserPassword(Request $request, $id)
    {
        // return $id;
        $request->validate([
            'password' => 'required | confirmed ',
            'password' => ' required | min:6',
        ]);

        if ($request->password !== $request->confirm_password) {
            return back()->with('error', 'Password and confirm password don\'t match !');
        }
        try {
            User::find($id)->update([
                'password' => Hash::make($request->password),
            ]);
            return back()->with('success', 'Your password updated successfully !');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }

    }

    public function updateProfileImage(Request $request, $id)
    {
        $user = User::findOrFail($id);

        try {
            if ($request->hasFile('avatar')) {
                if ($user->avatar != null) {
                    unlinkfile(storage_path() . '/app/public/backend/users', $user->avatar);
                }
                $image = $request->file('avatar');
                $path = storage_path() . '/app/public/backend/users/';
                $imageName = 'profile_image_' . $user->id.rand(000, 999).'.' . $image->getClientOriginalExtension();
                $image->move($path, $imageName);
                $user->avatar=$imageName;
            } else {
                return back()->with('error', 'Please select an image to upload!');
            }
            $user->update(['avatar' => $imageName]);
            return back()->with('success', 'Profile image updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required | confirmed ',
            'password' => ' required | min:6',
        ]);

        if ($request->password !== $request->confirm_password) {
            return back()->with('error', 'Password and confirm password don\'t match !');
        }
        try {
            User::find($id)->update([
                'password' => Hash::make($request->password),
            ]);
            return back()->with('success', 'Your password updated successfully !');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function loginAs($id)
    {
        try {
            if ($id == auth()->id()) {
                return back()->with('error', 'Do not try to login as yourself.');
            } else {
                $user   = User::find($id);

                
                session(['admin_user_id' => auth()->id()]);
                session(['temp_user_id' => $user->id]);
                auth()->logout();
                
                // Login.
                auth()->loginUsingId($user->id);
    
                // Redirect.
                if(AuthRole() == 'User'){
                    return redirect(route('customer.profile'));
                }else{
                    return redirect(route('panel.dashboard'));
                }
                // return redirect(route('customer.account'));
            }
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    

    public function dashboard()
    {
        if(getSetting('sms_verify') && auth()->user()->isverified){
            return redirect()->route('sms.verify')->with(['phone' => auth()->user()->phone]);
        }elseif(getSetting('email_verify') && auth()->user()->email_verified_at == null){
            return redirect()->route('verification.notice');
        }else{
            return view('pages.dashboard');
        }
    }
    public function status($id, $s)
    {
        try {
            $user   = User::find($id);
            $user->update(['status' => $s]);
            $role = $user->roles[0]->name ?? '';
            return redirect()->route('panel.users.index','?role='.$role)->with('success', 'User status Updated!');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function updateEkycStatus(Request $request)
    {  
        // return $request->all();  
        $user = UserKyc::whereUserId($request->user_id)->firstOrFail();
            $ekyc_info = json_decode($user->details,true);

        if(is_null($ekyc_info)){
            abort(404);
        }
        $new_ekyc_info = [
            'document_type' => $ekyc_info['document_type'],
            'document_number' => $ekyc_info['document_number'],
            'document_front' => $ekyc_info['document_front'],
            'document_back' => $ekyc_info['document_back'],
            'admin_remark' => $request['remark'],
        ];   

        $new_ekyc_info = json_encode($new_ekyc_info);

        if($request->status == 1){
            $mailcontent_data = MailSmsTemplate::where('code','=',"Verified-KYC")->first();
            if($mailcontent_data){
                $arr=[
                    '{id}'=> $user->id,
                    '{name}'=>NameById( $user->id),
                ];
                $action_button = null;
                TemplateMail($user->name,$mailcontent_data,$user->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
            }
            $onsite_notification['user_id'] =  $user->id;
            $onsite_notification['title'] = "KYC accepted";
            $onsite_notification['link'] = route('customer.profile')."?active=account";
            $onsite_notification['notification'] = 'Your KYC has been verified successfully!';
            pushOnSiteNotification($onsite_notification);
            
        }
        
        if($request->status == 2){
            $mailcontent_data = MailSmsTemplate::where('code','=',"Rejected-KYC")->first();
            if($mailcontent_data){
            $arr=[
                '{id}'=> $user->id,
                '{name}'=>NameById( $user->id),
                ];
            $action_button = null;
            TemplateMail($user->name,$mailcontent_data,$user->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
            }
          $onsite_notification['user_id'] =  $user->id;
            $onsite_notification['title'] = "eKYC rejected";
            $onsite_notification['link'] = route('customer.profile')."?active=account";
            $onsite_notification['notification'] = "Your eKYC has been rejected because of some reason please try again later.";
            pushOnSiteNotification($onsite_notification);
            $user_kyc = UserKyc::find($user->id);
            $user_kyc->delete();
        }
        if($request->status == 0){
            $user->update([
                'status' => $request->status,
             ]);
        
        }
        
        $user->update([
           'details' =>$new_ekyc_info,
           'status' => $request->status,
        ]);

        return redirect()->back()->with('success','eKYC update successfully!');
    }

    public function delete($id)
    {
        $user   = User::whereId($id)->first();

        if ($user) {
            $role = $user->roles[0]->name ?? '';
            $user->delete();
            return redirect()->route('panel.users.index','?role='.$role)->with('success', 'User removed!');
        } else {
            return redirect()->route('panel.users.index','?role='.$role)->with('error', 'User not found');
        }
    }
}

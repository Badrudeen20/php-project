<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletLog;
use App\User;

class WalletLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {
        // return $request->date;
        if($request->has('date')){
            $wallet_logs = Walletlog::whereDate('created_at',$request->date)->whereUserId($id)->latest()->get();
        }
        else{
            $wallet_logs = Walletlog::whereUserId($id)->latest()->get();
        }
        return view('backend.admin.wallet-logs.index',compact('id','wallet_logs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        // return $request->all();
        

    }

    public function userWalletUpdate(Request $request)
    {
        // return $request->all();
        // Credit -> To add money
        $user_record = User::whereId($request->user_id)->firstorFail();

            if($request->type == 'debit'){
                if($user_record->wallet_balance  <  $request->amount){
                    return back()->withInput($request->all())->with('error',"Amount cannot exceed current balance");
                }
            }
        
            
            if($request->type == 'credit'){
                $remark = 'Admin Added '.format_price($request->amount); 
                $after_balance = $user_record->wallet_balance + $request->amount;
            }else{
                $remark = 'Admin Subtracted '.format_price($request->amount); 
                $after_balance = $user_record->wallet_balance - $request->amount;
            }
        
        pushWalletLog($request->user_id,$request->type,$request->amount,$after_balance,$remark);

        if($request->type == 'credit'){
           User::find($request->user_id)->increment('wallet_balance',$request->amount);
        }else{
            User::find($request->user_id)->decrement('wallet_balance',$request->amount);
        }
        return back()->with('success','Wallet Balance Updated Successfully!');
    }   


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id, $s)
    {
        $wl = Walletlog::find($id);
        if($wl){
            $wl->status = $s;
            $wl->save();

            if($s == 1){
              $user =  User::find($wl->user_id);
              $user->wallet_balance = $user->wallet_balance + $wl->amount;
              $user->save();
            }
            return back()->with('success','Updated Record!');
        } else{
            
        return back()->with('error','Record not found!');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

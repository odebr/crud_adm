<?php

namespace app\Listeners;

use App\Models\MerchantSubscriptionPlan;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class MyLoginListener
{
    /**
     * @param  Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $email = $event->user->email;
        $results = \DB::connection('mysql2')->select("SELECT * from users where email = :email", ['email' => $email]);
        $USERID = $results[0]->user_id;
        $admin_email = $results[0]->admin_email;
        $role = $results[0]->role;
        $plan = $results[0]->plan_code;
        $plan_name = '';
        if ($plan) {
            $planModel = MerchantSubscriptionPlan::where(['code'=>$plan])->first();
            $plan_name = $planModel->name;
        }

        $resultSettings = \DB::connection('mysql2')->select("SELECT * FROM settings where email='".$email."' ORDER by id ASC");
        $rowupdate = $resultSettings[0];
        $name = $rowupdate->first_name.' '.$rowupdate->last_name;
        $business_name = $rowupdate->business_name;
        $phone = $rowupdate->phone;
        $mobile = $rowupdate->cell;
        $account_type = $rowupdate->account_type;
        $student_id = $rowupdate->student_id;

        $ADMINID = \DB::connection('mysql2')->table('users')->where('email', $admin_email)->first()->user_id;
        $userInfo = [
                'user_id' => $USERID,
                'name' => $name,
                'business_name' => $business_name,
                'admin_email' => $email,
                // 'admin_email' => $admin_email,
                'phone' => $phone,
                'mobile' => $mobile,
                'student_id' => $student_id,
                'plan_code' => $plan,
                'plan_name'=>$plan_name,
                'role' => $role,
                'admin_id' => $ADMINID
            ];
        session(['user' => $userInfo]);
        // Log::debug('****SESSION USERID:'.session('user_id'));

    }
}

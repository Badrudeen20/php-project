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

use Twilio\Rest\Client;
// from shn

// for dynamic mail

if (!function_exists('DynamicMailTemplateFormatter')) {
    function DynamicMailTemplateFormatter($body, $variable_names, $var_list)
    {
        // Make it Foreachable
        // return $variable_names;
        $variable_names = explode(', ', $variable_names);
        $i = 1;
        $data = "";
        foreach ($variable_names as $item) {
            if ($i == 1) {
                if(array_key_exists($item,$var_list)){
                    $data =  str_replace($item, $var_list[$item], $body);
                    $i += 1;
                }
            } else {
                if(array_key_exists($item,$var_list)){
                    $data =  str_replace($item, $var_list[$item], $data);
                }
            }
        }
        return $data;
    }
}
// get auth profile image

if (!function_exists('getAuthProfileImage')) {
    function getAuthProfileImage($path){
        if(\Str::contains($path, 'https:')){
            return $path;
        }
        $profile_img = $path;
        if($profile_img != null){
            return $profile_img;
        }
    }
}

if (!function_exists('getArticleImage')) {
    function getArticleImage($path){
        $profile_img = asset('storage/backend/article/'.$path);
        if($profile_img){
            return $profile_img;
        }else{
            asset('backend/default/default-avatar.png');
        }
    }
}

// custommail template with template table
if (!function_exists('asset')) {
    function asset($path,$secure=null){
        $timestamp = @filemtime(public_path($path)) ?: 0;
        return asset($path, $secure) . '?' . $timestamp;
    }
}

if (!function_exists('getSupportTicketStatus')) {
    function getSupportTicketStatus($id = -1)
        {
            if($id == -1){
                return [
                    ['id'=>0,'name'=>'Under Working','color'=>'secondary'],
                    ['id'=>1,'name'=>'Reply Received','color'=>'warning'],
                    ['id'=>2,'name'=>'Resolved','color'=>'success'],
                    ['id'=>3,'name'=>'Rejected','color'=>'danger'],
                    ['id'=>4,'name'=>'Close','color'=>'danger'],
                    ];
                }else{
                    foreach(getSupportTicketStatus() as $row){
                    if($row['id'] == $id){
                    return $row;
                    }
                }
            }
        }
    }
if (!function_exists('getWalletStatus')) {
    function getWalletStatus($id = -1)
        {
            if($id == -1){
                return [
                    ['id'=>0,'name'=>'Requested','color'=>'info'],
                    ['id'=>1,'name'=>'Accepted','color'=>'success'],
                    ['id'=>2,'name'=>'Declined','color'=>'danger'],
                    ];
            }else{
                foreach(getWalletStatus() as $row){
                    if($row['id'] == $id){
                        return $row;
                    return $row;
                    }
                }
                return ['id'=>$id,'name'=>'','color'=>''];
            }
    }
}
  
    if(!function_exists('getSupportTicketPrefix')){
        function getSupportTicketPrefix($id){
            return '#SUPTICK'.$id;
        }
    }
// custommail template with template table
if (!function_exists('customMail')) {
    function customMail($name,$to,$mailcontent_data,$arr,$cc = null ,$bcc = null ,$action_btn = null ,$attachment_path = null ,$attachment_name = null ,$attachment_mime = null){
        $to = $to;
        $data['name'] = $name;
        $name = $name;
        $data['subject'] = DynamicMailTemplateFormatter($mailcontent_data->title, $chk_data->variables, $arr);
        $subject = $mailcontent_data->title;
        $chk_data = $mailcontent_data;
        $data['t_footer'] = $mailcontent_data->footer;
        $t_data = DynamicMailTemplateFormatter($chk_data->body ,$chk_data->variables ,$arr);
        $data['t_data'] = $t_data;
        $data['action_button'] = $action_btn;
        $data['attachment_path'] = $attachment_path;
        $data['attachment_name'] = $attachment_name;
        $data['cc'] = $cc == null ? [] : $cc;
        $data['bcc'] = $bcc == null ? [] : $cc;
        if($mailcontent_data->type == 1){
            if(getSetting('email_notify')){
                $mail = \Mail::to($to);
                if($cc != null){
                        $mail->cc($cc, getSetting('mail_from_name'));
                }
                if($bcc != null){
                    $mail->bcc($bcc, getSetting('mail_from_name'));
                }
        
                $mail->send(new App\Mail\CustomMail($data));

            }
        }
        if($mailcontent_data->type == 2){
            // sms
            manualSms($to,$t_data);
        }
        if($mailcontent_data->type == 3){
            // whatsapp
        }
    }
}
if(!function_exists('getEnquiryStatus')){
    function getEnquiryStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"New" ,'color' =>"primary"],
            ['id'=>1,'name'=>"Completed",'color' =>"success"],
            ['id'=>2,'name'=>"Cancelled",'color' =>"danger"],
            ['id'=>3,'name'=>"Hold",'color' =>"warning"],

        ];
        }else{
            foreach(getEnquiryStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];

        }
    }
}
if(!function_exists('getPayoutStatus')){
    function getPayoutStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"Unpaid" ,'color' =>"warning"],
            ['id'=>1,'name'=>"Paid",'color' =>"success"],
            ['id'=>2,'name'=>"Rejected",'color' =>"danger"],

        ];
        }else{
            foreach(getPayoutStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}
if(!function_exists('getTransactionType')){
    function getTransactionType($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"Credit" ,'color' =>"danger"],
            ['id'=>1,'name'=>"Debit",'color' =>"success"],

        ];
        }else{
            foreach(getTransactionType() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}
if (!function_exists('pushWalletLog')) {
    function pushWalletLog($user_id,$type,$amount,$after_balance,$remark)
    {
        $wallet_record = App\Models\WalletLog::create([
            'user_id'=>$user_id,
            'type'=>$type,
            'amount'=>$amount,
            'after_balance'=>$after_balance,
            'remark'=>$remark,
        ]);

    }
}

// custommail template with template table
if (!function_exists('TemplateMail')) {
    function TemplateMail($name, $code, $to, $mail_type, $arr, $mailcontent_data, $mail_footer = null, $action_button = null)
    {
        
        $to = $to;
        $data['name'] = $name;
        $name = $name;
        $data['subject'] = DynamicMailTemplateFormatter($mailcontent_data->title, $chk_data->variables, $arr);
        $subject = $mailcontent_data->title;
        $data['type_id'] = $mail_type;
        $type_id = $mail_type;
        $chk_data = $mailcontent_data;
        $data['t_footer'] = $mail_footer;

        $t_data =  DynamicMailTemplateFormatter($chk_data->body, $chk_data->variables, $arr);
        $data['t_data'] = $t_data;
        $data['action_button'] = $action_button;

        if(getSetting('email_notify')){
            // Mail Sender
            \Mail::send('emails.dynamic-custom', $data, function ($message) use ($to, $name, $subject) {
                $message->to($to, $name)->subject($subject);
                $message->from(getSetting('mail_from_address'), getSetting('app_name'));
            });
        }

        // EmailLog Capture
        // App\EmailLog::create([
        //     'subject' => $data['subject'],
        //     'email' => $to,
        //     'user_id' => auth()->id() ?? null,
        //     'sent_by' => 37,
        //     'type' => 'automatic',
        //     'datetime' => now(),
        // ]);
        return true;
    }
}

// manual Email without template table
if (!function_exists('StaticMail')) {
    function StaticMail($name, $to, $subject, $body, $mail_footer = null, $action_button = null, $cc = null, $bcc = null,$attachment_path = null ,$attachment_name = null ,$attachment_mime = null)
    {
        if($cc == null){
            $cc = '';
        }
        if($bcc == null){
            $bcc = '';
        }
        $data['name'] = $name;
        $data['subject'] = $subject;
        $data['t_footer'] = $mail_footer;
        $data['t_data'] = $body;
        $data['action_button'] = $action_button;

        // Mail Sender
        try{
            if(getSetting('email_notify')){
                $mail = \Mail::to($to);
                if($cc != null){
                        $mail->cc($cc, getSetting('mail_from_name'));
                }
                if($bcc != null){
                    $mail->bcc($bcc, getSetting('mail_from_name'));
                }
                if($attachment_path != null)
                {
                    $mail->attach($attachment_path, [
                            'as'    => $attachment_name,
                            'mime'  => $attachment_mime,
                        ]);
                }
                $mail->send(new App\Mail\CustomMail($data));
                

                
                // \Mail::send('emails.dynamic-custom', $data, function ($body) use ($to, $name,$cc, $bcc, $subject,$attachment_path,$attachment_name,$attachment_mime) {
                //     $body->to($to, $name)->subject($subject);
                //     if($cc != null){
                //         $body->cc($cc,getSetting('mail_from_name'));
                //     }
                //     if($bcc != null){
                //         $body->bcc($bcc, getSetting('mail_from_name'));
                //     }
                //     if($attachment_path != null)
                //     {
                //         $body->attach($attachment_path, [
                //                 'as'    => $attachment_name,
                //                 'mime'  => $attachment_mime,
                //             ]);
                //     }
                //     $body->from(getSetting('mail_from_address'), getSetting('mail_from_name'));
                // });
            }
            return "done";
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
// Send Sms By Api
if (!function_exists('sendSms')) {
    function sendSms($number,$msg,$template_id){

        // $number must be comma separated values
        // $msg must be normal text
        $response = Http::withHeaders([
            'authkey' => '366553Aka2FC7OmM612e3ed7P1',
            'accept' => 'application/json'
        ])->get('http://otpsms.vision360solutions.in/api/sendhttp.php', [
            'mobiles' => $number,
            'message' => $msg,
            'sender' => "DEZLTE",
            'route' => 4,
            'country' => 91,
            'response' => "json",
            'DLT_TE_ID' => $template_id,
        ]);
        if($response){
            return $response;
        }else{
            return false;
        }
    }
}

// manual SMS By Twilio Account
if (!function_exists('manualSms')) {
    function manualSms($number,$msg)
    {
        $accountSid = getSetting('twilio_account_sid');
        $authToken  = getSetting('twilio_auth_token');
        $accountnumber  = getSetting('twilio_account_number');
        $client = new Client($accountSid, $authToken);
        $client->messages->create('+91'.$number,
            array(
                'from' => $accountnumber,
                'body' => $msg
            )
        );
    }
}


// old data recover
if (!function_exists('selectSelecter')) {
    function selectSelecter($old_val, $updated_val, $compare_val)
    {
        if ($old_val != null) {
            $result = $old_val == $compare_val ? "selected" : '';
        } elseif ($updated_val != null) {
            $result = $updated_val == $compare_val ? "selected" : '';
        } else {
            $result = '';
        }
        return $result;
    }
}

// from DFV

// currency amount cleaner 
if (!function_exists('currencyAmountCleaner')) {
    function currencyAmountCleaner($val)
    {
        $x = substr($val, 1);
        return str_replace(',', '', $x);
    }
}

if (!function_exists('getOrderHashCode')) {
    function getOrderHashCode($order_id)
    {
        return '#OID'.$order_id;
    }
}
if (!function_exists('getTicketHashCode')) {
    function getTicketHashCode($ticket_id)
    {
        return '#SUPTIC'.$ticket_id;
    }
}
if (!function_exists('getLeadHashCode')) {
    function getLeadHashCode($lead_id)
    {
        return '#LID'.$lead_id;
    }
}


// from albuhaira
// Age Calculator
function ageCalculator($dob)
{
    if (!empty($dob)) {
        $birthdate = new DateTime($dob);
        $today   = new DateTime('today');
        $age = $birthdate->diff($today)->y;
        return $age;
    } else {
        return 0;
    }
}
// get Browser
function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version= $matches['version'][0];
        } else {
            $version= $matches['version'][1];
        }
    } else {
        $version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {
        $version="?";
    }
   
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

// get Image
if(!function_exists('getImage')){
    function getImage($path = null,$name = null, $type = 'placeholder'){
        if($name != null){
          return  '<img src="'.$path.'">';
        }else{
            if($type == 'placeholder'){
              return  '<img src={{'.asset("frontend/images/placeholder.png").'}}>';
            }
        }
    }
}
if(!function_exists('uploaded_asset')){
    function uploaded_asset($path = null,$name = null, $type = 'placeholder'){
        if($name != null){
          return  '<img src="'.$path.'">';
        }else{
            if($type == 'placeholder'){
              return  '<img src={{'.asset("frontend/images/placeholder.png").'}}>';
            }
        }
    }
}

// check and create dir
if(!function_exists('checkAndCreateDir')){
    function checkAndCreateDir($path){
        // Create directory if not exist
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
    }
}

// Convert 1000 into 1k
function thousandsCurrencyFormat($number = null) {

    $suffixByNumber = function () use ($number) {
        if ($number < 1000) {
            return sprintf('%d', $number);
        }

        if ($number < 1000000) {
            return sprintf('%d%s', floor($number / 1000), 'K+');
        }

        if ($number >= 1000000 && $number < 1000000000) {
            return sprintf('%d%s', floor($number / 1000000), 'M+');
        }

        if ($number >= 1000000000 && $number < 1000000000000) {
            return sprintf('%d%s', floor($number / 1000000000), 'B+');
        }

        return sprintf('%d%s', floor($number / 1000000000000), 'T+');
    };

    return $suffixByNumber();
}




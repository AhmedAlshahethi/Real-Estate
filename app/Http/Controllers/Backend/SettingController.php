<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\smtp_setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;


class SettingController extends Controller
{
    public function SmtpSetting(){
        $setting = smtp_setting::findOrFail(1);
        return view("Backend.setting.smtp_setting",compact("setting"));
    }

    public function UpdateSmtpSetting(Request $request){
        $id = $request->id;

        smtp_setting::find($id)->update([
            'mailer' => $request->mailer,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'encryption' => $request->encryption,
            'from_address' => $request->from_address,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'SMTP Setting Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function SiteSetting(){
        $setting = SiteSetting::findOrFail(1);
        return view('Backend.setting.site_setting',compact('setting'));
    }

    public function UpdateSiteSetting(Request $request){
        $id = $request->id;

        if($request->file('logo')){

        $manager = new ImageManager(new Driver());
        $image = $request->file('logo');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $manager->read($image)->resize(1500,386)->save(base_path('public/upload/site_logo/'.$name_gen));
        $save_url = 'upload/site_logo/'.$name_gen;

        SiteSetting::find($id)->update([
            'support_phone' => $request->support_phone,
            'company_address' => $request->company_address,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'copyright' => $request->copyright,
            'updated_at' => Carbon::now(),
            'logo' => $save_url,
        ]);

        $notification = array(
            'message' => 'Site Setting Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } else {
            
            SiteSetting::find($id)->update([
                'support_phone' => $request->support_phone,
                'company_address' => $request->company_address,
                'email' => $request->email,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'copyright' => $request->copyright,
                'updated_at' => Carbon::now(),
            ]);
    
            $notification = array(
                'message' => 'Site Setting Updated without logo Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        }
        
    }
}

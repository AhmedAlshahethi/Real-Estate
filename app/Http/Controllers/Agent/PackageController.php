<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\PackagePlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PackageController extends Controller
{
    public function BuyPackage(){
        return view('agent.package.buy_package');
    } // End Method

    public function BuyBusinessPlan(){
        $id= Auth::user()->id;
        $user = User::find($id);

        return view('agent.package.buy_business_plan',compact('user'));
    } // End Method

    public function StoreBusinessPlan(Request $request){
        $id = Auth::user()->id;

        $user = User::find($id);
        $credit = $user->credit;

        PackagePlan::insert([
            'user_id' => $id,
            'package_name' => 'Business',
            'package_credits' => 3,
            'invoice' => 'ERS'.mt_rand(1000000000,9000000000),
            'package_amount' => 20,
            'created_at' => Carbon::now(),
        ]);

        User::where('id',$id)->update([
            'credit' => DB::raw('3 + '.$credit),
        ]);

        $notification = array(
            'message' => 'You have purchased business package Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('agent.all.property')->with($notification);

    } // End Method

    public function BuyProfessionalPlan(){
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('agent.package.buy_professional_plan',compact('user'));

    } // End Method

    public function StoreProfessionalPlan(Request $request){
        $id = Auth::user()->id;
        $user = User::find($id);
        $credit = $user->credit;

        PackagePlan::insert([
            'user_id' => $id,
            'package_name' => 'Professional',
            'package_credits' => 10,
            'invoice' => 'ERS'.mt_rand(1000000000,9000000000),
            'package_amount' => 50,
            'created_at'=> Carbon::now(),
        ]);

        User::where('id',$id)->update([
            'credit' => DB::raw('10 + '.$credit),
        ]);

        $notification = array(
            'message' => 'You have purchased professional package Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('agent.all.property')->with($notification);
    }

    public function PackageHistory(){
        $id = Auth::user()->id;
        $package = PackagePlan::where('user_id', $id)->get();

        return view('agent.package.package_history',compact('package'));
    } 

    public function PackageInvoice($id){
        $package_id = PackagePlan::where('id', $id)->first();

        $pdf = Pdf::loadView('agent.package.package_invoice_pdf', compact('package_id'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);

        return $pdf->download('invoice.pdf');

    }

    public function AdminPackageHistory(){
        $package = PackagePlan::latest()->get();

        return view('backend.package.package_history',compact('package'));
    }

    public function AdminPackageInvoice($id){
        $package_id = PackagePlan::where('id', $id)->first();

        $pdf = Pdf::loadView('backend.package.package_invoice_pdf', compact('package_id'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);

        return $pdf->download('invoice.pdf');

    }
}

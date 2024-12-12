<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class PackagesPagesController extends Controller
{
    public function add()
    {
        return view('admin.packages-add');
    }
    public function manageradd()
    {
        return view('manager.packages-add');
    }
    public function owneradd()
    {
        return view('owner.packages-add');
    }


    public function customize()
    {
        return view('admin.packages-customize');
    }
    public function managercustomize()
    {
        return view('manager.packages-customize');
    }


    public function newcustomize()
    {
        return view('admin.packages-new-customize');
    }
    public function managernewcustomize()
    {
        return view('manager.packages-new-customize');
    }
    public function ownernewcustomize()
    {
        return view('owner.packages-new-customize');
    }
    


    public function view()
    {
        // return view('admin.packages-view');
        $package = Package::orderBy('created_at', 'desc')
        ->where('packagestatus', 'active')
        ->where('packagetype', 'normal')
        ->paginate(20);
        return view('admin.packages-view', compact('package'));
    }
    public function managerview()
    {
        // return view('admin.packages-view');
        $package = Package::orderBy('created_at', 'desc')
        ->where('packagestatus', 'active')
        ->where('packagetype', 'normal')
        ->paginate(20);
        return view('manager.packages-view', compact('package'));
    }
    public function ownerview()
    {
        // return view('admin.packages-view');
        $package = Package::orderBy('created_at', 'desc')
        ->where('packagestatus', 'active')
        ->where('packagetype', 'Normal')
        ->paginate(20);
        return view('owner.packages-view', compact('package'));
    }

    public function viewArchived()
    {
        // return view('admin.packages-view');
        $package = Package::orderBy('created_at', 'desc')
        ->where('packagestatus', 'archived')
        ->paginate(20);
        return view('admin.packages-view-archived', compact('package'));
    }
    public function managerviewArchived()
    {
        // return view('admin.packages-view');
        $package = Package::orderBy('created_at', 'desc')
        ->where('packagestatus', 'archived')
        ->paginate(20);
        return view('manager.packages-view-archived', compact('package'));
    }
    public function ownerviewArchived()
    {
        // return view('admin.packages-view');
        $package = Package::orderBy('created_at', 'desc')
        ->where('packagestatus', 'archived')
        ->paginate(20);
        return view('owner.packages-view-archived', compact('package'));
    }

    public function viewCustom()
    {
        // return view('admin.packages-view');
        $package = Package::with(['custompackage', 'appointment.user'])
        ->orderBy('created_at', 'desc')
        ->where('packagestatus', 'active')
        ->where('packagetype', 'Custom')
        ->paginate(60);
        return view('admin.packages-view-custom', compact('package'));
    }
    public function managerviewCustom()
    {
        // return view('admin.packages-view');
        $package = Package::with('custompackage')
        ->orderBy('created_at', 'desc')
        ->where('packagestatus', 'active')
        ->where('packagetype', 'Custom')
        ->paginate(60);
        return view('manager.packages-view-custom', compact('package'));
    }
    public function ownerviewCustom()
    {
        // return view('admin.packages-view');
        $package = Package::with('custompackage')
        ->orderBy('created_at', 'desc')
        ->where('packagestatus', 'active')
        ->where('packagetype', 'Custom')
        ->paginate(60);
        return view('owner.packages-view-custom', compact('package'));
    }






    // public function eye()
    // {
    //     // return view('admin.packages-view');
    //     $package = Package::orderBy('created_at', 'desc')->get();
    //     return view('admin.packages-eye', compact('package'));
    // }
}

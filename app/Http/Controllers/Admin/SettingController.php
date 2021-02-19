<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Setting;

class SettingController extends Controller
{
    public function __construct(){


    }

    public function index(Request $request)
    {


        if ($request->ajax()) {
            $settings = Setting::orderby('created_at','desc')->latest('id');

            return Datatables::of($settings)
            ->editColumn('created_at',function(Setting $setting){
                    return $setting->created_at->diffForHumans();
                })
            ->addColumn('action',function($data){
                $link = '<div class="d-flex">'.
                            '<a href="'.route('setting.edit',$data->id).'" class="mr-2"><small>Edit</small></a>'.
                            '<a href="javascript:void(0);" id="'.$data->id.'" class="delete"><small>Delete</small></a>'.
                        '</div>';
                return $link;
            })
            ->rawColumns(['action'])
            ->make(true);


        }


        return view('admin.pages.setting.setting');

    }

    public function create()
    {
        return view('admin.pages.setting.setting_add');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required'
        ]);

        $setting = New Setting;
        $setting->name = $request->name;
        $setting->save();

        return redirect()->route('setting.index')
        ->with([
            'message'    =>'Setting Added Successfully',
            'alert-type' => 'success',
        ]);

    }

    public function show($id)
    {
        $setting = Setting::findOrFail($id);

        return response()->json($setting);
    }

    public function edit($id)
    {
        $setting = Setting::findOrFail($id);

        //return response()->json($setting);

        return view('admin.pages.setting.setting_edit',compact('setting'));
    }

    public function update(Request $request, $id)
    {

        $validate = $request->validate([
            'name' => 'required'
        ]);

        $setting = Setting::findOrFail($id);
        $setting->name = $request->name;
        $setting->save();

        return redirect()->route('setting.index')
        ->with([
            'message'    =>'Setting Updated Successfully',
            'alert-type' => 'success',
        ]);


    }

    public function destroy($id)
    {
        $setting = Setting::destroy($id);

        if($setting){
            return redirect()->route('setting.index')
            ->with([
                'message'    =>'Setting Updated Successfully',
                'alert-type' => 'success',
            ]);
        }else{

        }

    }
}

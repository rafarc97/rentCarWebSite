<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Auth;


class AdController extends Controller
{
    public function menu(){

        $ads = DB::table('ads')->paginate(4);

        $user = User::where('id','=',session('LoggedUser'))->first();

        $isAdmin = false;
        if($user->rol == 'admin')
            $isAdmin = true;

        return view('admin.menu')->with(['ads' => $ads, 'isAdmin' => $isAdmin]);
    }

    public function show(Ad $ad){
        $user = User::where('id', '=', session('LoggedUser'))->first();
        $data = [
            'LoggedUserInfo'=>$user
        ];
        return view('ad.show',$data)->with(['ad' => $ad]);
    }

    public function brand($brand){
        $ads = DB::table('ads')->where('brand', $brand)->paginate(4);
        return view('ad.brand')->with(['ads' => $ads]);
    }

    public function type($type){
        $ads = DB::table('ads')->where('type', $type)->paginate(4);
        return view('ad.type')->with(['ads' => $ads]);
    }

    /* Introducir middleware de comprobacion de que acceden a estar urls solo admin */
    public function create_form_ad(Request $request){
        $current_user = User::where('id','=',session('LoggedUser'))->first();
        $user_rol = DB::table('users')->select('rol')->where('id', '=', $current_user->id)->get()->toArray();

        if($user_rol[0]->rol != 'admin'){
            return view('admin.notpermited');
        }

        return view('ad.create_form');
    }

    public function create_ad(Request $request){

        $current_user = User::where('id','=',session('LoggedUser'))->first();
        $user_rol = DB::table('users')->select('rol')->where('id', '=', $current_user->id)->get()->toArray();

        if($user_rol[0]->rol != 'admin'){
            return view('admin.notpermited');
        }

        // Validate request
        $request->validate([
            'type'=>'string|required|max:255',
            'brand'=>'string|required|max:255',
            'model'=>'string|required|max:255',
            'license_plate'=>'required',
            'price'=>'int|required|min:1',
            'color'=>'string|required|max:255',
            'image'=>'required|max:255|mimes:jpg,bmp,png,jpeg',
        ]);

        $image_path = $request->image->getClientOriginalName();
        $request->image->move(public_path('img'), $image_path);
        
        $query = DB::table('ads')->insert([
            'type' => $request->type,
            'brand' => $request->brand,
            'model' => $request->model,
            'license_plate' => $request->license_plate,
            'price' => $request->price,
            'color' => $request->color,
            'image' => "img/" . $request->image->getClientOriginalName()
        ]);

        if($query){
            return back()->with('success','El anuncio ha sido creado correctamente.');
        }else{
            return back()->with('fail','Algo fue mal.'); 
        }
    }
    
    public function delete_form_ad(){

        $current_user = User::where('id','=',session('LoggedUser'))->first();
        $user_rol = DB::table('users')->select('rol')->where('id', '=', $current_user->id)->get()->toArray();

        if($user_rol[0]->rol != 'admin'){
            return view('admin.notpermited');
        }


        $ads = DB::table('ads')->paginate(4);
        return view('ad.delete')->with(['ads' => $ads]);
    }

    public function delete_ad(Int $id){

        $current_user = User::where('id','=',session('LoggedUser'))->first();
        $user_rol = DB::table('users')->select('rol')->where('id', '=', $current_user->id)->get()->toArray();

        if($user_rol[0]->rol != 'admin'){
            return view('admin.notpermited');
        }

        // Delete from /public/img
        $query2 = DB::table('ads')->select('image')->where('adid', '=', $id)->get()->toArray();

        $existsImage = false;
        if(!empty($query2[0]->image)){
            $image_path = $query2[0]->image;
            if(File::exists($image_path)) {
                $existsImage = true;
                File::delete($image_path);
            }        
        }

        // Delete from DB
        $query = DB::table('ads')->where('adid', '=', $id)->delete();

        if($query && $existsImage){
            return back()->with('success','El anuncio ha sido eliminado correctamente.');
        }else{
            return back()->with('fail','Algo fue mal.'); 
        }
    }
    
    public function update_ad_page(){
        $current_user = User::where('id','=',session('LoggedUser'))->first();
        $user_rol = DB::table('users')->select('rol')->where('id', '=', $current_user->id)->get()->toArray();

        if($user_rol[0]->rol != 'admin'){
            return view('admin.notpermited');
        }

        $ads = DB::table('ads')->paginate(4);
        return view('ad.update')->with(['ads' => $ads]);
    }

    public function update_form_ad(Ad $ad){
        $current_user = User::where('id','=',session('LoggedUser'))->first();
        $user_rol = DB::table('users')->select('rol')->where('id', '=', $current_user->id)->get()->toArray();

        if($user_rol[0]->rol != 'admin'){
            return view('admin.notpermited');
        }
        return view('ad.update_form')->with(['ad' => $ad]);
    }

    public function update_ad(Int $adid, Request $request){
        $current_user = User::where('id','=',session('LoggedUser'))->first();
        $user_rol = DB::table('users')->select('rol')->where('id', '=', $current_user->id)->get()->toArray();

        if($user_rol[0]->rol != 'admin'){
            return view('admin.notpermited');
        }

        // Validate
        $request->validate([
            'model'=>'nullable|string|max:255',
            'price'=>'nullable|int|min:0',
            'color'=>'nullable|string|max:255',
            'image'=>'nullable|image|mimes:jpg,bmp,png,jpeg|max:10000',
        ]);

        if ($request->hasFile('image'))
        {
            $image_path = $request->image->getClientOriginalName();
            $request->image->move(public_path('img'), $image_path);

            $query = DB::table('ads')->where('adid', $adid)->update([
                'type' => $request->type,
                'brand' => $request->brand,
                'model' => $request->model,
                'license_plate' => $request->license_plate,
                'price' => $request->price,
                'color' => $request->color,
                'image' => "img/" . $request->image->getClientOriginalName()
            ]);
        } else {
            $query = DB::table('ads')->where('adid', $adid)->update([
                'type' => $request->type,
                'brand' => $request->brand,
                'model' => $request->model,
                'license_plate' => $request->license_plate,
                'price' => $request->price,
                'color' => $request->color
            ]);
        }

        if($query){
            return back()->with('success','El anuncio se ha actualizado correctamente,');
        }else{
            return back()->with('fail','Algo fue mal.'); 
        }
    }
}
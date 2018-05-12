<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuperUserController extends Controller
{
    //
    public function modify_user(){
        return view('admin/superuser/modifyuser');
    
    }

    public function change_icon(Request $request){
        $this->validate($request , [
            'userid'=>'required|integer|exists:users,id',
            'image'=> 'required|image|mimes:jpeg,png,jpt,gif,svg|max:2048',
        ]);

        $newImage = new \App\Photo;
        $newImage->title = "icon";
        $newImage->file_name = time().'.'.$request->image->getClientOriginalExtension();
        $newImage->type = "UserIcon";
        $newImage->owner_id = $request->get('userid');
        $request->image->move(public_path('images'), $newImage->file_name);
        if (!$newImage->save()) {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }

        return redirect('admin/modifyuser'); // 保存成功，跳转到 文章管理 页
    }

}
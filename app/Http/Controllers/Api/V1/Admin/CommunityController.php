<?php

namespace App\Http\Controllers\Api\V1\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommunityController extends Controller
{
    //
    public function index()
    {
        return view('admin/community/index')->withCommunities(\App\Community::all());
    }

    public function create()
    {
        return view('admin/community/create');
    }
    public function store(Request $request) // Laravel 的依赖注入系统会自动初始化我们需要的 Request 类
    {
        // 数据验证
        $this->validate($request, [
            'name' => 'required|unique:communities|max:255', // 必填、在 communitys 表中唯一、最大长度 255
            'brief' => 'required', // 必填
        ]);

        // 通过 community Model 插入一条数据进 communitys 表
        $community = new \App\Community; // 初始化 community 对象
        $community->name = $request->get('name'); // 将 POST 提交过了的 title 字段的值赋给 community 的 title 属性
        $community->brief = $request->get('brief'); // 同上


        // to save the icon
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $newImage = new \App\Photo;
        $newImage->title = $request->get('name').'icon';
        $newImage->file_name = time().'.'.$request->image->getClientOriginalExtension();
        $newImage->type = 'CommunityIcon';
        $request->image->move(public_path('images'), $newImage->file_name);


        // 将数据保存到数据库，通过判断保存结果，控制页面进行不同跳转
        if (!$community->save() && $newImage->save()) {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }

        // 保存失败，跳回来路页面，保留用户的输入，并给出提示
        $newImage->owner_id = get_community_id($community->name);
        if(!$newImage->save()){
            return redirect()->back()->withInput()->withErrors('创建成功，但图片保存失败！');
        }

        return redirect('admin/community'); // 保存成功，跳转到 文章管理 页
    }

    public function destroy($id)
    {
        \App\Community::find($id)->delete();
        return ('deleted');
    }
}

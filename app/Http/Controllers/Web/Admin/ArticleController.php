<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;

require_once('toolbox.php');


class ArticleController extends Controller
{
    //
    public function index()
    {
        return view('admin/article/index')->withArticles(Article::all());
    }
    public function create()
    {
        return view('admin/article/create');
    }
    public function store(Request $request) // Laravel 的依赖注入系统会自动初始化我们需要的 Request 类
    {
        // 数据验证
        $this->validate($request, [
            'title' => 'required|unique:articles|max:255', // 必填、在 articles 表中唯一、最大长度 255
            'body' => 'required', // 必填
            'community_name' => 'required',
        ]);
        // 通过 Article Model 插入一条数据进 articles 表
        $article = new Article; // 初始化 Article 对象
        $article->title = $request->get('title'); // 将 POST 提交过了的 title 字段的值赋给 article 的 title 属性
        $article->body = $request->get('body'); // 同上
    //  $article->user_id = $request->user()->id; // 获取当前 Auth 系统中注册的用户，并将其 id 赋给 article 的 user_id 属性
        $owner_name = $request->get('community_name');
        $article->owner_id = get_community_id($owner_name);
        $article->likes = 0;

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $newImage = new \App\Photo;
        $newImage->title = $request->get('name').'icon';
        $newImage->file_name = time().'.'.$request->image->getClientOriginalExtension();
        $newImage->type = 'Poster';
        $request->image->move(public_path('images'), $newImage->file_name);

        if (!$article->save()) {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }

        $newImage->owner_id =  $article->id;
        if (!$newImage->save()) {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }

            return redirect('admin/article'); // 保存成功，跳转到 文章管理 页
    }

    public function destroy($id)
    {
        Article::find($id)->delete();
        return ('deleted');
    }
}

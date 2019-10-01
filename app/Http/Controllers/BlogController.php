<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// load database
use Illuminate\Support\Facades\DB;
use App\Blog;

// load mail
// load database
use Illuminate\Support\Facades\Mail;
use App\Mail\BlogPosted;

use App\Event\BlogCreated;

class BlogController extends Controller
{
    public function index(){
      $blogs = Blog::all();
      return view('blog/home', ['blogs' => $blogs]);
    }

    public function show($id){
      $value = 'This is your id '. $id;
      $user = 'Muhammad Khoirul Anam';

      //get users data from database (select)
      $users = DB::table('users')->get();
      // $users = DB::table('users')->where('username','anam')->get();
      // $users = DB::table('users')->where('username','like','%a%')->get();

      $unescaped = '<script>alert("x!")</script>';

      return view('blog/single', ['blog' => $value, 'user' => $user, 'users' => $users, 'unescaped' => $unescaped]);
    }

    public function view($id){
      $blog = Blog::find($id);

      if(!$blog)
        abort(404);
      return view('blog/detail', ['blog' => $blog]);
    }

    public function create(){
      return view('blog/create');
    }

    public function store(Request $request){
      //validation
      $this->validate($request,[
        'title' => 'required|min:5',
        'description' => 'required|min:5|max:30'
      ]);

      //common insert
      $blog = new Blog;
      $blog->title = $request->title;
      $blog->description = $request->description;
      $blog->save();

      // event(new BlogCreated($blog));
      // send email with parameter
      Mail::to('testing1@gmail.com')->queue(new BlogPosted($blog));

      return redirect('blog');
    }

    public function edit($id){
      $blog = Blog::find($id);

      if(!$blog)
        abort(404);
      return view('blog/edit', ['blog' => $blog]);
    }

    public function update(Request $request, $id){
      // common update
      $blog = Blog::find($id);
      $blog->title = $request->title;
      $blog->description = $request->description;
      $blog->save();

      return redirect('blog/'.$id);
    }

    public function destroy($id){
      //soft delete
      $blog = Blog::find($id);
      $blog->delete();

      return redirect('blog');
    }
}

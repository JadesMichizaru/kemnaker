<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResources;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
   /**
    * index
    * 
    * @return void
    */

   public function index()
   {
      // mendapatkan semua postingan
      $posts = Post::latest()->paginate(5);

      return new PostResources(true, 'List Data Posts', $posts);
   }

   /**
    * store
    *
    *@param mixed $request
    *@return void
    */

   public function store(Request $request)
   {
      // Define Validation Route

      $validator = Validator::make($request->all(), [
         'image' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
         'title' => 'required',
         'content' => 'required'
      ]);

      // Check If validation fail

      if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
      }

      // upload image
      $image = $request->file('image');
      $image->storeAs('public/posts', $image->hashName());

      // create post
      $posts = Post::create([
         'image' => $image->hashName(),
         'title' => $request->title,
         'content' => $request->content
      ]);

      return new PostResources(true, 'Data Post Berhasil di upload', $posts);
   }

   /**
    * show
    *
    *@param mixed $id
    *@return void
    */

   public function show($id)
   {
      // Mendapatkan ID Postingan
      $posts = Post::find($id);

      return new PostResources(true, 'Data Detail Post', $posts);
   }
}

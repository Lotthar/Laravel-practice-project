<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
// kada koristimo DB mozemo da radimo standardne SQL upite
use DB; 
// Kontroler koji smo napravili da nam kontrolise POST requestove
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Posto koristimo Post model onda kroz 'use'
        // imamo sve f-je koje Model objekat ima koje nam
        // omogucavaju da radimo upite nad bazom

        // $posts = Post::all();
        // $posts = DB::select('SELECT * from posts');
        // return Post::where('title','Post Two')->get();  Mozemo da radimo SQL upite preko funkcija koje ima model
        // $posts = Post::orderBy('title', 'desc')->take(1)->get();

        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Uzima request objekat i smjesta sadrzaj iz FORME
        // Ovaj dio je validacija inputa moraju se unijeti neka OBAVEZNA polja
        $this->validate($request, [
            'title' => 'required',
            'body' =>  'required'
        ]);
        // Kreiramo novi post  i stavljamo parametre iz requesta koje smo dobili u 
        // novi insert u tabelu
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Uzima id jer mora da zna koji POST pokazujemo
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Mora da zna koji post mora da edituje
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Jer predajemo formu njemu i moramo da znamo koju da updejtujemo
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Isto uzima id jer mora da zna koju da unistimo
    }
}

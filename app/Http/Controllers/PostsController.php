<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;
// kada koristimo DB mozemo da radimo standardne SQL upite
use DB; 
// Kontroler koji smo napravili da nam kontrolise POST requestove
class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // middleware(auth) nam nece dozvoliti da vidimo postove ako nismo ulogovani 
        // osim za izuzetke a to su index i show dje mi mozemo da vidimo ostale postove 
        // 
        $this->middleware('auth' , ['except' => ['index' , 'show']]);
    }

    /**
     * 
     * 
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
            'body' =>  'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);
            // Obrada uplouda fajla / slike
            if($request->hasFile('cover_image')){
                // iz requesta uzimamo fajl koji je uploudovan i kupimo mu kompletno ime
                $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
                // Izdvajamo samo ime fajla
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Izdvajamo samo ekstenziju
                $exstention = $request->file('cover_image')->getClientOriginalExtension();
                // Ime fajla ciju cemo putanju da cuvamo u bazu kreiramo
                // tako sto stavljamo na kraj prije ekstenzije .time() - vraca trenutno vrijem da bi svaki fajl
                // uvijek bio unikatan jer moze se desiti da jos neki korisnik
                // uplouduje fajl sa istim imenom u bazu 
                $filenameToStore = $filename.'_'.time().'.'.$exstention;
                // Upload 
                // cuva slike koje smo uploudovali u folder storage/app/public/i pravi folder cover_images
                // ruta($path) do tog fajla se cuva u bazu a fajl predajemo kao argument storeAs f-je
                // koja ce nam sacuvati taj fajl
                // Posto storage nije vidljiv browseru necemo moci da vidim slike 
                // dok ne linkujemo ga u public folder sa 'php artisan storage:link'
                $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
            } else {
                // ako nema slike stavimo default
                $filenameToStore = 'noimage.jpg';
            }


        // Kreiramo novi post  i stavljamo parametre iz requesta koje smo dobili u 
        // novi insert u tabelu
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        // Nakon artisan make:auth smo napravili sve za korisnika i preko auth() pristupamo trenutno
        // ulogovanom korisniku i svim njegovim poljima
        $post->user_id = auth()->user()->id;
        $post->cover_image = $filenameToStore;
        $post->save();

        return redirect('/dashboard')->with('success', 'Post Created');
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
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorised Page');
        }
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
        $post = Post::find($id);
        // Provjeravamo da li je korisnik od tog posta 
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorised Page');
        }
        return view('posts.edit')->with('post', $post);
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
        $this->validate($request, [
            'title' => 'required',
            'body' =>  'required'
        ]);
        //   provejravamo ima li ikakvog fajla
        if ($request->hasFile('cover_image')) {
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $exstention = $request->file('cover_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $exstention;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
        }

        // trazimo post jer sad updejtujemo i predajemo id
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        // ako su uploudovali novo sliku tek je onda promjeni
        if ($request->hasFile('cover_image')) {
            $post->cover_image = $filenameToStore;
        }
        $post->save();

        return redirect('/dashboard')->with('success', 'Post Updated');
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
        // Nadjemo post i brisemo ga sa tim id-em
        $post = Post::find($id);
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorised Page');
        }

        if($post->cover_image != 'noimage.jpg'){
            // ako nije automatska slika onda cemo je obrisati
            Storage::delete('public/cover_images/'.$post->cover_image);

        }

        $post->delete();
        return redirect('/dashboard')->with('success', 'Post removed');
    }
}

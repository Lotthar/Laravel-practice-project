<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Resursi 
// Ovdes se preko Ruta dolazi do straica i njihovih view-ova
// Kontroler za stranice koji smo napravili da nam kontrolise stranice koje
// Koristimo
class PagesController extends Controller
{
    public function __construct()
    {
        // middleware(auth) nam nece dozvoliti da vidimo postove ako nismo ulogovani 
        // osim za izuzetke a to su index i show dje mi mozemo da vidimo ostale postove 
        // 
        $this->middleware('auth' , ['except' => ['index','about','services']]);
    }

    public function index() {
        $title = 'Welcome to Laravel';
        // return view('pages.index', compact('title'));   jedan od nacina da se prenese parametar na drugu stranicu
        return view('pages.index')->with('title',$title);
    }

    public function about() {
        $title = 'About us';
        return view('pages.about')->with('title', $title);
    }
    public function services()
    {
        $data = array(
            'title' => 'Services',
            'services' => ['Web Design', 'Programming', 'CEO']
        );
        return view('pages.services')->with($data);
    }
}

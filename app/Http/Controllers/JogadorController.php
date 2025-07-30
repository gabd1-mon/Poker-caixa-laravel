<?php
namespace App\Http\Controllers;
use App\Models\Jogador;
use Illuminate\Http\Request;
use Inertia\Inertia;
class JogadorController extends Controller
{
    public function create()
    {

        return Inertia::render('Jogadores/Create');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'contato' => 'required|string|max:255',
        ]);
        Jogador::create($validatedData);
        return redirect()->route('jogadores.index');

    }

    public function index(){
        $jogadores = \App\Models\Jogador::latest()->get();

        return Inertia::render('Jogadores/Index',
            ['jogadores' => $jogadores]);

    }





}

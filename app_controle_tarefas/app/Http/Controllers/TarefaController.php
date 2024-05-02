<?php

namespace App\Http\Controllers;

use App\Exports\TarefasExport;
use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TarefaController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $tarefas = Tarefa::where('user_id', $user_id)->paginate(10);
        //Verificar se o usuário está autenticado
        if (auth()->check()) {
            return view('tarefa.index', ['tarefas' => $tarefas]);
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Create de Tarefa
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Criar as regras de tarefa
        $request->validate([
            'tarefa' => 'required|min:3|max:200',
            'data_limite_conclusao' => 'required|date',
        ], [
            'tarefa.required' => 'O campo Tarefa é obrigatório',
            'tarefa.min' => 'O campo Tarefa deve ter no mínimo 3 caracteres',
            'tarefa.max' => 'O campo Tarefa deve ter no máximo 200 caracteres',
            'data_limite_conclusao.required' => 'O campo Data limite conclusão é obrigatório',
            'data_limite_conclusao.date' => 'O campo Data limite conclusão deve ser uma data válida',
        ]);

        $dados = $request->all('tarefa', 'data_limite_conclusao');
        $dados['user_id'] = auth()->user()->id;

        // Disable the button and show loading
        echo '<script>document.getElementById("submitButton").disabled = true; document.getElementById("loading").style.display = "block";</script>';

        $tarefa = Tarefa::create($dados);
        $destinatario = auth()->user()->email;
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));

        // Enable the button and hide loading after email is sent
        echo '<script>document.getElementById("submitButton").disabled = false; document.getElementById("loading").style.display = "none";</script>';

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show(Tarefa $tarefa)
    {
        //Criar método show
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarefa $tarefa)
    {
        //Criar verificação se o usuário está editando a tarefa que é do seu usuário redirecionando se não for para view app.acesso-negado
        if (auth()->user()->id != $tarefa->user_id) {
            return view('acesso-negado');
        }
        //Criar método edit
        return view('tarefa.edit', ['tarefa' => $tarefa]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        //Criar as regras e validações dos campos de tarefa
        $request->validate([
            'tarefa' => 'required|min:3|max:200',
            'data_limite_conclusao' => 'required|date',
        ], [
            'tarefa.required' => 'O campo Tarefa é obrigatório',
            'tarefa.min' => 'O campo Tarefa deve ter no mínimo 3 caracteres',
            'tarefa.max' => 'O campo Tarefa deve ter no máximo 200 caracteres',
            'data_limite_conclusao.required' => 'O campo Data limite conclusão é obrigatório',
            'data_limite_conclusao.date' => 'O campo Data limite conclusão deve ser uma data válida',
        ]);
        if (auth()->user()->id != $tarefa->user_id) {
            return view('acesso-negado');
        }

        //Criar o método update
        $tarefa->update($request->all());
        return redirect()->route('tarefa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefa $tarefa)
    {
        //Criar método destroy
        if (auth()->user()->id != $tarefa->user_id) {
            return view('acesso-negado');
        }
        $tarefa->delete();
        return redirect()->route('tarefa.index');
    }

    public function exportacao($extensao)
    {
        $nome_arquivo = 'lista_de_tarefas';
        if (in_array($extensao, ['csv', 'xlsx', 'pdf'])) {
            return Excel::download(new TarefasExport, $nome_arquivo . '.' . $extensao);
        }
        return redirect()->route('tarefa.index');
        //Criar método exportacao
        //return Excel::download(new TarefasExport, 'tarefas.csv');
    }

    public function exportar()
    {
        $tarefas = auth()->user()->tarefas()->get();
        $pdf = Pdf::loadView('tarefa.pdf', ['tarefas' => $tarefas]);

        $pdf->setPaper('a4', 'portrait');
        //return $pdf->download('lista_de_tarefas.pdf');
        return $pdf->stream('lista_de_tarefas.pdf');
    }
}

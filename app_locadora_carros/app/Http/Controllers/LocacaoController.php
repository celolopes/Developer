<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Repositories\LocacaoRepository;
use Illuminate\Http\Request;

class LocacaoController extends Controller
{
    protected $locacao;
    public function __construct(Locacao $locacao)
    {
        $this->locacao = $locacao;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $locacaoRepository = new LocacaoRepository($this->locacao);
        if ($request->has('atributos_carros')) {
            $atributos_carros = 'carros:id,' . $request->atributos_carros;
            $locacaoRepository->selectAtributosRegistrosRelacionados($atributos_carros);
        } else {
            $locacaoRepository->selectAtributosRegistrosRelacionados('carro');
        }

        if ($request->has('atributos_clientes')) {
            $atributos_clientes = 'clientes:id,' . $request->atributos_clientes;
            $locacaoRepository->selectAtributosRegistrosRelacionados($atributos_clientes);
        } else {
            $locacaoRepository->selectAtributosRegistrosRelacionados('cliente');
        }

        if ($request->has('filtro')) {
            $locacaoRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $locacaoRepository->selectAtributos($request->atributos);
        }

        return response()->json($locacaoRepository->getResultado(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLocacaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate($this->locacao->rules(), $this->locacao->feedback());

        $locacao = $this->locacao->create(
            [
                'carro_id' => $request->carro_id,
                'cliente_id' => $request->cliente_id,
                'data_inicio_periodo' => $request->data_inicio_periodo,
                'data_final_previsto_periodo' => $request->data_final_previsto_periodo,
                'data_final_realizado_periodo' => $request->data_final_realizado_periodo,
                'valor_diaria' => $request->valor_diaria,
                'km_inicial' => $request->km_inicial,
                'km_final' => $request->km_final
            ]
        );
        return response()->json($locacao, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $locacao = $this->locacao->with('carro', 'cliente')->find($id);
        if ($locacao) {
            return response()->json($locacao, 200);
        }
        return response()->json([
            'message' => 'Impossível realizar a busca'
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Locacao $locacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLocacaoRequest  $request
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $locacao = $this->locacao->find($id);
        if (!$locacao) {
            return response()->json([
                'message' => 'Impossível realizar a atualização'
            ], 404);
        }

        if ($request->method() === 'PATCH') {
            $regrasDinamicas = array();
            foreach ($locacao->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $locacao->feedback());
        } else {
            $request->validate($locacao->rules(), $locacao->feedback());
        }

        $locacao->fill($request->all());
        return response()->json($locacao, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $locacao = $this->locacao->find($id);
        if (!$locacao) {
            return response()->json([
                'message' => 'Impossível realizar a exclusão'
            ], 404);
        }
        $locacao->delete();
        return response()->json(['msg' => 'Exclusão de locação efetuada com sucesso!'], 200);
    }
}

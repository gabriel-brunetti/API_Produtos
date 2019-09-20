<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Produto;
use Illuminate\Support\Facades\Validator;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::all();

        return response($produtos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validacao = Validator::make(request()->all(),[
            'nome' => 'required',
            'descricao' => 'required',
            'valor' => 'required'
        ]);

        if ($validacao->fails()) {
            return response($validacao->messages(), 401);
        }

        if (!empty(request('url_imagem'))) {
            // caminho completo do arquivo e onde vai ser salvo/pasta ou servidor
            $caminhoCompleto = public_path() . '/storage/uploads';
            # public_patch = C:xampp/htdocs/api_produtos/public/
            # final = C:xampp/htdocs/api_produtos/public/storage/
            $nomeArquivo = time() . '' . request('url_imagem')->extension();
            # movendo para o projeto
            request('url_imagem')->move($caminhoCompleto, $nomeArquivo);

            //  NomedoModel::create(['array','associativo com as informações que eu quero']);
            //  LEMBRE-SE PARA USAR O MODEL É IMPORTANTE DAR O USE App\NOMEDOMODEL
            $produto = Produto::create([
                // pega o input com name = 'XXXX' do form
                'nome' => request('nome'),
                'descricao' => request('descricao'),
                # /storage/uploads/algumacoisa.png
                'url_imagem' => url('/storage/uploads/' . $nomeArquivo),
                'valor' => request('valor')
            ]);
        } else {
            $produto = Produto::create([
                // pega o input com name = 'XXXX' do form
                'nome' => request('nome'),
                'descricao' => request('descricao'),
                'valor' => request('valor')
            ]);
        }

        // praticamente tudo em servidor http tem response(resposta) e request
        return response($produto, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = Produto::find($id);

        if(!$produto) {
            $erro = ['mensagem' => 'Produto não encontrado!'];
            // API SÓ RETORNA JSON POR ISSO A MENSAGEM COMO ARRAY ASSOCIATIVO
            return response(json_encode($erro), 401);
        }

        $produto->delete();

        return responde($produto, 200);
    }
}

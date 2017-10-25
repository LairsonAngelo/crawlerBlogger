<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use File;
use Illuminate\Support\Facades\Storage;

class CategoriasController extends Controller
{

	public function index(){
		$categorias = Categoria::where('id_pai','0')->paginate(15);
		$subcategorias = Categoria::where([
			['id_pai','!=','0']
		])->paginate(15);
		$categorias_select = Categoria::where('id_pai','0')->get();
		return view('admin.categoria')->with(compact('categorias','categorias_select','subcategorias'));
	}

	public function insert(Request $request)	{
		$dados = new Categoria();
		$categoria = $request->all();

		$this->validate($request,Categoria::rules());

		if($request->hasFile('caminho_imagem')){
			$destinoImagem = public_path('imagens/produtos');
			$file = $request->caminho_imagem;
			$exte = $file->getClientOriginalExtension();
			$fileName = rand(1024,9999).".".$exte;
			$file->move($destinoImagem,$fileName);
			$categoria['caminho_imagem'] = $fileName;
		}

		$dados->create($categoria);

    	return redirect('admin/categoria');

	}

	public function listagem($id)	{
		$dados = Categoria::find($id);
		return response()->json(['status' => 1, 'categoria' => $dados]);
	}

	public function update(Request $request, $id){

		$dados = Categoria::find($id);
		$valor = $request->all();

		if($request->hasFile('caminho_imagem')){

			$destinoImagem = public_path('imagens/produtos');
			$file = $request->caminho_imagem;
			$exte = $file->getClientOriginalExtension();
			$fileName = rand(1024,9999).".".$exte;
			$file->move($destinoImagem,$fileName);
			$categoria['caminho_imagem'] = $fileName;
			Storage::delete($dados->caminho_imagem);
			$dados->caminho_imagem = $valor['caminho_imagem'];
		}

		$dados->id = $valor['id'];
		$dados->nome = $valor['nome'];
		$dados->descricao = $valor['descricao'];
		$dados->save();
		return redirect('admin/categoria');
	}

	public function delete($id){

		$delete = Categoria::find($id)->first();
		Storage::delete($delete->caminho_imagem);
		$delete->delete();
		return redirect('admin/categoria');
	}


	public function insertSubcategoria(Request $request)	{
		$dados = new Categoria();
		$categoria = $request->all();

		$this->validate($request,Categoria::rulesSubcategoria());

		if($request->hasFile('caminho_imagem')){
			$destinoImagem = public_path('imagens/produtos');
			$file = $request->caminho_imagem;
			$exte = $file->getClientOriginalExtension();
			$fileName = rand(1024,9999).".".$exte;
			$file->move($destinoImagem,$fileName);
			$categoria['caminho_imagem'] = $fileName;
		}
		$dados->create($categoria);

   	    return redirect('admin/categoria');

	}

	public function updateSubcategoria(Request $request, $id){

		$dados = Categoria::find($id);
		$valor = $request->all();

		if($request->hasFile('caminho_imagem')){

			$destinoImagem = public_path('imagens/produtos');
			$file = $request->caminho_imagem;
			$exte = $file->getClientOriginalExtension();
			$fileName = rand(1024,9999).".".$exte;
			$file->move($destinoImagem,$fileName);
			$categoria['caminho_imagem'] = $fileName;
			Storage::delete($dados->caminho_imagem);
			$dados->caminho_imagem = $fileName;
		}

		$dados->id = $valor['id'];
		$dados->nome = $valor['nome'];
		$dados->descricao = $valor['descricao'];
		$dados->id_pai = $valor['id_pai'];
		$dados->save();
		return redirect('admin/categoria');
	}



}

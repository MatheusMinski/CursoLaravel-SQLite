<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curso;

class AdminCursoController extends Controller
{
    public function index(){
        $registros = Curso::all();
        return view('admin.cursos.index', compact('registros'));
    }
    public function adicionar(){
        return view ('admin.cursos.adicionar');
    }
    public function salvar(Request $req){
        $dados= $req->all();

        if(isset($dados['publicado'])){
            $dados['publicado']='sim';
        }else{
            $dados['publicado']='nao';

        }

        if($req->hasFile('imagem')){
            $imagem = $req->file('imagem');//pega a imagem dos forms
            $num = rand(1111,9999);//gera um número aleatório para usar no nome
            $dir = "img/cursos";//diz o diretório de onde será salvo
            $ex = $imagem->guessClientExtension();// pega a extensão que o cliente usou
            $nomeImagem = "imagem_".$num.".".$ex;//Cria a variável que contém o nome da imagem
            $imagem->move($dir,$nomeImagem);//move a imagem pra cá com o determinado nome
            $dados['imagem'] = $dir."/".$nomeImagem;//Manda o caminho da imagem para o banco de dados, então salvamos só o caminho no banco
        }

        Curso::create($dados);

        return redirect(route('admin.cursos'));
    }

    public function editar($id){
        $registro = Curso::find($id);
        return view('admin.cursos.editar', compact('registro'));
    }

    public function atualizar(Request $req, $id){
        $dados= $req->all();

        if(isset($dados['publicado'])){
            $dados['publicado']='sim';
        }else{
            $dados['publicado']='nao';

        }

        if($req->hasFile('imagem')){
            $imagem = $req->file('imagem');//pega a imagem dos forms
            $num = rand(1111,9999);//gera um número aleatório para usar no nome
            $dir = "img/cursos";//diz o diretório de onde será salvo
            $ex = $imagem->guessClientExtension();// pega a extensão que o cliente usou
            $nomeImagem = "imagem_".$num.".".$ex;//Cria a variável que contém o nome da imagem
            $imagem->move($dir,$nomeImagem);//move a imagem pra cá com o determinado nome
            $dados['imagem'] = $dir."/".$nomeImagem;//Manda o caminho da imagem para o banco de dados, então salvamos só o caminho no banco
        }

        Curso::find($id)->update($dados);

        return redirect(route('admin.cursos'));
    }

    public function deletar($id){
        Curso::find($id)->delete();
        return redirect()->route('admin.cursos');
    }
}

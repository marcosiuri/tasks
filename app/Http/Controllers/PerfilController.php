<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->imagem_perfil_nome) {
            $user->imagem_perfil = asset('imagens_perfil/' . $user->imagem_perfil_nome);
        }
    
        return view('perfil', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => 'nullable|min:4|confirmed',
            'imagem_perfil' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('perfil')->with('error', 'Usuário não encontrado');
        }

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('imagem_perfil')) {
            $imagem_perfil = $request->file('imagem_perfil');

            $formatos_permitidos = ['jpeg', 'png', 'jpg', 'gif'];
            $extensao = $imagem_perfil->getClientOriginalExtension();
            
            if (!in_array($extensao, $formatos_permitidos)) {
                return redirect()->route('perfil')->with('error', 'Formato de imagem não suportado. Por favor, selecione uma imagem JPEG, PNG, JPG ou GIF.')->withInput();
            }

            $imagem_existente = User::where('imagem_perfil', $imagem_perfil->hashName())->first();

            if ($imagem_existente) {
                return redirect()->route('perfil')->with('error', 'Essa imagem já foi usada. Por favor, selecione outra imagem.')->withInput();
            }

            $nome_arquivo = time() . '.' . $imagem_perfil->getClientOriginalExtension();
            $caminho = public_path('imagens_perfil');
            $imagem_perfil->move($caminho, $nome_arquivo);

            $user->imagem_perfil = $nome_arquivo;
        }

        $user->save();

        $mensagem = ($request->hasFile('imagem_perfil')) ? 'Perfil atualizado com sucesso!' : null;

        return redirect()->route('perfil')->with('success', $mensagem);
    }



}

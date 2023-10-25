<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    public function showRegistrationForm() {
        $users = User::all();
        return view('cadastro');
    }

    public function cadastropost(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        if (Auth::attempt($credentials)) {
            return redirect()->intended($this->redirectTo());
        }
        
        return redirect()->back()->withErrors(['message' => 'Acesso negado']);
    }

    public function cadastro(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => ['required', 'min:4', 'confirmed'], 
        ], [
            'username.required' => 'O campo nome de usuário é obrigatório',
            'username.unique' => 'O nome de usuário já está em uso',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos :min caracteres',
            'password.confirmed' => 'A senha e a confirmação de senha devem ser iguais',
        ]);

        $user = new User;
        $user->name = $request->input('username');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        Auth::login($user);

        return redirect()->route('main')->with('success', 'Usuário cadastrado com sucesso!');
    }
}




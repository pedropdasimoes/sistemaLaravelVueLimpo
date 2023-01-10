<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;

class UsuarioController extends Controller
{
    private $objUsuario;

    public function __construct()
    {
        $this->objUsuario = new User();
    }

    //funções compartilhadas
    public function pegaPermissao($valor, $tipo)
    {
        $valorReturn = null;
        if ($tipo == 'permissao') {
            switch ($valor) {
                case 0:
                    $valorReturn = '0';
                    break;
                case 1:
                    $valorReturn = '0-1-2-3-4-5-6';
                    break;
                case 2:
                    $valorReturn = '0-1-2-4-6';
                    break;
                case 3:
                    $valorReturn = '0-1-6';
                    break;
                case 4:
                    $valorReturn = '0-3-6';
                    break;
                case 5:
                    $valorReturn = '0-1-2-3-4-5-6-7';
                    break;
            }
        } elseif ($tipo == 'nivel') {
            switch ($valor) {
                case '0':
                    $valorReturn = 0;
                    break;
                case '0-1-2-3-4-5-6':
                    $valorReturn = 1;
                    break;
                case '0-1-2-4-6':
                    $valorReturn = 2;
                    break;
                case '0-1-6':
                    $valorReturn = 3;
                    break;
                case '0-3-6':
                    $valorReturn = 4;
                    break;
                case '0-1-2-3-4-5-6-7':
                    $valorReturn = 5;
                    break;
            }
        } elseif ($tipo == 'nome') {
            switch ($valor) {
                case '0':
                    $valorReturn = 'Super Administrador';
                    break;
                case '0-1-2-3-4-5-6':
                    $valorReturn = 'Administrador';
                    break;
                case '0-1-2-4-6':
                    $valorReturn = 'Editor';
                    break;
                case '0-1-6':
                    $valorReturn = 'Visualizador Dados';
                    break;
                case '0-3-6':
                    $valorReturn = 'Visualizador Denuncia';
                    break;
                case '0-1-2-3-4-5-6-7':
                    $valorReturn = 'Desenvolvedor';
                    break;
            }
        }
        return $valorReturn;
    }

    public function renderListarUsuarios($solicitante)
    {
        $userAuth = auth()->user();
        if (str_contains($userAuth->permission, 5)) {

            $arrayUsuarios = $this->objUsuario->all();
            foreach ($arrayUsuarios as $usuario) {
                $usuario->permission = $this->pegaPermissao($usuario->permission, 'nome');
            }
            if ($solicitante == 'view') {
                return Inertia::render('Usuarios/Listar', [
                    'usuarios' => $arrayUsuarios,
                ]);
            } elseif ($solicitante == 'deletado') {
                return Inertia::render('Usuarios/Listar', [
                    'usuarios' => $arrayUsuarios,
                    'deleted' => 'Usuário deletado com sucesso!'
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Admin/Erro/Permissao');
        }
    }
    public function listarUsuarios()
    {
        $userAuth = auth()->user();
        if (str_contains($userAuth->permission, 5)) {
            return $this->renderListarUsuarios('view');
        } else {
            return Inertia::render('Admin/Erro/Permissao');
        }
    }
    public function renderViewCriarUsuarios($solicitante)
    {

        $userAuth = auth()->user();
        if (str_contains($userAuth->permission, 5)) {

            if ($solicitante == 'view') {
                return Inertia::render('Usuarios/Criar', [
                    'btnSalvar' => true,
                    'btnAdd' => false
                ]);
            } elseif ($solicitante == 'criado') {
                return Inertia::render('Usuarios/Criar', [
                    'success' => 'Usuário criado com sucesso!',
                    'btnAdd' => true,
                    'btnSalvar' => false,
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Admin/Erro/Permissao');
        }
    }
    public function createUsuarios(Request $request)
    {
        $userAuth = auth()->user();
        if (str_contains($userAuth->permission, 5)) {
            $validated = $request->validate([
                'email' => 'required|min:2|unique:users,email',
                'nome' => 'required|min:2',
                'novaSenha' => 'required|min:8',
                'tipoUsuario' => 'required'
            ]);

            $permissaoUsuario = $this->pegaPermissao($request->tipoUsuario, 'permissao');

            try {
                $this->objUsuario->create([
                    'name' => $request->nome,
                    'email' => $request->email,
                    'permission' => $permissaoUsuario,
                    'password' => bcrypt($request->novaSenha),
                    'current_team_id' => 2
                ]);
            } catch (Throwable $e) {
                report($e);
                dd($e);

                return false;
            }

            return $this->renderViewCriarUsuarios('criado');
        } else {
            return Inertia::render('Admin/Erro/Permissao');
        }
    }
    public function criarUsuarios()
    {
        $userAuth = auth()->user();
        if (str_contains($userAuth->permission, 5)) {
            return $this->renderViewCriarUsuarios('view');
        } else {
            return Inertia::render('Admin/Erro/Permissao');
        }
    }
    public function deletarUsuarios(Request $request)
    {
        $userAuth = auth()->user();
        if (str_contains($userAuth->permission, 5)) {
            $usuario = $this->objUsuario->find($request->id);
            $usuario->delete();

            return $this->renderListarUsuarios('deletado');
        } else {
            return Inertia::render('Admin/Erro/Permissao');
        }
    }
    public function renderEditarUsuarios($solicitante, $id)
    {

        $userAuth = auth()->user();
        if (str_contains($userAuth->permission, 5)) {

            $usuario = $this->objUsuario->find($id);
            $nivelUsuario = $this->pegaPermissao($usuario->permission, 'nivel');
            if ($solicitante == 'view') {
                return Inertia::render('Usuarios/Editar', [
                    'usuario' => $usuario,
                    'nivelUsuario' => $nivelUsuario,
                    'btnSalvar' => true,
                    'btnAdd' => false
                ]);
            } elseif ($solicitante == 'editado') {
                return Inertia::render('Usuarios/Editar', [
                    'usuario' => $usuario,
                    'nivelUsuario' => $nivelUsuario,
                    'success' => 'Usuário alterado com sucesso!',
                    'btnSalvar' => false,
                    'btnAdd' => true
                ]);
            } else {
                return Inertia::render('Unis/Erro/Erro');
            }
        } else {
            return Inertia::render('Admin/Erro/Permissao');
        }
    }
    public function editarUsuarios($id)
    {
        $userAuth = auth()->user();
        if (str_contains($userAuth->permission, 5)) {
            return $this->renderEditarUsuarios('view', $id);
        } else {
            return Inertia::render('Admin/Erro/Permissao');
        }
    }
    public function editUsuarios(Request $request)
    {
        $userAuth = auth()->user();
        if (str_contains($userAuth->permission, 5)) {
            $usuario = $this->objUsuario->find($request->id);

            if ($usuario->email != $request->email) {
                $validated = $request->validate([
                    'email' => 'required|min:2|unique:users,email',
                ]);
            }
            $validated = $request->validate([
                'nome' => 'required|min:2',
            ]);

            $nivelUsuario = $this->pegaPermissao($request->tipoUsuario, 'permissao');

            if ($request->novaSenha != null) {
                $validated = $request->validate([
                    'novaSenha' => 'required|min:8',
                ]);
                $usuario->update([
                    'name' => $request->nome,
                    'title' => $request->titulo,
                    'email' => $request->email,
                    'permission' => $nivelUsuario,
                    'password' => bcrypt($request->novaSenha),
                    'current_team_id' => 2
                ]);
            } else {
                $usuario->update([
                    'name' => $request->nome,
                    'title' => $request->titulo,
                    'email' => $request->email,
                    'permission' => $nivelUsuario,
                    'current_team_id' => 2
                ]);
            }

            return $this->renderEditarUsuarios('editado', $request->id);
        } else {
            return Inertia::render('Admin/Erro/Permissao');
        }
    }
    public function visualizarUsuarios($id)
    {
        $userAuth = auth()->user();
        if (str_contains($userAuth->permission, 5)) {
            $usuario = $this->objUsuario->find($id);
            $usuario->permission = $this->pegaPermissao($usuario->permission, 'nome');
            return Inertia::render('Usuarios/Visualizar', [
                'usuario' => $usuario,
            ]);
        } else {
            return Inertia::render('Admin/Erro/Permissao');
        }
    }

    public function alterTheme(Request $request)
    {
        $userAuth = auth()->user();
        if (str_contains($userAuth->permission, 5)) {
            $usuario = $this->objUsuario->find($userAuth->id);
            try {
                $usuario->update([
                    'theme' => $request->theme,
                ]);
            } catch (Throwable $e) {
                report($e);
                dd($e);            
                return ['status' => false, 'request' => $userAuth];
            }            
            return ['status' => true, 'request' => $userAuth];
        }
    }
}

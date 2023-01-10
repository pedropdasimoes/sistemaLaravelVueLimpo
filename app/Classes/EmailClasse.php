<?php

namespace App\Classes;

use App\Jobs\EmailDenunciaCompliance;
use App\Jobs\EmailDenunciaLgpd;
use App\Models\User;
use stdClass;
use Illuminate\Support\Facades\Mail;
use App\Jobs\UsuarioCriado;
use Illuminate\Support\Facades\URL;

class EmailClasse
{

    private $objUser;

    public function __construct()
    {
        $this->objUser = new User();
    }

    // public function testeEmail($id)
    // {
    //     $data = new stdClass();
    //     $userData = new stdClass();
    //     $vagaData = new stdClass();

    //     $user = $this->objUser->find($id);
    //     $vaga = $this->objVaga->find($id);
    //     $userData->name = $user->name;
    //     $userData->email = $user->email;

    //     $vagaData->name = $vaga->cargo;

    //     $data->user = $userData;
    //     $data->vaga = $vagaData;


    //     //Mail::send(new \App\Mail\VagasPendentes($data));
    //     return new \App\Mail\VagaAprovada($data);
    // // dispatch(new VagasPendentes($data))->delay(now()->addSecond(3));
    // // return 'ok';
    // }

    // public function emailPendencias($id)
    // {
    //     $data = new stdClass();
    //     $userData = new stdClass();
    //     $pendencias = array();



    //     $user = $this->objUser->find($id);
    //     $vagaAll = $this->objVaga->all();
    //     foreach ($vagaAll as $vaga) {
    //         if ($vaga->status == 0) {
    //             $nivelVaga = $vaga->user_id;
    //             $nivelVaga = $this->objUser->where('user_id', $nivelVaga)->get();
    //             $nivelVaga = explode('-', $nivelVaga[0]['nivel']);
    //             if (in_array($user->id, $nivelVaga)) {
    //                 $aprovacoesVaga = explode('-', $vaga->aprovacao_gestores);
    //                 if (!in_array($user->id, $aprovacoesVaga)) {
    //                     $pendencias[] = $vaga->cargo;
    //                 }
    //             }
    //         }
    //     }

    //     $userData->name = $user->name;
    //     $userData->email = $user->email;

    //     $data->user = $userData;
    //     $data->pendencias = $pendencias;

    //     dispatch(new VagasPendentes($data))->delay(now()->addSecond(3));
    // }

    public function denunciaComplianceCadastrada($dados)
    {
        $data = new stdClass();
        $urlLaravel = URL::to("/");
        $urlDenuncia = $urlLaravel . "/visualizar-denuncia/" . $dados;

        $usuarios = $this->objUser->all();
        foreach ($usuarios as $usuario){
            if (str_contains($usuario->permission, '7')){
                $data = new stdClass();
                $contato = new stdClass();

                $contato->name = $usuario->name;
                $contato->email = $usuario->email;

                $data->contato = $contato;
                $data->link = $urlDenuncia;

                dispatch(new EmailDenunciaCompliance($data))->delay(now()->addSecond(3));

            }
        }
        
    }

    public function denunciaLgpdCadastrada($dados)
    {
        $data = new stdClass();
        $urlLaravel = URL::to("/");
        $urlDenuncia = $urlLaravel . "/visualizar-denuncia/" . $dados;

        $usuarios = $this->objUser->all();
        foreach ($usuarios as $usuario){
            if (str_contains($usuario->permission, '7')){
                $data = new stdClass();
                $contato = new stdClass();

                $contato->name = $usuario->name;
                $contato->email = $usuario->email;

                $data->contato = $contato;
                $data->link = $urlDenuncia;

                dispatch(new EmailDenunciaLgpd($data))->delay(now()->addSecond(3));

            }
        }
    }
}
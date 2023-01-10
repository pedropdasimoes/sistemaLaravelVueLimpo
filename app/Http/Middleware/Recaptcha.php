<?php

namespace App\Http\Middleware;

use App\Http\Controllers\PainelInicialController;
use Closure;
use Illuminate\Http\Request;
use ReCaptcha\ReCaptcha as GoogleRecaptcha;

class Recaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = (new GoogleRecaptcha(config('recaptchav2.secret')))
        ->verify($request->recaptcha, $request->ip());
        
        if (!$response->isSuccess()) {
            switch($request->localReacaptcha){
                case 'denuncia':
                    return (new PainelInicialController)->renderviewFormDenuncia('erroRecaptcha');
                    break;
                case 'buscaDados':
                    return (new PainelInicialController)->renderFormBuscaDados('erroRecaptcha');
                    break;
                default:
                    return (new PainelInicialController)->renderFormBuscaDados('erroRecaptcha');
            }
        }
        
        return $next($request);
    }
}

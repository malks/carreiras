<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use App\User;


//Se usuário for admin, segue para a rota, senão, encaminha para /profile, para garantir que não acessem áreas administrativas do sistema
class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        foreach ($request->user()->roles as $user_role){
            if ("admin"==$user_role->name)
                return $next($request);
        }

        return redirect("/profile");
    }
}

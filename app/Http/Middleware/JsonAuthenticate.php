<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // İsteğin Accept başlığını JSON olarak ayarla
        $request->headers->set('Accept', 'application/json');

        // Kullanıcının giriş yapıp yapmadığını kontrol et
        if (auth()->check()) {
            return $next($request);
        }

        // Eğer JSON yanıt bekleniyorsa, uygun bir hata yanıtı döndür
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Please log in to access this resource.'], Response::HTTP_UNAUTHORIZED);
        }

        // Varsayılan olarak JSON yanıt döndür
        return response()->json(['message' => 'Please log in to access this resource.'], Response::HTTP_UNAUTHORIZED);
    }
}

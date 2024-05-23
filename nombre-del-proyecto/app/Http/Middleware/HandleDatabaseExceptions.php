<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\QueryException;
use PDOException;

class HandleDatabaseExceptions
{
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (QueryException | PDOException $e) {
            return response()->view('errors.server_unavailable', [], 500);
        }
    }
}

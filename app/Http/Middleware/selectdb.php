<?php

namespace App\Http\Middleware;

use Closure;

use Config;

use Debugbar;
use App\Hub;

class selectdb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //run only on subdomains
        if (substr_count($request->server('HTTP_HOST'), '.') == 2) {
            $hub = Hub::where('name', '=', str_replace(env('SESSION_DOMAIN'), '',$request->server('HTTP_HOST')))->first();

            if (!$hub) {
                // hub does not exist
                flash('Hub does not exist!')->warning();
                return redirect(env('APP_URL'));
            } else {
                Config::set("database.connections." . env('DB_DATABASE') . "_" . $hub->name, array(
                    'driver'    => 'mysql',
                    'host'      => 'localhost',
                    'database'  => env('DB_DATABASE') . "_" . $hub->name,
                    'username'  => env('DB_DATABASE') . "_" . $hub->name,
                    'password'  => $hub->password,
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => '',
                ));

                Config::set('database.default', env('DB_DATABASE') . "_" . $hub->name);
 
            }
        }

        Debugbar::info(Config::get('database.default'));

        return $next($request);
        
    }
}
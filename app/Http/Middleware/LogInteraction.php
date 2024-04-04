<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\InteractionLog; // Asegúrate de importar el modelo InteractionLog

class LogInteraction
{
    private function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = null;

        return $ipaddress;
    }

    public function handle(Request $request, Closure $next)
    {
        $service = $request->url();
        $requestData = $request->all();
        $response = $next($request);
        $responseCode = $response->status();
        $responseData = $response->content();
        $ipAddress = $this->get_client_ip();
        $responseDecode = json_decode($response->content());

        $userId = null;
        if (isset($responseDecode->user_id)) {
            $userId = $responseDecode->user_id;
        } elseif (isset($responseDecode->id)) {
            $userId = $responseDecode->id;
        } else {
            $user = $request->user();
            if ($user) {
                $userId = $user->id;
            }
        }
        InteractionLog::create([
            'user_id' => $userId,
            'service' => $service,
            'request_data' => json_encode($requestData),
            'response_code' => $responseCode,
            'response_data' => $responseData,
            'ip_address' => $ipAddress,
        ]);

        return $response;
    }
}

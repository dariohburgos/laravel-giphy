<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FavoriteGif;
use Auth;


class GiphyController extends Controller
{

    public function search(Request $request)
    {
        $query = $request->query('query');
        $limit = $request->query('limit', 5);
        $offset = $request->query('offset', 0);
        $rating = $request->query('rating', 'g');
        $lang = $request->query('lang', 'es');
        $bundle = $request->query('bundle', 'clips_grid_picker');

        $response = Http::get('https://api.giphy.com/v1/gifs/search', [
            'q' => $query,
            'limit' => $limit,
            'offset' => $offset,
            'rating' => $rating,
            'lang' => $lang,
            'bundle' => $bundle,
            'api_key' => env('GIPHY_API_KEY')
        ]);

        return $response->json();
    }
    public function storeFavoriteGif(Request $request)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtiene el ID del usuario autenticado
            $userId = Auth::id(); // Esto te dará el ID del usuario autenticado
        } else {
            // Si el usuario no está autenticado, puedes manejar el caso aquí
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }
        $gifId = $request->input('gif_id'); // Obtiene el ID del GIF desde la solicitud

        // Crea una nueva instancia del modelo FavoriteGif y guarda en la base de datos
        FavoriteGif::create([
            'user_id' => $userId,
            'gif_id' => $gifId,
        ]);

        return response()->json(['message' => 'GIF favorito guardado con éxito'], 201);
    }
}

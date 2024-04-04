<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class GiphyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_endpoint_returns_expected_data()
    {
        // Leer el archivo JSON de la respuesta mockeada
        $responseJson = File::get(base_path('tests/mock_data/giphy_response.json'));
        $responseData = json_decode($responseJson, true);

        // Mockear la respuesta de la API de Giphy
        Http::fake([
            'https://api.giphy.com/v1/gifs/search*' => Http::response($responseData, 200),
        ]);

        // Realizar la solicitud a tu endpoint
        $response = $this->get('/giphy/search?query=cat');

        // Verificar que la solicitud fue exitosa
        $response->assertStatus(200);

        // Verificar que la respuesta contiene los datos esperados
        $response->assertJson($responseData);
    }
}

<?php

namespace Tests\Unit\Http\Middleware;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Middleware\LogInteraction;
use App\Models\InteractionLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogInteractionTest extends TestCase
{
    use RefreshDatabase; // Este trait permite que se refresque la base de datos antes de cada prueba
 
}

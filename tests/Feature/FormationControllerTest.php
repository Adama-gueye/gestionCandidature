<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormationControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testListeDesFormations()
    {
        $response = $this->get('/api/formations');

        $response->assertStatus(200);
    }
}

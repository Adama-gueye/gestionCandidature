<?php

namespace Tests\Feature;

use App\Models\Candidat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class MyTest extends TestCase
{
    //use RefreshDatabase;

    //liste des candidatures
    public function test_list_candidatures_as_admin(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);

        $response = $this->get('/api/candidats');

        $response->assertStatus(200);
    }
    //liste des formations
    
    public function testRouteFormations(): void
    {
        $response = $this->get('/api/formations');

        $response->assertStatus(200);
    }

    // écrire des tests pour valider les règles de validation du modèle “Candidat” : 
    // s'assurer que l'email est unique.
    // s’assurer que son prenom est un string
    
   /* public function testRegister(): void
    {
        $response = $this->json('POST', 'api/register', [
            'nom' => 'Gueye',
            'prenom' => 'Adama',
            'tel' => '775003108',
            'age' => 12,
            'email' => 'cc@gmail.com',
            'password' => 'passer123',
            'role' => 'candidat',
        ]);
    
        $response->assertStatus(201);
    
        $this->assertDatabaseHas('users', [
            'nom' => 'Gueye',
            'prenom' => 'Adama',
            'tel' => '775003108',
            'age' => 12,
            'email' => 'cc@gmail.com',
            'role' => 'candidat',
        ]);
    
        $duplicateResponse = $this->json('POST', 'api/register', [
            'nom' => 'AutreNom',
            'prenom' => 'AutrePrenom',
            'tel' => '775003109',
            'age' => 20,
            'email' => 'cc@gmail.com',
            'password' => 'autreMotDePasse',
            'role' => 'candidat',
        ]);
    
        $duplicateResponse->assertStatus(401);
    }
    */

    // créer des tests pour les différentes actions 
    // des contrôleurs liés aux candidatures : par exemple, 
    // le processus d'enregistrement, accepter une candidature, etc
    public function changeEtat($id)
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);
        $candidat = Candidat::find($id);

        $response = $this->json('POST', "api/changeEtat{$candidat->id}");

    $response->assertStatus(201)
             ->assertJson("Candidat accepté");

    $this->assertDatabaseHas('candidats', ['id' => $candidat->id, 'etat' => 'accepter']);
        if ($candidat) {
            if ($candidat->etat === 'refuser') {
                $candidat->etat = 'accepter';
                return response()->assertStatus("Candidat accepeter", 201);
            }
            
        } else {
            return response()->assertStatus("Candidat non trouvé", 404);
        }
    }


    // écrire des tests pour s'assurer que le processus
    // d'authentification des candidats et des administrateurs fonctionne correctement

    public function login(Request $request)
    {
        $response = $this->json('POST', 'api/auth/login', [
            'email' => 'adamagu99@gmail.com',
            'password' => 'Ada20865',
        ]);
    
        $response->assertStatus(201);

     //   return $this->respondWithToken($token);
    }
    

}

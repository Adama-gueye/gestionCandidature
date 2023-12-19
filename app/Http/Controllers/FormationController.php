<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Exception;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      title="Formation documentation", 
 *      version="0.1",
 * )
 */
class FormationController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/formations",
     *     summary="Retourne toutes les formations",
     *     tags={"Formations"},
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="formations", type="array", @OA\Items(ref="#/components/schemas/Formation"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $formations = Formation::all();
        return response()->json(compact('formations'), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/formations",
     *     summary="Enregistre une nouvelle formation",
     *     tags={"Formations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="duree", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="etat", type="string"),
     *             @OA\Property(property="date_debut", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Success"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function store(Request $request)
    {
        try {
            $request->validate($this->rules(), $this->messages());

            $formation = new Formation();
            $formation->nom = $request->nom;
            $formation->duree = $request->duree;
            $formation->description = $request->description;
            $formation->etat = $request->etat;
            $formation->date_debut = $request->date_debut;

            $formation->save();

            return response()->json("success','formation Enregistrer avec success", 201);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/formations/{id}",
     *     summary="Retourne une formation spécifique",
     *     tags={"Formations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la formation",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function show($id)
    {
        $formation = Formation::find($id);
        if ($formation) {
            return response()->json(compact('formation'), 200);
        } else {
            return response()->json("Formation non trouvée", 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/formations/{id}",
     *     summary="Modifie une formation existante",
     *     tags={"Formations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la formation",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="duree", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="etat", type="string"),
     *             @OA\Property(property="date_debut", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function update(Request $request, $id)
    {
        $formation = Formation::find($id);
        if ($formation) {
            $request->validate($this->rules(), $this->messages());

            $formation->nom = $request->nom;
            $formation->duree = $request->input('duree');
            $formation->description = $request->input('description');
            $formation->etat = $request->etat;
            $formation->date_debut = $request->date_debut;
            $formation->save();

            return response()->json("success','formation modifiée avec success", 200);
        } else {
            return response()->json("Formation non trouvée", 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/formations/{id}",
     *     summary="Supprime une formation existante",
     *     tags={"Formations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la formation",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function destroy($id)
    {
        $formation = Formation::find($id);
        if ($formation) {
            $formation->delete();
            return response()->json("success','formation supprimée avec success", 200);
        } else {
            return response()->json("Formation non trouvée");
        }
    }
}
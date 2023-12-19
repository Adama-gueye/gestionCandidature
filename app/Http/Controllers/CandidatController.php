<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\CandidatForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      title="Candidat documentation", 
 *      version="0.1",
 * )
*/

class CandidatController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/candidats",
     *     summary="Retourne tous les candidats",
     *     tags={"Candidats"},
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="accepter", type="array", @OA\Items(ref="#/components/schemas/Candidat")),
     *             @OA\Property(property="refuser", type="array", @OA\Items(ref="#/components/schemas/Candidat")),
     *             @OA\Property(property="candidats", type="array", @OA\Items(ref="#/components/schemas/Candidat"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $accepter = Candidat::all()->where('etat', 'accepter');
        $refuser = Candidat::all()->where('etat', 'refuser');
        $candidats = Candidat::all();
        return response()->json(compact('accepter', 'refuser', 'candidats'), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/candidats/accepter",
     *     summary="Retourne les candidats acceptés",
     *     tags={"Candidats"},
     *     @OA\Response(response=200, description="Succès")
     * )
     */
    public function candidatAccepter()
    {
        $accepter = Candidat::all()->where('etat', 'accepter');
        return response()->json(compact('accepter'), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/candidats/refuser",
     *     summary="Retourne les candidats refusés",
     *     tags={"Candidats"},
     *     @OA\Response(response=200, description="Succès")
     * )
     */
    public function candidatRefuser()
    {
        $refuser = Candidat::all()->where('etat', 'refuser');
        return response()->json(compact('refuser'), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/candidats",
     *     summary="Enregistre un nouveau candidat",
     *     tags={"Candidats"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="niveauEtude", type="string"),
     *             @OA\Property(property="formation_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Success"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function store(Request $request)
    {
        $candidat = new Candidat();
        $candidatForm = new CandidatForm();
        $user = Auth::user();
        $candidat->niveauEtude = $request->niveauEtude;
        $candidat->etat = "refuser";
        $candidat->user_id = $user->id;
        $candidatForm->formation_id = $request->formation_id;
        $candidatForm->candidat_id = $user->id;
        $candidat->save();
        $candidatForm->save();

        return response()->json("enregistrer avec succès", 201);
    }

    /**
     * @OA\Post(
     *     path="/api/candidats/{id}/changeEtat",
     *     summary="Change l'état d'un candidat",
     *     tags={"Candidats"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du candidat",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=201, description="Success"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    public function changeEtat($id)
    {
        $user = Auth::user();
        $candidat = Candidat::find($id);
        if ($candidat) {
            if ($candidat->etat === 'accepter') {
                $candidat->etat = 'refuser';
            } else {
                $candidat->etat = 'accepter';
                $candidat->save();
                return response()->json("success", 201);
            }
        } else {
            return response()->json("Candidat non trouvé", 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllergyCollection;
use App\Http\Resources\AllergyResource;
use App\Models\Allergy;
use Illuminate\Http\Request;

class AllergyController extends Controller
{
    public function index(Request $request): AllergyCollection
    {
        return new AllergyCollection(
            Allergy::paginate($request->get('per_page', 10))
        );
    }

    public function show(Allergy $allergy): AllergyResource
    {
        return new AllergyResource($allergy);
    }
}

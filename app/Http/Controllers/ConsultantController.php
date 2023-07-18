<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Consultant;

class ConsultantController extends Controller
{
    public function create(Request $request)
    {
        if (Auth::check()) {
            $this->validate($request, [
                'name' => 'required',
            ]);
            Consultant::create($request->all());
        }
        return back();
    }

    public function delete($id)
    {
        if (Auth::check()) {
            $dog = Consultant::find($id);
            $dog->delete();
        }

        return back();
    }
}

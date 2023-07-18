<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function create(Request $request)
    {
        if (Auth::check()) {
            $this->validate($request, [
                'name' => 'required',
            ]);
            Service::create($request->all());
        }
        return to_route('index');
    }

    public function delete($id)
    {
        if (Auth::check()) {
            $service = Service::find($id);
            $service->delete();
        }

        return to_route('index');
    }
}

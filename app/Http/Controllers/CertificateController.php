<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Certificate;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Certificates/Index', [
            'certificates' => Certificate::all(),
            //'certificates' => Certificate::paginate(10),
            //'certificates' => Certificate::select('name','description')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('Certificates/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        Certificate::create($request->all());
        return redirect()->route('certificates.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $certificate)
    {
        //
        return Inertia::render('Certificates/Edit', [
            'certificate' => $certificate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        //Certificate::update($request->all());
        $certificate->update($request->all());
        return redirect()->route('certificates.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $certificate)
    {
        //
        $certificate->delete();
        return Inertia::render('Certificates/Index', [
            'certificates' => Certificate::all(),
        ]);
    }
}

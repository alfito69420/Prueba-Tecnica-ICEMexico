<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Certificate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    public function enroll(Request $request, Certificate $certificate)
    {
        $user = $request->user();

        // Verifica si el usuario ya está enrolado para evitar duplicados
        // if (!$user->certificates()->where('certificate_id', $certificate->id)->exists()) {
        //     $user->certificates()->attach($certificate->id, [
        //         'enrolled_at' => now(),
        //         'status' => 'not evaluated'
        //     ]);
        // }

        // Verifica si el usuario ya se inscribió en el certificado.
        if ($user->certificates()->where('certificate_id', $certificate->id)->exists()) {
            return redirect()->back()->with('warning', 'Ya estás registrado en este certificado.');
        }

        // Si no está inscrito, procede a inscribirlo.
        $user->certificates()->attach($certificate->id, [
            'enrolled_at' => now(),
            'status'      => 'not evaluated',
        ]);

        //return redirect()->back()->with('success', 'Inscripción realizada correctamente.');
        
        return redirect()->back()->with('success', 'Te has inscrito exitosamente.');
    }

    public function myCertificates(Request $request)
    {
        $certificates = $request->user()->certificates()
            ->withPivot('status', 'enrolled_at') // Asegura que se incluya el campo pivot
            ->get(); // Relación many-to-many

        return Inertia::render('Certificates/MyCertificates', [
            'certificates' => $certificates,
        ]);
    }


    public function deleteSubscription(Request $request, Certificate $certificate)
    {
        $user = $request->user();
        $user->certificates()->detach($certificate->id);
        return redirect()->back()->with('success', 'Inscripción eliminada correctamente.');
    }
}

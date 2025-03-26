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
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role->rol == 'administrador') {
            // Vista para administradores
            return Inertia::render('Certificates/admin/Index', [
                'certificates' => Certificate::all(),
                'userRole' => $user->role->rol,
            ]);
        }

        return Inertia::render('Certificates/user/Index', [
            'certificates' => Certificate::all(),
            'userRole' => $user->role->rol,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Certificates/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        return Inertia::render('Certificates/Edit', [
            'certificate' => $certificate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
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
        $certificate->delete();
        return Inertia::render('Certificates/Index', [
            'certificates' => Certificate::all(),
        ]);
    }

    public function enroll(Request $request, Certificate $certificate)
    {
        $user = $request->user();

        // Verifica si el usuario ya se inscribió en el certificado.
        if ($user->certificates()->where('certificate_id', $certificate->id)->exists()) {
            return redirect()->back()->with('warning', 'Ya estás registrado en este certificado.');
        }

        // Si no está inscrito, procede a inscribirlo.
        $user->certificates()->attach($certificate->id, [
            'enrolled_at' => now(),
            'status'      => 'not evaluated',
        ]);
        
        return redirect()->back()->with('success', 'Te has inscrito exitosamente.');
    }

    public function myCertificates(Request $request)
    {
        $user = $request->user();

        $roleName = $user->role->rol;

        //dd($roleName); // Verifica si el valor es correcto

        $certificates = $request->user()->certificates()
            ->withPivot('status', 'enrolled_at')
            ->get();

        return Inertia::render('Certificates/user/MyCertificates', [
            'certificates' => $certificates,
        ]);
    }

    public function deleteSubscription(Request $request, Certificate $certificate)
    {
        $user = $request->user();
        $user->certificates()->detach($certificate->id);
        return redirect()->back()->with('success', 'Inscripción eliminada correctamente.');
    }

    public function show(Request $request)
    {
        $user = $request->user();
        // Obtener todos los certificados junto con los usuarios inscritos y sus pivotes (status y enrolled_at)
        $certificates = Certificate::with(['users' => function ($query) {
            $query->select('users.id', 'users.name', 'users.email')
                ->withPivot('status', 'enrolled_at');
        }])->get();

        return Inertia::render('Certificates/admin/student', [
            'certificates' => $certificates,
            'userRole' => $user->role->rol,
        ]);
    }
}

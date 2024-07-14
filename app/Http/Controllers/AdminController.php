<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    
    
    public function showLoginForm()
    {
        return view('login'); 
    }


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Static credentials
        $staticUsername = 'admin';
        $staticPassword = 'password123';

        if ($request->username === $staticUsername && $request->password === $staticPassword) {
            Session::put('admin', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    
    public function index()
    {
        if (!Session::has('admin')) {
            return redirect()->route('admin.login');
        }

        $students = Student::all();
        return view('dashboard', compact('students'));
    }

    
    public function updateAdmittedStatus(Request $request, $id)
    {
        if (!Session::has('admin')) {
            return redirect()->route('admin.login');
        }

        $student = Student::findOrFail($id);
        $student->admitted_status = $request->has('admitted');
        $student->save();

        return redirect()->back()->with('success', 'Admitted status updated successfully.');
    }

    
    

    public function logout(Request $request)
{
    Session::forget('admin');
    return redirect()->route('admin.login');
}
}

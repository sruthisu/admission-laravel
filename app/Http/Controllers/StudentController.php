<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students|max:255',
            'gender' => 'required|in:male,female',
            'age' => 'required|integer|min:1|max:150',
            'address' => 'required|string|max:500',
            'tc' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'marksheet' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        
        $tcPath = $request->file('tc')->store('public/transfer_certificate');
        if (!$tcPath) {
            return redirect()->back()->with('error', 'Failed to upload TC');
        }
    

       
        $marksheetPath = $request->file('marksheet')->store('public/marksheet');

        // Create a new student record in the database
        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'age' => $request->age,
            'address' => $request->address,
            'tc' => $tcPath,
            'marksheet' => $marksheetPath,
            
        ]);

        // Redirect back with success message
        return redirect('/')->with('success', 'Admission form submitted successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->admitted_status = $request->has('admitted');
        $student->save();

        return redirect()->back()->with('success', 'Student status updated successfully.');
    }

    public function showAdmittedStudents()
    {
        $admittedStudents = Student::where('admitted_status', 1)->get();
        return view('admitted', compact('admittedStudents'));
    }
}


<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);


        try {
            $import = new UsersImport();
            Excel::import($import, $request->file('file'));

            if ($errors = $import->getErrors()) {
                return redirect('/dashboard')->with('error', implode(', ', $errors));
            }
            session()->flash('success', 'Your data Imported successfully!');
            return redirect('/dashboard');
        } catch (\Exception $e) {
            return redirect('/dashboard')->with('error', $e->getMessage());
        }
    }
}

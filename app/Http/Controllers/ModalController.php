<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Employee;

class ModalController extends Controller
{
    public function translate($txt) {
        return response()->json(trans($txt), 200);
    }

    public function companies() {
        return response()->json(Company::all(), 200);
    }

    public function employees() {
        return response()->json(Employee::all(), 200);
    }
}

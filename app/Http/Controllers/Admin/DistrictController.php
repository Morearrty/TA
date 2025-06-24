<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::withCount('members')->paginate(10);
        return view('admin.districts.index', compact('districts'));
    }

    public function create()
    {
        return view('admin.districts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:districts,code'
        ]);

        District::create($validated);
        return redirect()->route('admin.districts.index')->with('success', 'District created successfully');
    }

    public function edit(District $district)
    {
        return view('admin.districts.edit', compact('district'));
    }

    public function update(Request $request, District $district)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:districts,code,' . $district->id
        ]);

        $district->update($validated);
        return redirect()->route('admin.districts.index')->with('success', 'District updated successfully');
    }

    public function destroy(District $district)
    {
        // Check if district has members
        if ($district->members()->count() > 0) {
            return redirect()->route('admin.districts.index')->with('error', 'Cannot delete district with members');
        }

        $district->delete();
        return redirect()->route('admin.districts.index')->with('success', 'District deleted successfully');
    }
}

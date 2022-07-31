<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Sections;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Sections::all();
        return view('sections.sections', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sections.create_section');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $sectionRequest)
    {

        Sections::create([
            'section_name' => $sectionRequest->section_name,
            'section_desc' => $sectionRequest->section_desc,
            'Created_by' => auth()->user()->name,
        ]);
        return redirect()->route('sections.index')->with([
            'success' => 'تم اضافة القسم بنجاح'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(Sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $section = Sections::find($id);

        return view('sections.edit_section', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $sectionRequest, int $id)
    {
        $section = Sections::find($id);
        $section->update([
            'section_name' => $sectionRequest->section_name,
            'section_desc' => $sectionRequest->section_desc,
        ]);
        return redirect()->route('sections.index')->with([
            'success' => 'تم تعديل القسم بنجاح',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        Sections::destroy($id);
        return redirect()->route('sections.index')->with([
            'delete' => 'تم حدف القسم بنجاح'
        ]);
    }
}

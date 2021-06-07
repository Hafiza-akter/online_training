<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Setting;
use App\Model\Equipment;
use App\Model\Course;



class CourseController extends Controller
{
    public function courseList()
    {
        $course = Course::Where('id', '!=', null)->get();
        return view('admin.course.list')->with('courseList', $course)
            ->with('page', 'course');
    }
    public function courseAdd()
    {
        $equipmentList = Equipment::Where('id', '!=', null)->get();

        return view('admin.course.add')->with('equipmentList', $equipmentList)
            ->with('page', 'course');
    }
    public function courseAddSubmit(Request $request)
    {
        // dd($request);
        $validateData = $request->validate([
            'course_type' => 'required',
            'course_name' => 'required',
            'equipment_id' => 'required',
        ]);
        $course = new Course();
        $course->course_name = $request->input('course_name');
        $course->course_type = $request->input('course_type');
        $course->equipment_id = $request->input('equipment_id');
        $course->set_1 = $request->input('set_1_kg') . "_" . $request->input('set_2_times');
        $course->set_2 = $request->input('set_2_kg') . "_" . $request->input('set_2_times');
        $course->set_3 = $request->input('set_3_kg') . "_" . $request->input('set_3_times');
        $course->summary = $request->input('summary');
        $course->reference_url = $request->input('reference_url');
        $course->mets = $request->input('mets');
        $course->main = $request->input('main');
        $course->body_part = $request->input('body_part');
        $course->sub = $request->input('sub');
        $course->motion = $request->input('motion');
        $course->way = $request->input('way');
        $course->session_time = $request->input('session_time');
        if ($request->hasFile('image')) {

            $validateData = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            $file = $request->file('image');
            $filename = rand(1, 9000) . strtotime("now");
            $file->move(public_path() . '/images/', $filename . '_course_image' . '.' . $file->getClientOriginalExtension());
            $path = $filename . '_course_image' . '.' . $file->getClientOriginalExtension();
            $imgfullPath = $path;
            $course->image_path = $imgfullPath;
        }

        $course->save();
        return redirect()->route('course.list')->with('message', 'Added successfully!');
    }
    public function courseView($id)
    {
        $course = Course::Where('id', $id)->first();
        $equipmentList = Equipment::Where('id', '!=', null)->get();
        return view('admin.course.view')->with('course', $course)
            ->with('page', 'course');
    }
    public function courseEdit($id)
    {
        $course = Course::Where('id', $id)->first();
        $equipmentList = Equipment::Where('id', '!=', null)->get();
        return view('admin.course.edit')->with('course', $course)
            ->with('equipmentList', $equipmentList)
            ->with('page','course');
    }

    public function courseEditSubmit(Request $request)
    {
        // dd($request);
        $validateData = $request->validate([
            'course_type' => 'required',
            'course_name' => 'required',
            'equipment_id' => 'required',
        ]);
        $id = $request->input('course_id');
        $course = Course::Where('id', $id)->first();
        $course->course_name = $request->input('course_name');
        $course->course_type = $request->input('course_type');
        $course->equipment_id = $request->input('equipment_id');
        $course->set_1 = $request->input('set_1_kg') . "_" . $request->input('set_2_times');
        $course->set_2 = $request->input('set_2_kg') . "_" . $request->input('set_2_times');
        $course->set_3 = $request->input('set_3_kg') . "_" . $request->input('set_3_times');
        $course->summary = $request->input('summary');
        $course->reference_url = $request->input('reference_url');
        $course->mets = $request->input('mets');
        $course->main = $request->input('main');
        $course->body_part = $request->input('body_part');
        $course->sub = $request->input('sub');
        $course->motion = $request->input('motion');
        $course->way = $request->input('way');
        $course->session_time = $request->input('session_time');
        if ($request->input('status')) {
            $course->status = 1;
        } else {
            $course->status = 0;
        }

        if ($request->hasFile('image')) {
            if ($course->image_path != null) {
                $oldImagepath = public_path() . '/images/' . $course->image_path;
                unlink($oldImagepath);
            }

            $file = $request->file('image');
            $filename = rand(1, 9000) . strtotime("now");
            $file->move(public_path() . '/images/', $filename . '_course_image' . '.' . $file->getClientOriginalExtension());
            $path = $filename . '_course_image' . '.' . $file->getClientOriginalExtension();
            $imgfullPath = $path;
            $course->image_path = $imgfullPath;
        }

        $course->save();
        return redirect()->route('course.list')->with('message', 'Edited successfully!');
    }

   
}

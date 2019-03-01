<?php

namespace App\Http\Controllers;

use App\Students;
use App\Course;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __construct()
    {

    }

    public function welcome()
    {
        return view('hello');
    }

    /**
     * View all students found in the database
     */
    public function viewStudents()
    {
        $students = Students::with('course')->get();
        return view('view_students', compact('students'));
    }

    /**
     * Exports all student data to a CSV file
     */
    public function exportStudentsToCSV(Request $request)
    {
        if($request->input("studentID")) {
            $student = [];

            foreach ($request->input("studentID") as $studentID) {
                $st = Students::where("id", "=", $studentID)->with("address")->get();

                $student[$studentID]["firstname"] = $st[0]->firstname;
                $student[$studentID]["surname"] = $st[0]->surname;
                $student[$studentID]["email"] = $st[0]->email;
                $student[$studentID]["nationality"] = $st[0]->nationality;
                if(isset($st[0]["address"]))
                {
                    $student[$studentID]["houseNo"] = $st[0]["address"]->houseNo;
                    $student[$studentID]["line_1"] = $st[0]["address"]->line_1;
                    $student[$studentID]["line_2"] = $st[0]["address"]->line_2;
                    $student[$studentID]["postcode"] = $st[0]["address"]->postcode;
                    $student[$studentID]["city"] = $st[0]["address"]->city;
                }
            }
            //dd($student);
            $Filename = 'studentData.csv';
            header('Content-Type: text/csv; charset=utf-8');
            Header('Content-Type: application/force-download');
            header('Content-Disposition: attachment; filename=' . $Filename . '');
            $output = fopen('php://output', 'w');
            foreach ($student as $studentID => $data) {
                fputcsv($output, $data);
            }
            fclose($output);
        }

    }

    /**
     * Exports the total amount of students that are taking each course to a CSV file
     */
    public function exportCourseAttendenceToCSV()
    {
        $attendance = Course::with('students')->get();

        $courses = [];
        foreach($attendance as $at){
            $courses[$at->id]["courseName"] = $at->course_name;
            $courses[$at->id]["total"] = $at->students->count();
        }

        $Filename ='studentsEachCourse.csv';
        header('Content-Type: text/csv; charset=utf-8');
        Header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename='.$Filename.'');
        $output = fopen('php://output', 'w');
        foreach ($courses as $courseID => $data){
            fputcsv($output, $data);
        }
        fclose($output);

    }


}

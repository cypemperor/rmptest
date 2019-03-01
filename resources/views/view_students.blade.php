<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to RMP</title>
        <style>
            @import url(//fonts.googleapis.com/css?family=Lato:700);

            body {
                margin:0;
                font-family:'Lato', sans-serif;
                text-align:center;
                color: #999;
            }

            .header {
                width: 100%;
                left: 0px;
                top: 5%;
                text-align: left;
                border-bottom: 1px  #999 solid;
            }

            .student-table{
                width:100%;  
            }

            table.student-table th{
                background-color: #C6C6C6;
                text-align: left;
                color: white;
                padding:7px 3px;
                font-weight: 700;
                font-size: 18px;
            }

            table.student-table tr.odd {
                text-align: left;
                padding:5px;
                background-color: #F9F9F9;
            }

            table.student-table td{
                text-align: left;
                padding:5px;
            }

            a, a:visited {
                text-decoration:none;
                color: #999;
            }

            h1 {
                font-size: 32px;
                margin: 16px 0 0 0;
            }
        </style>
        <script   src="https://code.jquery.com/jquery-3.3.1.min.js"   integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="   crossorigin="anonymous"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#selectAllButton").click(function() {
                    if ($(this).hasClass('allChecked')) {
                        $('input[type="checkbox"]', '#studentTable').prop('checked', false);
                    } else {
                        $('input[type="checkbox"]', '#studentTable').prop('checked', true);
                    }
                    $(this).toggleClass('allChecked');
                });

            });

            function attendaceForm()
            {
               $("#attendanceForm").submit();
            }
        </script>
    </head>

    <body>
    <form name="attendanceForm" id="attendanceForm" method="post" action="/attendance">
    </form>
        <form name="studentTableForm" method="post" action="/export" enctype="multipart/form-data">
            <div class="header">
                <div><img src="/images/RMP_logo_sm.jpg" alt="RMP Logo" title="RMP logo"></div>
                <div  style='margin: 10px;  text-align: left'>
                    <input type="button" value="Select all" id="selectAllButton" />
                    <input type="submit" value="Export Students" />
                    <input type="button" value="Export Attendance" onclick="attendaceForm()" />
                </div>
            </div>


            <div style='margin: 10px; text-align: center;'>
                <table class="student-table" id="studentTable">
                    <tr>
                        <th></th>
                        <th>Forename</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>University</th>
                        <th>Course</th>
                    </tr>

                    @if(  count($students) > 0 )
                    @foreach($students as $student)
                    <tr>
                        <td>
                            <input type="checkbox" name="studentID[]" value="{{$student['id']}}" />
                        </td>
                        <td style=' text-align: left;'>{{$student['firstname']}}</td>
                        <td style=' text-align: left;'>{{$student['surname']}}</td>
                        <td style=' text-align: left;'>{{$student['email']}}</td>
                        <td style=' text-align: left;'>{{$student['course']['university']}}</td>
                        <td style='text-align: left;'>{{$student['course']['course_name']}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td></td>
                        <td colspan="6" style="text-align: center">Oh dear, no data found.</td>
                    </tr>
                    @endif
                </table>
            </div>
        </form>
    </body>
</html>
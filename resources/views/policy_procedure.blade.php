@extends('layouts.side_top_content')

@section('module_name', 'My Attendance')

@section('content')
<div class="attendance_summary_content" style="display: none;">
    <div class="attendance_summary_report">
            <div class="container_title">
                <p class="header_title_h2">Privacy Policy</p>
            </div>
    </div>


</div>

    @section('script_content')
        <script>
            $('.attendance_summary_content').fadeIn('slow');




            // function showTable(){
            //     $('#table_generate').attr('hidden',false);
            // }


        </script>
    @endsection
@endsection


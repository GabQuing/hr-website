@extends('layouts.side_top_content')

@section('module_name', 'Schedule Profiles')

@section('css')
    <style>

        .schedule_upper_content #sched_edit_btn{
            position: relative;
            top: 8px;
        }
        .top_navbar{
            margin-bottom: 30px
        }
        .pic_input select{
            height: 31px;
            width: 100%;
            border-radius: 5px;
            outline: none;
            border: 1px solid #a1a1a1;
            text-align: center;
            font-size: 13px;
        }

        .select2-container .select2-selection--single{
            height: 33px;

        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            font-size: 13px;
            text-transform: lowercase;
            line-height: 33px;
            text-align: center

        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            font-size: 13px;
            text-transform: uppercase;

        }


        .select2-container--default .select2-results__option {
            font-size: 13px;
            text-transform: lowercase;

        }

        .select2-container--default .select2-results__option {
            font-size: 13px;
            text-transform: uppercase;

        }

    </style>
@endsection
@section('content')

    <div class="edit_schedule_profile"  >

        <div class="m-auto-p">
            <div class="view_create_schedule">
                <a class="sched_action_btn user_info_link btn-act" id="edit_schedule_button">View Schedules</a>
                <a class="sched_action_btn user_info_link" id="create_schedule_button">Create Schedule</a> 
            </div>
            <br>
            @if(session('success'))
            <div id="successMessage">
                <p class="text-success">{{ session('success') }}</p>
                <br>
            </div>
            <script>
                setTimeout(function() {
                    $('#successMessage').fadeOut('fast');
                }, 3000); // 3000 milliseconds = 3 seconds
            </script>
            
            @endif
            <div class="attendance_summary_report" id="view_table">
                <form action="{{ route('editSchedule') }}" method="POST">
                    @csrf
                    <div class="container_title">
                        <p class="header_title_h2">View Schedule Profiles</p>
                    </div>
                    <div class="schedule_upper_content">
                        <div class="pic_input schedule_profile_div">
                            <label for="">Schedule Profile:</label>
                            <select class="js-example-basic-single s-single" name="edit_schedule_profile" id="edit_schedule_profile" >
                                <option value="" class="sched-none">None selected</option>
                                @foreach ( $schedule_types as $schedule_type )
                                    <option value="{{ $schedule_type->id }}">{{ $schedule_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="pic_input edit_name_div" style="display: none">
                            <label>New Schedule Profile Name:</label>
                            <input type="text" id="edit_profile_name" value="" name="edit_profile_name">
                        </div>
                        <div class="pic_input">
                            <label>No of hours to work including break hours:</label>
                                <input type="text"  id = "input_sched_hour" name="input_sched_hour" value="" readonly>
                        </div>
                        <div class="pic_buttons">
                            <button  type="button" class="user_info_link cursor-p" id="sched_pre_edit_btn" style="display: none;">Edit Profile</button> 
                        </div>
                    </div>
                    <div class="schedule_lower_content" id="sched_edit_table" style="display: none">
                        <hr>
                        <br>
                        <div class="pic_input_main_table" >
                            <table class="table_manage_schedule">
                                <thead>
                                    <tr >
                                        <th class="header_schedule">Day</th>
                                        <th class="header_schedule">Shift/Core From</th>
                                        <th class="header_schedule">Shift/Core To</th>
                                        <th class="header_schedule">Break Start</th>
                                        <th class="header_schedule">Break End</th>            
                                        <th class="header_schedule">Is Rest Day</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($work_days as $work_day)
                                        <tr>
                                            <td class="body_schedule">{{ $work_day }}</td>
                                            <td class="body_schedule">
                                                <div class="pic_input_table">
                                                    <input type="time" day="{{ $work_day }}" class="input_time  from_{{ strtolower($work_day) }}" name="{{ $work_day }}_from" placeholder="00:00:00" readonly>
                                                </div >
                                            </td>
                                            <td>
                                                <div class="pic_input_table">
                                                    <input type="time" day="{{ $work_day }}" class="input_time  to_{{ strtolower($work_day) }}" name="{{ $work_day }}_to" placeholder="00:00:00" readonly >
                                                </div >
                                            </td>
                                            <td>
                                                <div class="pic_input_table">
                                                    <input type="time" day="{{ $work_day }}" class="input_time  start_{{ strtolower($work_day) }}" name="{{ $work_day }}_start" placeholder="00:00:00" readonly>
                                                </div >
                                            </td>
                                            <td>
                                                <div class="pic_input_table">
                                                    <input type="time" day="{{ $work_day }}" class="input_time  end_{{ strtolower($work_day) }}" name="{{ $work_day }}_end" placeholder="00:00:00" readonly>
                                                </div >
                                            </td>
                                            <td>
                                                <div class="pic_input_table">
                                                    <input type="checkbox" day="{{ $work_day }}" class="c_box view_sched_cbox checkbox rest_{{ strtolower($work_day) }}" name="{{ $work_day }}_rest" disabled>
                                                </div >
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="save_profile_btn" style="">
                                <button class="user_info_link cursor-p" id="edit_cancel_btn" type="button" style="display: none;">Cancel</button> 
                                <button class="user_info_link cursor-p" id="fake_btn1" type="submit" style="display: none;">Save Profile</button> 
                                <button class="user_info_link cursor-p" id="sched_edit_btn" type="submit" style="display: none;">Save Profile</button> 
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="attendance_summary_report" id="create_table" style="display: none;">
                <form method="POST" action="{{route('createSchedule')}}" autocomplete="off">
                    @csrf
                    <div class="container_title">
                        <p class="header_title_h2">Create New Schedule Profile</p>
                    </div>
                    <div class="schedule_upper_content">
                        <div class="pic_input">
                            <label>Schedule Profile Name:</label>
                            <input type="text" id = "input_sched_name" value="" name="input_sched_name"  required>
                        </div>
                        <div class="pic_input">
                            <label>No of hours to work including break hours:</label>
                            <input type="text" id="create_sched_hour" value="" name="create_sched_hour">
                        </div>
                    </div>
                    <div class="schedule_lower_content" >
                        <hr>
                        <br>
                        <div class="pic_input_main_table" >
                            <table class="table_manage_schedule">
                                <thead>
                                    <tr >
                                        <th class="header_schedule">Day</th>
                                        <th class="header_schedule">Shift/Core From</th>
                                        <th class="header_schedule">Shift/Core To</th>
                                        <th class="header_schedule">Break Start</th>
                                        <th class="header_schedule">Break End</th>            
                                        <th class="header_schedule">Is Rest Day</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($work_days as $work_day)
                                        <tr>
                                            <td class="body_schedule">{{ $work_day }}</td>
                                            <td class="body_schedule">
                                                <div class="pic_input_table">
                                                    <input type="time" class="create_input_time _{{ strtolower($work_day) }}" name="{{ $work_day }}_from" placeholder="00:00:00">
                                                </div >
                                            </td>
                                            <td>
                                                <div class="pic_input_table">
                                                    <input type="time" class="create_input_time _{{ strtolower($work_day) }}" name="{{ $work_day }}_to" placeholder="00:00:00">
                                                </div >
                                            </td>
                                            <td>
                                                <div class="pic_input_table">
                                                    <input type="time" class="create_input_time _{{ strtolower($work_day) }}" name="{{ $work_day }}_start" placeholder="00:00:00">
                                                </div >
                                            </td>
                                            <td>
                                                <div class="pic_input_table">
                                                    <input type="time" class="create_input_time _{{ strtolower($work_day) }}" name="{{ $work_day }}_end" placeholder="00:00:00">
                                                </div >
                                            </td>
                                            <td>
                                                <div class="pic_input_table">
                                                    <input type="checkbox" class="c_box new_sched_cbox create_checkbox_{{ strtolower($work_day) }}" name="{{ $work_day }}_rest">
                                                </div >
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="save_profile_btn">
                                <button class="user_info_link cursor-p" id="fake_btn" type="submit">Create Profile</button> 
                                <button class="user_info_link" id="btn_submit" type="submit" style="display: none">Create Profile</button> 
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- <div class="create_schedule_profile" style="display: none">

    </div> --}}
    


@endsection

@section('script_content')


<script>

    $('.s-single').select2({
        width: '100%',
    });

    function getSched(selectedValue){
        $('#sched_pre_edit_btn').hide();
        console.log(selectedValue);
                $.ajax({
                url:"{{route('viewSchedule')}}",
                type:"POST",
                dataType: 'json',
                data: {
                    _token:"{{csrf_token()}}", 
                    scheduleType: selectedValue,
                },
                success:function(res){
                    // console.log(res);
                    populateSched(res);
                    // $('#sched_pre_edit_btn').show();
                },
                error:function(res){
                    console.log(res);
                    alert('Failed')
                },
            });
    };

    function populateSched(res){
        $("#sched_edit_table").slideUp({
            done: function() {
                const scheduleEntries =  res.entry;
                // console.log(res);
                // console.log(res.entry);
                $('#input_sched_hour').val(res.working_hours);
                scheduleEntries.forEach(function(entry){
                    const day = entry.work_day.toLowerCase();
                    const fromInput = $(".from_" + day);
                    const toInput = $(".to_" + day);
                    const startInput = $(".start_" + day);
                    const endInput = $(".end_" + day);
                    const restCheckbox = $(".rest_" + day);
                    fromInput.val(entry.work_from);
                    toInput.val(entry.work_to);
                    startInput.val(entry.break_start);
                    endInput.val(entry.break_end);
                    if (entry.rest_day == 1){
                        restCheckbox.prop('checked',true);
                        restCheckbox.closest('tr').find('input').val('');
                        restCheckbox.closest('tr').find('input').attr('readonly', true);
                    } else {
                        restCheckbox.prop('checked',false);
                    };
                });
            }
        });
        $('#sched_edit_table').slideDown();
        $('#sched_pre_edit_btn').fadeIn(500);
        $('.sched_action_btn').removeClass('active_button');
    };

    $(document).ready(function(){
        $('#edit_schedule_profile').on('change',function(){
            $(this).find('option.sched-none').attr('disabled', true);
            const selectedValue = $(this).val();
            getSched(selectedValue);
        });

        $("#edit_schedule_button").click(function(e){
            e.preventDefault();
            $("#create_table").fadeOut(function(){
                $("#view_table").fadeIn();
            });
            $('#create_schedule_button').removeClass('btn-act');
            $(this).addClass('btn-act');
        });

        $("#create_schedule_button").click(function(e){
            $("#view_table").fadeOut(function(){
                $("#create_table").fadeIn();
            });
            $('#edit_schedule_button').removeClass('btn-act');
            $(this).addClass('btn-act');
            $('.new_sched_cbox').prop('checked', true);
            $('.new_sched_cbox').closest('tr').find('input').attr('readonly', true);
            $('#new_sched_cbox').attr('disabled', true);

        });

        $('#sched_pre_edit_btn').click(function(e){
            e.preventDefault();
            $(this).addClass('btn-act');
            $('#edit_schedule_profile').attr('disabled', true);
            $('.view_sched_cbox').attr('disabled', false);
            $('#edit_cancel_btn, #fake_btn1').slideDown();
            $('#input_sched_hour, .input_time, #edit_profile_name').attr('readonly', false);
            $('.input_time, #edit_profile_name, #input_sched_hour').addClass('change_color');
            $('.schedule_profile_div').hide();
            $('.edit_name_div').show();
            const selectedText = $('#edit_schedule_profile option:selected').text();
            $('#edit_profile_name').val(selectedText);
            const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            const restClass = days.map(day => ".rest_" + day);
            for (let i = 0; i < restClass.length; i++) {
                const restCheckbox = $(restClass[i]);
                if (restCheckbox.is(':checked')) {
                    const closestTr = restCheckbox.closest('tr');
                    closestTr.find('.input_time').removeClass('change_color');
                    closestTr.find('.input_time').attr('readonly', true);
                };
            }
        });

        $('#edit_cancel_btn').click(function(e){
            e.preventDefault();
            const selectedValue = $('#edit_schedule_profile').val();
            getSched(selectedValue);
            $('#sched_pre_edit_btn').removeClass('btn-act');
            $('#edit_schedule_profile').attr('disabled', false);
            $('#input_sched_hour').attr('readonly',true);
            $('.input_time').removeClass('change_color');
            $('.input_time').attr('readonly',true);
            $('.view_sched_cbox').attr('disabled',true);
            $('.edit_name_div').hide();
            $('.schedule_profile_div').show();
            $('#fake_btn1',).slideUp();
            $('#input_sched_hour').removeClass('change_color');
            $(this).slideUp();
        });

        $('#fake_btn').click(function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Submit it!',
                returnFocus: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#btn_submit').click();
                }
            });
        })

        $('#fake_btn1').click(function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Submit it!',
                returnFocus: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#edit_schedule_profile').attr('disabled',false);
                    $('#sched_edit_btn').click();
                }
            });
        })
    });

        $('.c_box').on('change', function(){
            const isChecked = $(this).prop('checked');
            if(isChecked){
                $(this).closest('tr').find('input').val('');
                $(this).closest('tr').find('input').attr('readonly', true);
                $(this).closest('tr').find('input').removeClass('change_color');
            }else{
                $(this).closest('tr').find('input').attr('readonly', false);
                $(this).closest('tr').find('input').addClass('change_color');
            }
        })

</script>

@endsection
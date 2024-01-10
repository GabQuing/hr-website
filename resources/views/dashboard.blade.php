@extends('layouts.side_top_content')

@section('module_name', 'Dashboard')

@section('content')
<div class="grid">
    <div class="container container_today">
        <div class="container_title">
            <p class="header_title_h2">Today</p>
        </div>
        <div class="today_attendance">
            <div class="today_attendance flex">
                <div class="today_attendance_span">
                    <span class="material-symbols-outlined" style="font-size: 50px; vertical-align: middle;">nest_clock_farsight_analog</span>
                </div>
                <div class="today_attendance_p">
                    <p>Time in: </p>
                    <p>Time out: </p>
                </div>
            </div>
        </div>
        <p style="text-align: center;">Date: 02/18/20</p>
    </div>
    <div class="container container_my_attendance">
        <div class="container_title">
            <p class="header_title_h2">My Attendance</p>
        </div>
        <div class="container_attendance">
            <table>
                <thead>
                    <tr>
                        <th>Log-Type</th>
                        <th>Datetime Access</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $reversedUser = $user->reverse()->take(2); // Reverse the collection and take the last 5 items
                    @endphp
                    @foreach ($reversedUser as $userData )
                        <tr>
                            <td style="text-align: center;">{{ $userData->log_type }}</td>
                            <td style="text-align: center;">{{$userData->date.' ('.$userData->time.')';}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container container_my_stuff">
        <div class="container_title">
            <p class="header_title_h2">My Stuff</p>
        </div>                   
    </div>
    <div class="container container_my_stuff">
        <div class="container_title">
            <p class="header_title_h2">Events and Holidays</p>
        </div>
    </div>
    <div class="container container_my_store_location">
        <canvas id="myChart" style="height: 100%; width: 100%"></canvas>
        <script>
            const ctx = document.getElementById('myChart');
            Chart.defaults.font.size = 16;
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                        label: 'My attendance',
                        data: [12, 19, 3, 5, 2, 3, 14],
                        backgroundColor: [
                            'rgb(74, 189, 172)'
                        ],
                        borderColor: [
                            'rgba(29, 26, 5,1)',
                        ],
                        borderWidth: 0,
                        tension: 0.5,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: true,
                            },
                        },
                        y: {
                            grid: {
                                display: true,
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: "rgb(0, 0, 0)",
                            },
                        },
                    },
                },
            });
        </script>
    </div>
</div>

    @section('script_content')
    <script>
        $(document).ready(function(){
            $( ".container" ).first().show( "slow", function showNext() {
                $( this ).next( ".container" ).show( "fast", showNext );
            });
        })
    </script>
    @endsection
@endsection
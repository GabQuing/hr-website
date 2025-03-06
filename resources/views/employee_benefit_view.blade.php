@extends('layouts.side_top_content' , ['title' => 'Employee Benefit'])

@section('module_name', 'Employee Benefit')

@section('content')
<style>
    .modal-box {
        max-width: 75rem !important;
    }

    table.benefit-history-table td,
    table.benefit-history-table tr {
        border: 1px solid black;
    }
</style>

<div class="u-box u-box-shadow-medium" style="overflow: hidden">
    <form method="POST" action="{{route('generateTable')}}">
        @csrf
        <input type="text" name="employeeId" value="{{ auth()->user()->id }}" style="display: none;">
        <div class="u-bg-primary u-p-15">
            <h4 class="u-t-center u-t-white u-fw-b">Employee Benefits - {{ $benefit->employee_name }}</h4>
        </div>

        <table class="custom_normal_table u-m-10">
            <tbody>
                <tr>
                    <td>
                        <h5 class="u-fw-b">Current Benefit Status</h5>
                        <br>
                        <hr>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="custom_normal_table u-m-10">
            <tbody>
                <tr>
                    <td>
                        <h5 class="u-fw-b u-t-dark">Particulars</h5>
                    </td>
                    <td>
                        <h5 class="u-fw-b u-t-dark">Credit</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5 class="u-fw-b u-t-gray">Health Care</h5>
                    </td>
                    <td>
                        <h5 class="u-fw-b u-t-gray">₱{{ number_format($benefit->health_care, 2) }}</h5>
                    </td>
                </tr>
                {{-- <tr>
                    <td>
                        <h5 class="u-fw-b u-t-gray">Vision</h5>
                    </td>
                    <td>
                        <h5 class="u-fw-b u-t-gray">₱{{ number_format($benefit->vision, 2) }}</h5>
                    </td>
                </tr> --}}
                <tr>
                    <td>
                        <h5 class="u-fw-b u-t-gray">Dental</h5>
                    </td>
                    <td>
                        <h5 class="u-fw-b u-t-gray">₱{{ number_format($benefit->dental, 2) }}</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5 class="u-fw-b u-t-gray">Pregnancy and Maternity Care</h5>
                    </td>
                    <td>
                        <h5 class="u-fw-b u-t-gray">₱{{ number_format($benefit->pregnancy, 2) }}</h5>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="u-m-10">
            <table class="custom_normal_table">
                <tbody>
                    <tr class="">
                        <td>
                            <h5 class="u-fw-b">Benefit History</h5>
                        </td>
                        <br>
                        <hr>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mob-pending-table u-m-10" style="overflow-x: auto;">
            <table class="u-responsive-table benefit-history-table">
                <thead>
                    <tr class="f-weight-bold u-t-gray">
                        <td rowspan="2">
                            <h5 class="f-weight-bold u-t-center">Created Date</h5>
                        </td>
                        <td colspan="2">
                            <h5 class="f-weight-bold u-t-center">Health Care</h5>
                        </td>
                        {{-- <td colspan="2">
                            <h5 class="f-weight-bold u-t-center">Vision</h5>
                        </td> --}}
                        <td colspan="2">
                            <h5 class="f-weight-bold u-t-center">Dental</h5>
                        </td>
                        <td colspan="2">
                            <h5 class="f-weight-bold u-t-center">Pregnancy and Maternity Care</h5>
                        </td>
                        <td rowspan="2">
                            <h5 class="f-weight-bold u-t-center">Created By</h5>
                        </td>
                        <td rowspan="2">
                            <h5 class="f-weight-bold u-t-center">Note</h5>
                        </td>
                        <td rowspan="2">
                            <h5 class="f-weight-bold u-t-center">Actions</h5>
                        </td>
                    </tr>
                    <tr class="f-weight-bold u-t-gray">
                        <td>
                            <h5 class="f-weight-bold u-t-center">Before</h5>
                        </td>
                        <td>
                            <h5 class="f-weight-bold u-t-center">After</h5>
                        </td>
                        {{-- <td>
                            <h5 class="f-weight-bold u-t-center">Before</h5>
                        </td> --}}
                        {{-- <td>
                            <h5 class="f-weight-bold u-t-center">After</h5>
                        </td> --}}
                        <td>
                            <h5 class="f-weight-bold u-t-center">Before</h5>
                        </td>
                        <td>
                            <h5 class="f-weight-bold u-t-center">After</h5>
                        </td>
                        <td>
                            <h5 class="f-weight-bold u-t-center">Before</h5>
                        </td>
                        <td>
                            <h5 class="f-weight-bold u-t-center">After</h5>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($histories as $history)
                    <tr>
                        <td class="u-t-center">{{ $history->created_at }}</td>
                        <td class="u-t-center">₱{{ number_format($history->before_health_care, 2) }}</td>
                        <td class="u-t-center">₱{{ number_format($history->after_health_care, 2) }}</td>
                        {{-- <td class="u-t-center">₱{{ number_format($history->before_vision, 2) }}</td> --}}
                        {{-- <td class="u-t-center">₱{{ number_format($history->after_vision, 2) }}</td> --}}
                        <td class="u-t-center">₱{{ number_format($history->before_dental, 2) }}</td>
                        <td class="u-t-center">₱{{ number_format($history->after_dental, 2) }}</td>
                        <td class="u-t-center">₱{{ number_format($history->before_pregnancy, 2) }}</td>
                        <td class="u-t-center">₱{{ number_format($history->after_pregnancy, 2) }}</td>
                        <td class="u-t-center">{{ $history->creator_name }}</td>
                        <td class="u-t-center">{{ $history->note }}</td>
                        <td class="u-align-items-center">
                            @if ($history->file_path)
                            <a href="{{ route('employee_benefit.download-receipt', $history->id) }}" target="_blank"
                                history-id="{{ $history->id }}" class="u-flex-center-column" type="button">Download
                                Receipt</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $histories->links() }}
            <p>Showing {{ $histories->firstItem() ?? 0 }} to {{ $histories->lastItem() ?? 0 }} of {{ $histories->total()
                }} items.</p>

        </div>
    </form>
</div>

@section('script_content')
<script>
    $(document).ready(function() {
      $('.view-receipt-btn').on('click', function() {
        const id = $(this).attr('history-id');
        
      })
    })
</script>
@endsection
@endsection
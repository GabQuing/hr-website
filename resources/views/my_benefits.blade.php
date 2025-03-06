@extends('layouts.side_top_content' , ['title' => 'My Benefits'])

@section('module_name', 'My Benefits')

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
    <form method="POST" action="">
        @csrf
        <input type="text" name="employeeId" value="{{ auth()->user()->id }}" style="display: none;">
        <div class="u-bg-primary u-p-15">
            <h4 class="u-t-center u-t-white u-fw-b">My Benefits</h4>
        </div>


        <table class="custom_normal_table u-m-10">
            <tbody>
                <tr>
                    <td>
                        <h5 class="u-fw-b">Current Benefits Credits</h5>
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
                        <h5 class="u-fw-b u-t-dark">Credits</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5 class="u-fw-b u-t-gray">Healthcare Benefits:</h5>
                    </td>
                    <td>
                        <h5 class="u-fw-b u-t-gray">{{ number_format($employee_benefits?->health_care, 2) }}</h5>
                    </td>
                </tr>
                {{-- <tr>
                    <td>
                        <h5 class="u-fw-b u-t-gray">Vision Benefits:</h5>
                    </td>
                    <td>
                        <h5 class="u-fw-b u-t-gray">{{ number_format($employee_benefits?->vision, 2) }}</h5>
                    </td>
                </tr> --}}
                <tr>
                    <td>
                        <h5 class="u-fw-b u-t-gray">Dental Benefits:</h5>
                    </td>
                    <td>
                        <h5 class="u-fw-b u-t-gray">{{ number_format($employee_benefits?->dental, 2) }}</h5>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h5 class="u-fw-b u-t-gray">Pregnancy and Maternity Care :</h5>
                    </td>
                    <td>
                        <h5 class="u-fw-b u-t-gray">{{ number_format($employee_benefits?->pregnancy, 2) }}</h5>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="u-m-10">
            <table class="custom_normal_table">
                <tbody>
                    @if (session('success'))
                    <tr>
                        <td>
                            <h5 class="u-fw-b" style="color: green; display:block;">{{ session('success') }}</h5>
                        </td>
                    </tr>
                    @elseif (session('failed'))
                    <tr>
                        <td>
                            <h5 class="u-fw-b u-t-danger" style="display:block;">{{ session('failed') }}</h5>
                        </td>
                    </tr>
                    @endif
                    <tr class="">
                        <td>
                            <h5 class="u-fw-b">My Benefits - History</h5>
                        </td>
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
                        <td class="u-t-center">{{ $history->created_at}} </td>
                        <td class="u-t-center">{{ number_format($history->before_health_care, 2) }}</td>
                        <td class="u-t-center">{{ number_format($history->after_health_care, 2) }}</td>
                        {{-- <td class="u-t-center">{{ number_format($history->before_vision, 2) }}</td> --}}
                        {{-- <td class="u-t-center">{{ number_format($history->after_vision, 2) }}</td> --}}
                        <td class="u-t-center">{{ number_format($history->before_dental, 2) }}</td>
                        <td class="u-t-center">{{ number_format($history->after_dental, 2) }}</td>
                        <td class="u-t-center">{{ number_format($history->before_pregnancy, 2) }}</td>
                        <td class="u-t-center">{{ number_format($history->after_pregnancy, 2) }}</td>
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
    $('.my_leaves_content').fadeIn('slow');

        $('.mob-approve-table').hide();
        $('.mob-rejected-table').hide();

        $('#mob-pending').on('click', function(){
            hideTable($(this), 'Pending');
            $('.mob-pending-table').show();
        })

        $('#mob-approve').on('click', function(){
            hideTable($(this), 'Approved');
            $('.mob-approve-table').show();
        })

        $('#mob-rejected').on('click', function(){
            hideTable($(this), 'Rejected');
            $('.mob-rejected-table').show();
        })

        $('#my_official_business_add').on('click', function(){
            $('.add-leave-form').show();
        })

        $('#btn-close').on('click', function(){
            $('.add-leave-form').hide();
        })
        $('#btn-close-edit').on('click', function(){
            $('.edit-leave-form').hide();
            })



</script>
@endsection
@endsection
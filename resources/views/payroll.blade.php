@extends('layouts.side_top_content')

@section('module_name', 'Payroll')

@section('content')
    <div class="user_accounts_table">
        <table id="myTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Pay Period</th>
                    <th>Basic</th>
                    <th>Pay Date</th>
                    <th>OT</th>
                    <th>Reimbursements</th>
                    <th>Incentives</th>
                    <th>Bonus</th>
                    <th>Commissions</th>
                    <th>PTO Conversions</th>            
                    <th>Month Pay</th>            
                    <th>Deductions</th>  
                    <th>Non-taxable Pay</th>  
                    <th>Non-Taxable Earning</th>  
                    <th></th>        
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <a class="useraccount_view" href="">View</a>
                    </td> 
                </tr>     
            </tbody>
            <tfoot>
                <tr>
                    <th>Pay Period</th>
                    <th>Basic</th>
                    <th>Pay Date</th>
                    <th>OT</th>
                    <th>Reimbursements</th>
                    <th>Incentives</th>
                    <th>Bonus</th>
                    <th>Commissions</th>
                    <th>PTO Conversions</th>            
                    <th>Month Pay</th>            
                    <th>Deductions</th>  
                    <th>Non-taxable Pay</th>  
                    <th>Non-Taxable Earning</th>  
                    <th></th>              
                </tr>
            </tfoot>
        </table>
    </div>


@endsection

@section('script_content')

<script>
    $('.user_accounts_table').fadeIn('slow');

    $('#myTable').DataTable({
        responsive: true
    });

</script>

@endsection
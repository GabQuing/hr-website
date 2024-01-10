@extends('layouts.side_top_content')

@section('module_name', 'Payroll')

@section('content')
    <div class="user_accounts_table">
        <table id="myTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Basic</th>
                    <th>DeMinimis</th>
                    <th>OT</th>
                    <th>DeMinimis</th>
                    <th>SSS</th>
                    <th>PhilHealth</th>
                    <th>PAGIBIG</th>
                    <th>Tax</th>            
                    <th>Adj(+)</th>            
                    <th>Adj(-)</th>  
                    <th>NetAmount</th>  
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
                    <td>
                        <a class="useraccount_view" href="">View</a>
                    </td> 
                </tr>     
            </tbody>
            <tfoot>
                <tr>
                    <th>Description</th>
                    <th>Basic</th>
                    <th>DeMinimis</th>
                    <th>OT</th>
                    <th>DeMinimis</th>
                    <th>SSS</th>
                    <th>PhilHealth</th>
                    <th>PAGIBIG</th>
                    <th>Tax</th>            
                    <th>Adj(+)</th>            
                    <th>Adj(-)</th>  
                    <th>NetAmount</th>  
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
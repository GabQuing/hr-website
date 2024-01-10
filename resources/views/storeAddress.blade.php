@extends('layouts.side_top_content')

@section('module_name', 'Manage Store Address')

@section('content')
<style>

    .select2-container--default .select2-results__option {
        text-transform: uppercase;
        font-size: 12px
    }
    .select2-container--default {
        font-size: 14px;
    }
    
</style>
<div class="mg-bottom">
    <div id="storeAddress_add" class="modal">
        <form action="{{ route('newAddress') }}" method="POST">
            @csrf
            <div class="storeAddress_add_header">
                <p>Add Store Address</p>
            </div>
            <div>
                <div class="label_input">
                    <label for="">Mac Address: </label>
                    <input type="text" name="MacAddress" value="" required>
                    {{-- <input type="text" name="MacAddress" oninput="this.value=this.value.toUpperCase()" pattern="[A-F0-9]{2}-[A-F0-9]{2}-[A-F0-9]{2}-[A-F0-9]{2}-[A-F0-9]{2}-[A-F0-9]{2}" placeholder="1A-2C-50-6F-73-92" required> --}}
                    @if ($errors->has('MacAddress'))
                        <span class="text-danger"></span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">Store Location: </label>
                    <input type="text" name="StoreLocation" required>
                    @if ($errors->has('StoreLocation'))
                        <span class="text-danger"></span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">Latitude: </label>
                    <input type="number" step='any' name="Latitude" required>
                    @if ($errors->has('Latitude'))
                        <span class="text-danger"></span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">Longitude: </label>
                    <input type="number" step='any' name="Longitude" required>
                    @if ($errors->has('Longitude'))
                        <span class="text-danger"></span>
                    @endif
                </div>
            </div>

            <a class="addaddress_close" href="#" rel="modal:close" id="clsaddress_btn">Close</a>
            <button class="addaddress_btn">Submit</button>
        </form>
    </div>
    
    <div id="storeAddress_edit" class="modal">
        <form method="POST" action="{{ route('updateAddress', ['id' => 'id']) }}">
            @csrf
            <div class="storeAddress_edit_header">
                <p>Update Store Address</p>
                <input type="hidden" name="id" id="edit_address_id">
            </div>
            <div>
                <div class="label_input">
                    <label for="">Mac Address: </label> 
                    <input type="text" id="edit_mac_address" name="MacAddress" value="" required>
                    @if ($errors->has('MacAddress'))
                        <span class="text-danger">{{ $errors->first('MacAddress') }}</span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">Store Location: </label>
                    <input type="text" id="edit_store_location" name="StoreLocation" required>
                    @if ($errors->has('StoreLocation'))
                        <span class="text-danger">{{ $errors->first('StoreLocation') }}</span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">Latitude: </label>
                    <input type="number" step='any' id="edit_latitude" name="Latitude" required>
                    @if ($errors->has('Latitude'))
                        <span class="text-danger">{{ $errors->first('Latitude') }}</span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">Longitude: </label>
                    <input type="number" step='any' id="edit_longitude" name="Longitude" required>
                    @if ($errors->has('Longitude'))
                        <span class="text-danger">{{ $errors->first('Longitude') }}</span>
                    @endif
                </div>
            </div>

            <a class="addaddress_close" href="#" rel="modal:close" id="clsaddress_btn">Close</a>
            <button type="submit" class="addaddress_btn">Update</button>
        </form>
    </div>




    <p><a class="store_info_link" href="#storeAddress_add" rel="modal:open">Add Store Address</a></p>
    @if (session('success'))
        <div class="add_user_success"> 
            <span>{{ session('success') }}</span>
        </div>
    @endif

</div>


<div class="user_accounts_table">
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Mac Address</th>
                <th>Store Location</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Created By</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Actions</th>            
            </tr>
        </thead>
        <tbody>
            @foreach ( $storeTable as $storeTableData )
                <tr>
                    <td>{{ $storeTableData->mac_address}}</td>
                    <td>{{ $storeTableData->store_location}}</td>
                    <td>{{ $storeTableData->latitude}}</td>
                    <td>{{ $storeTableData->longitude}}</td>
                    <td>{{ $storeTableData->created_by}}</td>
                    <td>{{ $storeTableData->created_at}}</td>
                    <td>{{ $storeTableData->updated_at}}</td>
                    <td>
                        <div class="useraccounts_action_btn">
                            <a href="#storeAddress_edit" rel="modal:open" class="editStoreAddress useraccount_edit" data-id="{{ $storeTableData->id }}">Edit</a>
                        </div>
                    </td> 
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script_content')
<script>

    
    $(document).ready(function() {
            // Add a click event handler for the editStoreAddress button
            $('.editStoreAddress').on('click', function() {
                // Get the ID of the selected store address
                const editStoreAddress = $(this).attr('data-id');
                let route = '{{ route('showAddress', ['id' => 'id']) }}';
                route = route.replace('id', editStoreAddress);

                // Make an Ajax request to get the store address data
                $.ajax({
                    url: route,
                    dataType: 'json',
                    type: 'GET',
                    data: {'id':editStoreAddress},
                    success: function(response) {
                        // Populate the form fields with the retrieved data
                        $('#edit_mac_address').val(response.success.mac_address);
                        $('#edit_store_location').val(response.success.store_location);
                        $('#edit_latitude').val(response.success.latitude);
                        $('#edit_longitude').val(response.success.longitude);
                        $('#edit_address_id').val(response.success.id);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });


    // FadeIn table
    $('.user_accounts_table').fadeIn('slow');



    // DataTable 
    $('#myTable').DataTable({
        responsive: true
    });

    // Select2 
    $('.js-example-basic-single').select2({
        width: '100%',
        templateSelection: function (data, container) {
            // Get the original text and capitalize all letters
            var modifiedText = data.text.toUpperCase();

            // Create a new jQuery object with the modified text
            var $modified = $('<span>').text(modifiedText);
            
            // Return the modified jQuery object
            return $modified;
        }
    });




</script>
@endsection
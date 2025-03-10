<x-app-layout :assets="$assets ?? []">
    <!-- <div class="mt-4 px-3 ">
        <h2 class="text-2xl font-medium">Sender Id Report</h2>
    </div>
     -->

     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@if($message = Session::get('success'))
<script>
    $(document).ready(function() {

        $('#success_msg').modal('show');

        //   function clearFormFields() 
        // {
        //     $('#upload_file').val('');
        //     $('#retry_count').val('0');
        //     $('#context').val('');
        //   }

        // Add a click event listener to the document body
        $('body').on('click', function(e) {
            // Check if the click target is outside of the modal
            if (!$('#success_msg').is(e.target) && $('#success_msg').has(e.target).length === 0) {
                // Close the modal if the click is outside
                $('#success_msg').modal('hide');

            }
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('#success_msg').modal('hide');


            }
        });

        $('#success_msg .btn-success').on('click', function() {
            $('#success_msg').modal('hide');

        });

        $('#success_msg button.close').on('click', function() {
            $('#success_msg').modal('hide');

        });

    });
</script>

@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        var credentialId;

        function DeleteCredentials(credential_id) {
            credentialId = credential_id; // Store the credential ID
            $('#credentials-Modal').modal('show'); // Show the confirmation modal
        }

        $(document).on('click', '#approveButtonCredentials', function() {
            $.ajax({
                url: 'delete_credentials_data', // Replace with your server endpoint
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "credential_id": credentialId, // Use the stored credential ID
                },
                success: function(response) {
                    console.log('Credentials deleted successfully:', response);
                    var table = $('#system_credential_data-table').DataTable();
                    table.draw();
                    $('#credentials-Modal').modal('hide'); // Hide the modal after success
                },
                error: function(error) {
                    console.error('Error deleting credentials:', error);
                    alert('Error deleting credentials. Please try again.');
                }
            });
        });

        $(document).on('click', '#cancelButtonCredentials', function() {
            $('#credentials-Modal').modal('hide'); // Close the modal
        });
    </script>

<div class="card">
    <div class="card-header">

        <div class="row mt-2" style="width: 100%;">
            <!-- <div class="col col-md-2" style="text-align: right;line-height: 40px;">
                <select id='detail_approved' class="form-control" style="width: 100%">
                <option value="">All Call</option>
                <option value="ANSWERED">Success Call</option>
                <option value="NO ANSWER">Failure Call</option>
                </select>
            </div> -->
            <div class="col col-md-2" style="text-align: right;line-height: 40px;">
                <label><strong>From Date :</strong></label>
            </div>
            <div class="col col-md-2">
                <input type="date" name="detail_from_date" id="detail_from_date" class="form-control" style="width:100%" max="{{ Carbon\Carbon::now()->format('Y-m-d')}}" onblur="func_fixtodate()">
            </div>
            <div class="col col-md-2" style="text-align: right;line-height: 40px;">
                <from class="form-group">
                    <label><strong>To Date :</strong></label>
            </div>
            <div class="col col-md-2">
                <div class="flex">
                    <input type="date" name="detail_to_date" id="detail_to_date" class="form-control" style="width:100%" max="{{ Carbon\Carbon::now()->format('Y-m-d')}}" onblur="func_fixfrmdate()">
                </div>
            </div>
            <div class="col col-md-2">
                <button type="submit" class=" btn btn-primary mx-2 font-bold" id="detail_get_filter" style="width: 100%">Search</button>
            </div>
            </from>

        </div>

    </div>
    <div class="col card-body table-responsive">
        <table class="table table-striped table-bordered" id="system_credential_data-table" style="width:100%">
            <thead>
                <tr>
                <th>No</th>
                    <th>Serial No</th>
                    <th>OS name</th>
                    <th>Version Name</th>
                    <th>User Name</th>
                    <th>User Password</th>
                    <th>Root Password</th>
                    <th>Service Details</th>
                    <th>Credential Status</th>
                    <th>Credential Entry date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade bs-example-modal-md" id="success_msg" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); overflow: visible; padding-right: 15px; width: 420px" data-backdrop="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id='mdl'>
            </div>
        </div>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="credentials-Modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteCredentialsModal" aria-hidden="true" style="position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); overflow: visible; padding-right: 15px; width: 700px;">
        <div class="modal-dialog">
            <div class="modal-content" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
                <div class="modal-header" style="border-top: 4px inset blue; text-align: center;">
                    <h5 class="modal-title">DELETE CREDENTIALS</h5>
                </div>
                <div class="modal-body" id="credentials-list-modal">
                    Do You Want to Delete the Credentials?
                </div>
                <div class="modal-footer" style="background-color: #f8f9fa;">
                    <button type="button" class="btn btn-danger" id="approveButtonCredentials">Delete</button>
                    <button type="button" class="btn btn-primary" id="cancelButtonCredentials" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

<script>
    function func_fixtodate() {
        var frmdate = $("#detail_from_date").val();
        $('#detail_to_date').attr('min', frmdate);
    }

    function func_fixfrmdate() {
        var todate = $("#detail_to_date").val();
        $('#detail_from_date').attr('max', todate);
    }
</script>
</x-app-layout>
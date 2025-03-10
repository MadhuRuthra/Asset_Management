<x-app-layout :assets="$assets ?? []">
    <!-- <div class="mt-4 px-3 ">
        <h2 class="text-2xl font-medium">Sender Id Report</h2>
    </div>
     -->

     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        var assetMasterId;

        function DeleteAssetEntry(asset_manager_id) {
            assetMasterId = asset_manager_id; // Store the asset ID
            $('#entry-Modal').modal('show'); // Show the confirmation modal
        }

        $(document).on('click', '#approveButtonEntry', function() {
            $.ajax({
                url: 'delete_assetentry_data', // Replace with your server endpoint
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "asset_manager_id": assetMasterId, // Use the stored asset ID
                },
                success: function(response) {
                    console.log('Asset entry deleted successfully:', response);
                    var table = $('#entrylist_data-table').DataTable();
                    table.draw();
                    $('#entry-Modal').modal('hide'); // Hide the modal after success
                },
                error: function(error) {
                    console.error('Error deleting asset entry:', error);
                    alert('Error deleting asset entry. Please try again.');
                }
            });
        });

        $(document).on('click', '#cancelButtonEntry', function() {
            $('#entry-Modal').modal('hide'); // Close the modal
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
        <table class="table table-striped table-bordered" id="entrylist_data-table" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Serial No</th>
                    <th>User name</th>
                    <th>Asset Details</th>
                    <th>Detail status</th>
                    <th>Assigned to</th>
                    <th>Entry date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="entry-Modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="noChannelsModal" aria-hidden="true" style="position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); overflow: visible; padding-right: 15px; width: 700px;">
        <div class="modal-dialog">
            <div class="modal-content" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
                <div class="modal-header" style="border-top: 4px inset blue; text-align: center;">
                    <h5 class="modal-title">DELETE ASSET ENTRY</h5>
                </div>
                <div class="modal-body" id="entry-list-modal">
                    Do You Want to Delete the Asset Entry?
                </div>
                <div class="modal-footer" style="background-color: #f8f9fa;">
                    <button type="button" class="btn btn-danger" id="approveButtonEntry">Delete</button>
                    <button type="button" class="btn btn-primary" id="cancelButtonEntry" data-dismiss="modal">Cancel</button>
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
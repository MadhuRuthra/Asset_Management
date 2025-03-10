<x-app-layout :assets="$assets ?? []">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function DeleteAsset(asset_master_id) {
            $('#channel-Modal').modal('show');
            $('#approveButton1').data('asset_master_id', asset_master_id);
        }

        $(document).on('click', '#approveButton1', function() {
            var asset_master_id = $(this).data('asset_master_id');

            $.ajax({
                url: 'delete_asset_data', // Replace with your server endpoint
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "asset_master_id": asset_master_id,
                },
                success: function(response) {
                    console.log('Asset deleted successfully:', response);
                    var table = $('#assetlist_data-table').DataTable();
                    table.draw();
                    $('#channel-Modal').modal('hide');
                },
                error: function(error) {
                    console.error('Error deleting asset:', error);
                    alert('Error deleting asset. Please try again.');
                }
            });
        });

        $(document).on('click', '#cancelButton', function() {
            var table = $('#assetlist_data-table').DataTable();
            table.draw();
            $('#channel-Modal').modal('hide');
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
        <table class="table table-striped table-bordered" id="assetlist_data-table" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Asset Name</th>
                    <th>Asset Serial Name</th>
                    <th>Status</th>
                    <th>Entry Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="channel-Modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="noChannelsModal" aria-hidden="true" style="position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); overflow: visible; padding-right: 15px; width: 700px;">
        <div class="modal-dialog">
            <div class="modal-content" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
                <div class="modal-header" style="border-top: 4px inset blue; text-align: center;">
                    <h5 class="modal-title">DELETE ASSET</h5>
                </div>
                <div class="modal-body" id="channel-list-modal">
                    Do You Want to Delete the Asset?
                </div>
                <div class="modal-footer" style="background-color: #f8f9fa;">
                    <button type="button" class="btn btn-danger" id="approveButton1">Delete</button>
                    <button type="button" class="btn btn-primary" id="cancelButton" data-dismiss="modal">Cancel</button>
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
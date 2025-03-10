<x-app-layout :assets="$assets ?? []">

    <?php
    $os_name = App\Models\Os_Master::where('os_status', '=', 'Y')
        ->select('os_masters.*')
        ->get();
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @if($message = Session::get('success'))
    <script>
        $(document).ready(function() {

            $('#success_msg').modal('show');

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

    <div class="row">
        <div class="col-1">
        </div>
        <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Create OS Details</h4>
                    </div>
                </div>
                <div class="card-body">

                <form action="{{ route('save_os') }}" method="POST" name="save_os_form" id="save_os_form" onsubmit="return validateForm()" enctype="multipart/form-data">

                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="Asset Type">OS Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <select class="form-select mb-3 shadow-none" name="os_name" id="os_name" required>
                                        <option value="" selected disabled>Select the OS Name </option>
                                        @foreach ($os_name as $os)
                                        <option value="{{ $os['os_master_id'] }}">{{ $os['os_name'] }}</option>
                                        @endforeach
                                    </select>
                                    <div id="os_name_error" class="text-danger" style="display: none;">Please select an OS Name.</div>
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <!-- <div class="col-2"></div> -->
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="Remarks">OS Type <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="os_type" name="os_type" placeholder="Please Enter the OS Type" title="Remarks" required minlength="1" maxlength="30">
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <!-- <div class="col-2"></div> -->
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="Remarks ">Version <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="os_version" name="os_version" placeholder="Please Enter the Version" title="Version" required minlength="1" maxlength="30">
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>

                        <div class="checkbox mb-3">
                            <div class="form-check">
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
                            <a href="{{ url('create_os') }}">
                                <button type="button" class="btn btn-danger">Cancel</button>
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-1">
        </div>
    </div>
    </div>

    <div class="modal fade bs-example-modal-md" id="success_msg" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); overflow: visible; padding-right: 15px; width: 420px" data-backdrop="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id='mdl'>
                <!-- <button type="button" class="close" aria-label="Close" style="width: 40px; padding: 0px; border-radius: 5px; margin-left:370px;">
                <span aria-hidden="true">x</span>
            </button> -->
                <!-- <center>
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 512 512" style="fill:#28a745;">
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                </svg>
                <br>
                <h3 style="color:green; font-size:22px; margin-top:10px;"><b>SUCCESS</b></h3>
                <br> -->
                <!-- <p style="margin-top:15px;"><b>{!! $message !!}</b></p> -->
                <!-- <br>
            </center>  -->
                <!-- <button type="button" class="btn btn-success" aria-label="Close" style="margin-top:40px;">Close</button> -->
            </div>
        </div>
    </div>

    <script>
        function toggleOsType() {
            var selectedOs = document.getElementById("os_name");
            var osTypeInput = document.getElementById("os_type");

            if (selectedOs.value === "1" || selectedOs.value === "5") {
                osTypeInput.disabled = true;

                if (selectedOs.value === "1") {
                    osTypeInput.value = 'Windows';
                } else if (selectedOs.value === "5") {
                    osTypeInput.value = 'IOS';
                }
            } else {
                osTypeInput.disabled = false;
                osTypeInput.value = ""; // Clear the input if it was previously filled
            }

        }
    </script>


</x-app-layout>
<x-app-layout :assets="$assets ?? []">

    <?php
    $asset_type = App\Models\Asset_master::where('asset_status', '=', 'S')
        ->select('asset_masters.*')
        ->get();

    $owners_details = App\Models\Owners_master::where('owner_status', '=', 'Y')
        ->select('owners_masters.*')
        ->get();
    ?>

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

    <div class="row">
        <div class="col-1">
        </div>
        <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">New Entry</h4>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('savenewentry') }}" method="POST" name="new_entry_form" id="new_entry_form" onsubmit="" enctype="multipart/form-data">

                        @csrf

                        <div class="form-group">
                            <div class="row">
                                <!-- <div class="col-2"></div> -->
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="Asset Type">Asset Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <select class="form-select mb-3 shadow-none" name="selected_asset" id="selected_asset" required>
                                        <option selected disabled>Select the Asset Name</option>
                                        @foreach ($asset_type as $asset)
                                        <option value="{{ $asset['asset_master_id'] }}">{{ $asset['asset_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="asset_serial_no">Asset Serial No <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="asset_serial_no" name="asset_serial_no" placeholder="" title="Asset Serial Name" required minlength="1" maxlength="4" pattern="[A-Za-z]*" readonly style="background-color: #EAECEE;">
                                </div>
                                <div class="col-2">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <!-- <div class="col-2"></div> -->
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="Manufacture">Manufacture <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="manufacture" name="manufacture" placeholder="Please Enter the Manufacture" title="Manufacture" required minlength="1" maxlength="30">
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <!-- <div class="col-2"></div> -->
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="Supplier">Supplier <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Please Enter the Supplier" title="Supplier" required minlength="1" maxlength="30">
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>

                          <div class="form-group">
                        <div class="row">
                            <div class="col-4 d-flex justify-content-end align-items-center">
                            <label class="form-label fw-bold" for="asset_brand">Asset Brand <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-6">
                            <input type="text" class="form-control" id="asset_brand" name="asset_brand" placeholder="Please Enter Asset Brand" title="Asset Brand" required minlength="1" maxlength="30" oninput="validateInput(this)">
                            </div>
                            <div class="col-2"></div>
                            </div>
                        </div>
                        <div class="form-group">
                        <div class="row">
                            <div class="col-4 d-flex justify-content-end align-items-center">
                            <label class="form-label fw-bold" for="asset_model_name">Asset Model Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-6">
                            <input type="text" class="form-control" id="asset_model_name" name="asset_model_name" placeholder="Please Enter Model Name" title="Asset Model Name" required minlength="1" maxlength="30">
                            </div>
                            <div class="col-2"></div>
                            </div>
                        </div>
                        <div class="form-group">
                        <div class="row">
                            <div class="col-4 d-flex justify-content-end align-items-center">
                            <label class="form-label fw-bold" for="Purchase_date">Purchase Date <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-6">
                            <input type="datetime-local" class="form-control" id="asset_purchase_date"
                             name="asset_purchase_date" title="Asset Purchase Date" required >
                               </div>
                            <div class="col-2"></div>
                            </div>
                        </div>

                        <div id="matchedRecords" class="form-group">
                            <!-- Matched records will be displayed here -->
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <!-- <div class="col-2"></div> -->
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="Remarks ">Remarks </label>
                                </div>
                                <div class="col-6">
                                    <input type="textarea" class="form-control" id="remarks" name="remarks" placeholder="Please Enter the Remarks" title="Remarks" minlength="1" maxlength="100">
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>

                        <!--   <div class="form-group">
                            <label class="form-label fw-bold" for="Ram">Ram:</label>
                            <input type="text" class="form-control" id="ram" name="ram" placeholder="Please Enter the Ram" title="Ram" minlength="1" maxlength="12">
                        </div>
                        <div class="form-group">
                            <label class="form-label fw-bold" for="Rom">Rom:</label>
                            <input type="text" class="form-control" id="rom" name="rom" placeholder="Please Enter the Rom" title="Rom" minlength="1" maxlength="12">
                        </div>
                        <div class="form-group">
                            <label class="form-label fw-bold" for="Processor">Processor:</label>
                            <input type="text" class="form-control" id="processor" name="processor" placeholder="Please Enter the Processor" title="Processor" minlength="1" maxlength="20">
                        </div>
                        <div class="form-group">
                            <label class="form-label fw-bold" for="Mac Address">Mac Address:</label>
                            <input type="text" class="form-control" id="mac_address" name="mac_address" placeholder="Please Enter the Mac Address" title="Mac Address" minlength="1" maxlength="30" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label fw-bold" for="sizeInput">Storage Size:</label>
                            <div class="row">
                                <div class="col-10">
                                    <input type="number" class="form-control" id="sizeInput" placeholder="Enter size" min="0">
                                </div>
                                <div class="col-2">
                                    <select id="unitSelect" class="form-select mb-3 shadow-none">
                                        <option value="KB">KB</option>
                                        <option value="MB">MB</option>
                                        <option value="GB">GB</option>
                                        <option value="TB">TB</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label fw-bold" for="OS">OS:</label>
                            <input type="text" class="form-control" id="os" name="os" placeholder="Please Enter the OS" title="OS" minlength="1" maxlength="20">
                        </div>
                        <div class="form-group">
                            <label class="form-label fw-bold" for="Size">Size:</label>
                            <input type="text" class="form-control" id="size" name="size" placeholder="Please Enter the Size" title="Size" minlength="1" maxlength="12">
                        </div>
                        <div class="form-group">
                            <label class="form-label fw-bold" for="Quantity">Quantity:</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Please Enter the Quantity" title="Quantity" min="1" max="10" required>
                        </div> -->
                        <div class="form-group">
                            <div class="row">
                                <!-- <div class="col-2"></div> -->
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="Assigned to">Assigned to <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <select class="form-select mb-3 shadow-none" name="assigned_to" id="assigned_to" required>
                                        <option selected disabled>Select the Owner Name</option>
                                        @foreach ($owners_details as $owner)
                                        <option value="{{ $owner['owner_name'] }}">{{ $owner['owner_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>
                        <div class="checkbox mb-3">
                            <div class="form-check">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Submit</button>
                            <a href="{{ url('asset_entry') }}">
                                <button type="button" class="btn btn-danger">Cancel</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-1">
        </div>
        <!-- <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Form Grid</h4>
                    </div>
                </div>
                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                    <form>
                        <div class="row">
                            <div class="col">
                            <input type="text" class="form-control" placeholder="First name">
                            </div>
                            <div class="col">
                            <input type="text" class="form-control" placeholder="Last name">
                            </div>
                        </div>
                    </form>
                </div>
            </div> -->
        <!-- <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Input</h4>
                    </div>
                </div>
                <div class="card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                    <form>
                        <div class="form-group">
                            <label class="form-label" for="exampleInputText1">Input Text </label>
                            <input type="text" class="form-control" id="exampleInputText1" value="Mark Jhon" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleInputEmail3">Email Input</label>
                            <input type="email" class="form-control" id="exampleInputEmail3" value="markjhon@gmail.com" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleInputurl">Url Input</label>
                            <input type="url" class="form-control" id="exampleInputurl" value="https://getbootstrap.com" placeholder="Enter Url">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleInputphone">Teliphone Input</label>
                            <input type="tel" class="form-control" id="exampleInputphone" value="1-(555)-555-5555">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleInputNumber1">Number Input</label>
                            <input type="number" class="form-control" id="exampleInputNumber1" value="2356">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="exampleInputPassword3">Password Input</label>
                            <input type="password" class="form-control" id="exampleInputPassword3" value="markjhon123" placeholder="Enter Password">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleInputdate">Date Input</label>
                            <input type="date" class="form-control" id="exampleInputdate" value="2019-12-18">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleInputmonth">Month Input</label>
                            <input type="month" class="form-control" id="exampleInputmonth" value="2019-12">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleInputweek">Week Input</label>
                            <input type="week" class="form-control" id="exampleInputweek" value="2019-W46">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleInputtime">Time Input</label>
                            <input type="time" class="form-control" id="exampleInputtime" value="13:45">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleInputdatetime">Date and Time Input</label>
                            <input type="datetime-local" class="form-control" id="exampleInputdatetime" value="2019-12-19T13:45:00">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="exampleFormControlTextarea1">Example textarea</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="submit" class="btn btn-danger">cancel</button>
                    </form>
                </div>
            </div> -->
        <!-- <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Input Size</h4>
                </div>
            </div>
            <div class="card-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                <form>
                    <div class="form-group">
                        <label class="form-label" for="colFormLabelSm">Small</label>
                        <input type="email" class="form-control form-control-sm" id="colFormLabelSm" placeholder="form-control-sm">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="colFormLabel">Default</label>
                        <input type="email" class="form-control" id="colFormLabel" placeholder="form-control">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label pb-0" for="colFormLabelLg">Large</label>
                        <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="form-control-lg">
                    </div>
                </form>
            </div>
            </div> -->
        <!-- <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Select Size</h4>
                </div>
            </div>
            <div class="card-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam nibh finibus leo</p>
                <div class="form-group">
                    <label class="form-label">Small</label>
                    <select class="form-select form-select-sm mb-3 shadow-none">
                        <option selected="">Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Default</label>
                    <select class="form-select mb-3 shadow-none">
                        <option selected="">Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Large</label>
                    <select class="form-select form-select-lg shadow-none">
                        <option selected="">Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            </div> -->

    </div>
    </div>

    <div class="modal fade bs-example-modal-md" id="success_msg" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); overflow: visible; padding-right: 15px; width: 420px" data-backdrop="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id='mdl'>
            </div>
        </div>
    </div>

<script>
    // Get today's date and time in YYYY-MM-DDTHH:MM format
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
    const dd = String(today.getDate()).padStart(2, '0');
    const hh = String(today.getHours()).padStart(2, '0');
    const min = String(today.getMinutes()).padStart(2, '0');
    const todayString = `${yyyy}-${mm}-${dd}T${hh}:${min}`;

    const purchaseDateInput = document.getElementById('asset_purchase_date');
    purchaseDateInput.setAttribute('max', todayString); // Prevent selection of any date and time after now
</script>

    <script>
        $(document).ready(function(){
            $('#selected_asset').change(function(){
                var assetId = $(this).val();
                
                // Perform an AJAX request
                $.ajax({
                    url: 'generate_serial_no', // Replace with your endpoint
                    type: 'POST', // Use the appropriate method (GET, POST, etc.)
                    data: {
                        asset_id: assetId,
                        _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                    },
                    success: function(response) {
                        // Handle success
                        // alert(response);
                        $('#asset_serial_no').val(response);
                        console.log(response);
                    },
                    error: function(xhr) {
                        // Handle error
                        console.error(xhr);
                    }
                });
            });
        });
    </script>



    <script>
        document.getElementById('selected_asset').addEventListener('change', function() {
            var assetType = this.value;
            const submitBtn = document.getElementById('submitBtn');

            fetch(`assets-by-type`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        asset_type: assetType
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);

                    function createForm(data) {
                        var assetDetailsForm = document.getElementById('matchedRecords');
                        assetDetailsForm.innerHTML = ''; // Clear previous content

                        data.forEach(item => {
                            var assetDetails = JSON.parse(item.asset_details);

                            assetDetails.forEach(detail => {
                                // Create a div with form-group class
                                var formGroupDiv = document.createElement('div');
                                formGroupDiv.classList.add('form-group');

                                // Create the row div
                                var rowDiv = document.createElement('div');
                                rowDiv.classList.add('row');

                                // Create the label column div
                                var labelColDiv = document.createElement('div');
                                labelColDiv.classList.add('col-4','d-flex','justify-content-end','align-items-center',);

                                // Create and style the label
                                var label = document.createElement('label');
                                label.classList.add('form-label', 'fw-bold');
                                label.style.lineHeight = '40px';
                                label.innerHTML = detail.charAt(0).toUpperCase() + detail.slice(1) + '<span style="color: #C03221;"> *</span> ';
                                label.setAttribute('for', detail);

                                // Append the label to the label column div
                                labelColDiv.appendChild(label);

                                // Create the spacer column div
                                var spacerColDiv = document.createElement('div');
                                spacerColDiv.classList.add('col-2');

                                // Create the input column div
                                var inputColDiv = document.createElement('div');
                                inputColDiv.classList.add('col-6');

                                // Create and style the input
                                var input = document.createElement('input');
                                input.type = (detail === 'ram' || detail === 'storage') ? 'number' : 'text';
                                if (detail === 'ram' || detail === 'storage') {
                                    input.max = 1024;
                                }
                                input.name = detail;
                                input.id = detail;
                                input.classList.add('form-control', 'mb-3', 'shadow-none');
                                input.required = true; // Make the input required
                                input.maxLength = 30;

                                // Append the input to the input column div
                                inputColDiv.appendChild(input);

                                var dropColDiv = document.createElement('div');
                                dropColDiv.classList.add('col-2');

                                if (detail === 'ram' || detail === 'storage') {
                                    var select = document.createElement('select');
                                    select.classList.add('form-select', 'shadow-none');

                                    var units = ['KB', 'MB', 'GB', 'TB'];
                                    units.forEach(function(unit) {
                                        var option = document.createElement('option');
                                        option.value = unit;
                                        option.text = unit;
                                        select.appendChild(option);
                                    });

                                    select.addEventListener('change', function() {
                                        // Get the value entered in the input field
                                        var inputValue = input.value;
                                        // Get the selected unit from the dropdown
                                        var selectedUnit = select.value;
                                        // Combine the input value and selected unit
                                        var combinedValue = inputValue + ' ' + selectedUnit;
                                        // Update the input value with the combined value
                                        input.value = combinedValue;
                                    });

                                    dropColDiv.appendChild(select);
                                }


                                // Create the ending spacer column div
                                var endSpacerColDiv = document.createElement('div');
                                endSpacerColDiv.classList.add('col-2');

                                // Append the label, spacer, input, and ending spacer columns to the row div
                                // rowDiv.appendChild(spacerColDiv);
                                rowDiv.appendChild(labelColDiv);
                                rowDiv.appendChild(inputColDiv);
                                rowDiv.appendChild(dropColDiv);
                                rowDiv.appendChild(endSpacerColDiv);

                                // Append the row div to the form-group div
                                formGroupDiv.appendChild(rowDiv);

                                // Append the form-group div to the form
                                assetDetailsForm.appendChild(formGroupDiv);
                            });
                        });

                        checkSubmitButton(); // Call this function after creating the form fields
                    }

                    createForm(data);

                    function checkSubmitButton() {
                        const inputs = document.querySelectorAll('#matchedRecords input');
                        if (inputs.length > 0) {
                            submitBtn.disabled = false;
                        } else {
                            submitBtn.disabled = true;
                        }
                    }
                });
        });

    function validateInput(input) {
            input.value = input.value.replace(/[^A-Za-z]/g, '');
    }

    </script>

</x-app-layout>
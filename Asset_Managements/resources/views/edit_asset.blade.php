<x-app-layout :assets="$assets ?? []">

    <?php

    $owners_details = App\Models\Owners_master::where('owner_status', '=', 'Y')
        ->select('owners_masters.*')
        ->get();
    ?>
      <style>
        .required-field::after {
            content: ' *';
            color: red;
        }
    </style>
    <!-- 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@if($message = Session::get('success'))
 <script>
    $(document).ready(function() 
    {

        $('#success_msg').modal('show');

	    //   function clearFormFields() 
        // {
        //     $('#upload_file').val('');
        //     $('#retry_count').val('0');
        //     $('#context').val('');
	    //   }

        // Add a click event listener to the document body
        $('body').on('click', function(e) 
        {
            // Check if the click target is outside of the modal
            if (!$('#success_msg').is(e.target) && $('#success_msg').has(e.target).length === 0) 
            {
                // Close the modal if the click is outside
                $('#success_msg').modal('hide');
		
            }
        });

        $(document).on('keydown', function(e) 
        {
                  if (e.key === 'Escape') 
                  {
                      $('#success_msg').modal('hide');
             

                  }
	      });

	      $('#success_msg .btn-success').on('click', function()
        {
		          $('#success_msg').modal('hide');
           
	      });

	      $('#success_msg button.close').on('click', function() 
        {
		          $('#success_msg').modal('hide');
           
	      });
	
    });
</script> 

@endif -->

    <div class="row">
        <div class="col-1">
        </div>
        <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit Asset</h4>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('edited_save_asset') }}" method="POST" name="new_entry_form" id="new_entry_form" onsubmit="" enctype="multipart/form-data">

                        @csrf
                        @foreach(json_decode($data, true) as $item)
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold">{{ ucfirst(str_replace('_', ' ', $item['feature_name'])) }} <span style="color:red; margin-left:5px;"> * </span></label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" name="{{ $item['feature_name'] }}" id="{{ $item['feature_name'] }}" class="form-control" 
                                            required value="{{ $item['feature_input'] }}" maxlength="30" 
                                            @if($item['feature_name'] === 'asset_serial_no') readonly style="background-color: #f0f0f0;" @endif><br>
                                    </div>
                                    <div class="col-2"></div>
                                </div>
                            </div>
                            @endforeach


                        <div id="matchedRecords" class="form-group">
                            <!-- Matched records will be displayed here -->
                        </div>
                        <!-- <div class="form-group">
                         <div class="row">
                            <div class="col-4 text-center">
                            <label class="form-label fw-bold" style="line-height: 40px; margin-left:300px;" for="Remarks ">Remarks :</label></div>
                            <div class="col-1"></div>
                            <div class="col-4">
                            <input type="textarea" class="form-control" id="remarks" name="remarks" placeholder="Please Enter the Remarks" title="Remarks" required minlength="1" maxlength="100"></div>
                            <div class="col-3"></div>
                        </div>
                        </div> -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" style="line-height: 10px;" for="Assigned to">Assigned to<span style="color:red; margin-left:5px;"> * </span></label>
                                </div>
                                <div class="col-6">
                                    <select class="form-select mb-3 shadow-none" name="assigned_to" id="assigned_to" required>
                                        <option value="" disabled>Select the Owner name</option>
                                        @php
                                            $selectedOwners = [];
                                        @endphp
                                        @foreach (json_decode($data, true) as $item)
                                            @foreach ($owners_details as $owner)
                                                @if ($item['assigned_to'] == $owner['owner_name'] && !in_array($owner['owner_name'], $selectedOwners))
                                                    <option value="{{ $owner['owner_name'] }}" selected>{{ $owner['owner_name'] }}</option>
                                                    @php
                                                        $selectedOwners[] = $owner['owner_name'];
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endforeach
                                        @foreach ($owners_details as $owner)
                                            @if (!in_array($owner['owner_name'], $selectedOwners))
                                                <option value="{{ $owner['owner_name'] }}">{{ $owner['owner_name'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button type="button" id="addFieldBtn" class="btn btn-primary">Add Field ( + )</button>
                                </div>
                            </div>
                        </div>



                        @foreach($data as $detail)
                        <input type="hidden" name="asset_master_id" id="asset_master_id" class="form-control" value="{{ $item['asset_manager_id'] }}">
                        @endforeach

                        <div id="dynamicFieldsContainer" class="form-group"></div>

                        <div class="checkbox mb-3">
                            <div class="form-check">
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ url('entry_list') }}">
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
        document.addEventListener('DOMContentLoaded', (event) => {
            const dynamicFieldsContainer = document.getElementById('dynamicFieldsContainer');
            const addFieldBtn = document.getElementById('addFieldBtn');
            const assetForm = document.getElementById('assetForm');
            const submitBtn = document.getElementById('submitBtn');


            addFieldBtn.addEventListener('click', function() {
                addInputField();
                checkSubmitButton();
            });

            assetForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const selectedAsset = assetSelect.value;
                const inputValues = Array.from(dynamicFieldsContainer.querySelectorAll('input[name="asset_details[]"]')).map(input => input.value);

                console.log('Selected Asset:', selectedAsset);
                console.log('Input Values:', inputValues);

                // You can now send this data to your server or process it as needed.
                // Example: 
                // sendFormData(selectedAsset, inputValues);
            });

            function addInputField() {
                // Create a div with the form-group class
                const formGroupDiv = document.createElement('div');
                formGroupDiv.className = 'form-group';

                // Create the row div
                const rowDiv = document.createElement('div');
                rowDiv.className = 'row';

                var labelColDiv = document.createElement('div');
                labelColDiv.classList.add('col-4');

                // Create the input column div
                const inputColDiv = document.createElement('div');
                inputColDiv.className = 'col-6';

                // Create the input field
                const inputField = document.createElement('input');
                inputField.type = 'text';
                inputField.name = 'asset_details[]';
                inputField.className = 'form-control';
                inputField.placeholder = 'Enter the Asset Details';
                inputField.required = true; // Make the input required
                inputField.maxLength = 30; // Set the maximum length to 30
                

                // Create the input field
                const inputLabelField = document.createElement('input');
                inputLabelField.type = 'text';
                inputLabelField.name = 'asset_labels[]';
                inputLabelField.className = 'form-control';
                inputLabelField.placeholder = 'Enter the Field Name';
                inputLabelField.required = true; // Make the input required
                inputLabelField.maxLength = 30; // Set the maximum length to 30

                // Add event listener to validate the input field for alphabets only
                inputField.addEventListener('input', function() {
                    this.value = this.value.replace(/[^a-zA-Z0-9]/g, ''); // Allow only alphanumeric characters
                });
                // Append the input field to the input column div
                inputColDiv.appendChild(inputField);

                labelColDiv.appendChild(inputLabelField);

                // Create the button column div
                const buttonColDiv = document.createElement('div');
                buttonColDiv.className = 'col-2';

                // Create the add button
                const addBtn = document.createElement('button');
                addBtn.type = 'button';
                addBtn.className = 'btn btn-primary';
                addBtn.textContent = 'Add Field';
                addBtn.onclick = function() {
                    addInputField();
                    checkSubmitButton();
                };

                // Create the remove button
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger text-center';
                // removeBtn.style.marginLeft = '120px';
                removeBtn.textContent = 'Remove ( - )';
                removeBtn.onclick = function() {
                    formGroupDiv.remove();
                    checkSubmitButton();
                };

                // Create the ending spacer column div
                var endSpacerColDiv = document.createElement('div');
                endSpacerColDiv.classList.add('col-2');

                // Append both buttons to the button column div
                buttonColDiv.appendChild(removeBtn);

                // Append the input and button columns to the row div
                rowDiv.appendChild(labelColDiv);
                rowDiv.appendChild(inputColDiv);
                rowDiv.appendChild(buttonColDiv);

                // Append the row div to the form-group div
                formGroupDiv.appendChild(rowDiv);

                // Append the form-group div to the dynamic fields container    
                dynamicFieldsContainer.appendChild(formGroupDiv);

                checkSubmitButton();
            }

            function checkSubmitButton() {
                const inputs = dynamicFieldsContainer.querySelectorAll('input[name="asset_details[]"]');
                if (inputs.length > 0) {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            }

        });
    </script>


</x-app-layout>
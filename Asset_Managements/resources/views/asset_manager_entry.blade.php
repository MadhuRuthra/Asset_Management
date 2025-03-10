<x-app-layout :assets="$assets ?? []">

<?php
$asset_type = App\Models\Asset_master::where('asset_status', '=', 'Y')
    ->select('asset_masters.*')
    ->get();
?>

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

@endif
    
<div class="d-flex justify-content-end">
    <a href="{{ url('asset_creation') }}">
    <button type="submit" class="btn btn-danger btn-round">Create Asset</button>
    </a>
</div>

<div class="row">
        <div class="col-1">
            </div>
            <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Asset Master Entry</h4>
                    </div>
                </div>
                <div class="card-body">

                <form action="{{ route('savemanagerentry') }}" method="POST" name="new_managerentry_form" id="new_managerentry_form" onsubmit="" enctype="multipart/form-data">

                @csrf
                <div class="form-group">
                    <div class="row">
                    <!-- <div class="col-2"></div> -->
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <label class="form-label fw-bold" for="Asset Type">Asset Type <span class="text-danger">*</span></label>
                    </div>
                                        
                        <div class="col-6">
                        <select class="form-select mb-3 shadow-none" name="selected_asset" id="selected_asset" required>
                            <option selected disabled>Select the asset type</option>
                            @foreach ($asset_type as $asset)
                            <option value="{{ $asset['asset_master_id'] }}">{{ $asset['asset_type'] }} - {{ $asset['asset_model_name'] }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="col-2"> </div>  
                        </div>
                </div>
                <div class="form-group">
                        <div class="row">
                        <!-- <div class="col-2"></div> -->
                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <label class="form-label fw-bold" for="Remarks ">Remarks </label></div>
                            <div class="col-6">
                            <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Please Enter the Remarks" title="Remarks" minlength="1" maxlength="100"></div>
                            <div class="col-2"><button type="button" id="addFieldBtn" class="btn btn-primary" style="display: none;">Add Field ( + )</button></div>
                        </div>
                </div>  

                    <div id="dynamicFieldsContainer" class="form-group"></div>
                   
                        <div class="checkbox mb-3">
                            <div class="form-check">
                            </div>
                        </div>
                        <div class="text-center">
                        <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Submit</button>
                        <a href="{{ url('dashboard') }}">
                        <button type="button" class="btn btn-danger">cancel</button>
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
document.addEventListener('DOMContentLoaded', (event) => {
    const assetSelect = document.getElementById('selected_asset');
    const dynamicFieldsContainer = document.getElementById('dynamicFieldsContainer');
    const addFieldBtn = document.getElementById('addFieldBtn');
    const assetForm = document.getElementById('assetForm');
    const submitBtn = document.getElementById('submitBtn');

    assetSelect.addEventListener('change', function() {
        dynamicFieldsContainer.innerHTML = ''; // Clear previous input fields
        addFieldBtn.style.display = 'block'; // Show the add button
        addInputField(); // Add the first input field
    });

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

    var spacerColDiv = document.createElement('div');
    spacerColDiv.classList.add('col-4');

    // Create the input column div
    const inputColDiv = document.createElement('div');
    inputColDiv.className = 'col-6';

    // Create the input field
    const inputField = document.createElement('input');
    inputField.type = 'text';
    inputField.name = 'asset_details[]';
    inputField.className = 'form-control';
    inputField.placeholder = 'Enter the asset details';
    inputField.required = true; // Make the input required
    inputField.maxLength = 30; // Set the maximum length to 30

    // Add event listener to validate the input field for alphabets only
    inputField.addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-Z]/g, ''); // Allow only alphabets
    });

    // Append the input field to the input column div
    inputColDiv.appendChild(inputField);

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
    rowDiv.appendChild(spacerColDiv);
    rowDiv.appendChild(inputColDiv);
    rowDiv.appendChild(buttonColDiv);
    rowDiv.appendChild(endSpacerColDiv);

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
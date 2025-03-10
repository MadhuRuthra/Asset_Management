<x-app-layout :assets="$assets ?? []">

<style>
    .error-msg {
        margin-top: 10px; /* Adjust the spacing as needed */
    }

</style>

<div class="row">
        <div class="col-1">
            </div>
            <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Asset Creation</h4>
                    </div>
                </div>
                <div class="card-body">
                <form action="{{ route('savenewasset') }}" method="POST" name="asset_creation_form" id="asset_creation_form" onsubmit="return checkSubmitButton()" enctype="multipart/form-data">
                @csrf
                        <div class="form-group">
                            <div class="row">
                            <div class="col-4 d-flex justify-content-end align-items-center">
                            <label class="form-label fw-bold" for="asset_name">Asset Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-6">
                            <input type="text" class="form-control" id="asset_name" name="asset_name" placeholder="Please Enter Asset Name" title="Asset Name" required minlength="1" maxlength="30" oninput="validateInput1(this)">
                            </div>
                            <div class="col-2"></div>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                        <div class="row">
                            <div class="col-4 d-flex justify-content-end align-items-center">
                            <label class="form-label fw-bold" for="asset_type">Asset Type <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-6">
                            <input type="text" class="form-control" id="asset_type" name="asset_type" placeholder="Please Enter Asset Type" title="Asset Type" required minlength="1" maxlength="40">
                            </div>
                            <div class="col-2"></div>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="asset_serial_name">Asset Serial Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="asset_serial_name" name="asset_serial_name" placeholder="Please Enter Asset Serial Name" title="Asset Serial Name" required minlength="1" maxlength="4" pattern="[A-Za-z]*" oninput="validateInput(this)">
                                </div>
                                <div class="col-2">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <div class="row">
                        <!-- <div class="col-2"></div> -->
                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <label class="form-label fw-bold" for="Remarks ">Remarks </label></div>
                            <div class="col-6">
                            <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Please Enter the Remarks (50 Characters Only)" title="Remarks" minlength="1" maxlength="50"></div>
                            <div class="col-2"><button type="button" id="addFieldBtn" class="btn btn-primary">Add Field ( + )</button></div>
                        </div>
                        </div>  
                        <!-- <div class="form-group">
                        <div class="row">
                            <div class="col-4 d-flex justify-content-end align-items-center">
                            <label class="form-label fw-bold" for="asset_brand">Asset Brand <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-6">
                            <input type="text" class="form-control" id="asset_brand" name="asset_brand" placeholder="Please Enter Asset Brand" title="Asset Brand" required minlength="1" maxlength="30">
                            </div>
                            <div class="col-2"></div>
                            </div>
                        </div> -->
                        <!-- <div class="form-group">
                        <div class="row">
                            <div class="col-4 d-flex justify-content-end align-items-center">
                            <label class="form-label fw-bold" for="asset_model_name">Asset Model Name <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-6">
                            <input type="text" class="form-control" id="asset_model_name" name="asset_model_name" placeholder="Please Enter Model Name" title="Asset Model Name" required minlength="1" maxlength="30">
                            </div>
                            <div class="col-2"></div>
                            </div>
                        </div> -->
                        <!-- <div class="form-group">
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
                        </div> -->
                        <div id="dynamicFieldsContainer" class="form-group"></div>
                        <div class="checkbox mb-3">
                            <div class="form-check">
                                <!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                <label class="form-check-label" for="flexCheckDefault3">
                                    Remember me
                                </label> -->
                            </div>
                        </div>
                        <div class="text-center">
                        <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
                        <a href="{{ url('asset_creation') }}">
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
<script>
function validateInput(input) {
    input.value = input.value.replace(/[^A-Za-z]/g, '');
}
function validateInput1(input) {
    input.value = input.value.replace(/[^A-Za-z0-9]/g, '');
}
</script>


<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const dynamicFieldsContainer = document.getElementById('dynamicFieldsContainer');
    const addFieldBtn = document.getElementById('addFieldBtn');
    const assetForm = document.getElementById('assetForm');
    const submitBtn = document.getElementById('submitBtn');

    const restrictedValues = ["manufacture", "asset brand", "asset model name", "supplier"];

    // Add the default input field
    addInputField();

    addFieldBtn.addEventListener('click', function() {
        addInputField();
    });

    assetForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const inputValues = Array.from(dynamicFieldsContainer.querySelectorAll('input[name="asset_details[]"]')).map(input => input.value);

        console.log('Input Values:', inputValues);

        // You can now send this data to your server or process it as needed.
        // Example: 
        // sendFormData(inputValues);
    });

    function addInputField() {
        const formGroupDiv = document.createElement('div');
        formGroupDiv.className = 'form-group';

        const rowDiv = document.createElement('div');
        rowDiv.className = 'row';

        const spacerColDiv = document.createElement('div');
        spacerColDiv.className = 'col-4';

        const inputColDiv = document.createElement('div');
        inputColDiv.className = 'col-6';

        const inputField = document.createElement('input');
        inputField.type = 'text';
        inputField.name = 'asset_details[]';
        inputField.className = 'form-control';
        inputField.placeholder = 'Enter the Asset Details (Column Name)';
        inputField.required = true; // Make the input required
        inputField.maxLength = 30; // Set the maximum length to 30


        // Add event listener to validate the input field for alphabets only
        inputField.addEventListener('input', function() {
         this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); // Allow only alphabets

            // Check for restricted values
            const inputValue = this.value.trim();
            if (restrictedValues.includes(inputValue.toLowerCase())) {
                errorMsg.textContent = 'That Field Already Exists. So Use Different Name.';
                errorMsg.style.display = 'block';
                submitBtn.disabled = true;
            } else {
                errorMsg.textContent = '';
                errorMsg.style.display = 'none';
                submitBtn.disabled = false;
            }

        });

        inputColDiv.appendChild(inputField);

                // Create an error message span
        const errorMsg = document.createElement('span');
        errorMsg.className = 'text-danger error-msg';
        errorMsg.style.display = 'none'; // Hide by default
        inputColDiv.appendChild(errorMsg);

        const buttonColDiv = document.createElement('div');
        buttonColDiv.className = 'col-2';

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'btn btn-danger text-center';
        removeBtn.textContent = 'Remove ( - )';
        removeBtn.onclick = function() {
            formGroupDiv.remove();
            checkSubmitButton();
        };

        const endSpacerColDiv = document.createElement('div');
        endSpacerColDiv.className = 'col-2';

        buttonColDiv.appendChild(removeBtn);
        rowDiv.appendChild(spacerColDiv);
        rowDiv.appendChild(inputColDiv);
        rowDiv.appendChild(buttonColDiv);
        rowDiv.appendChild(endSpacerColDiv);
        formGroupDiv.appendChild(rowDiv);
        dynamicFieldsContainer.appendChild(formGroupDiv);

        checkSubmitButton();
    }

    function checkSubmitButton() {
        const inputs = dynamicFieldsContainer.querySelectorAll('input[name="asset_details[]"]');
        submitBtn.disabled = inputs.length === 0;
    }
});
</script>



</x-app-layout>
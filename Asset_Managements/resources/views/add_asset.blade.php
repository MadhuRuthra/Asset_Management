<x-app-layout :assets="$assets ?? []">
<div class="row">
        <div class="col-1">
            </div>
            <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Add Asset</h4>
                      
                    </div>
                </div>
                <div class="card-body">
                 
                <form action="{{ route('save_asset') }}" method="POST" name="new_entry_form" id="new_entry_form" onsubmit="" enctype="multipart/form-data">
                        
                @csrf           
                <button type="button" id="addFieldBtn" class="btn btn-primary">Add Field ( + )</button>    

                @foreach($data as $asset)
                    <div class="asset text-center">
                        <h5><label>{{ strtoupper($asset->asset_name) }}</label></h5>
                    </div><br>
                @endforeach

                         
                @php
                    $details = json_decode($data[0]->asset_details, true);

                @endphp

                @foreach($details as $detail)
                    <div class="form-group">
                        <div class="row">
                            <div class="col-2 text-center">
                            </div>
                            <div class="col-2"></div>
                            <div class="col-5"> 
                                <input type="text" name="{{ $detail }}" id="{{ $detail }}" class="form-control" value="{{ $detail }}" readonly style="background-color: #EAECEE;"><br>
                            </div>
                            <div class="col-3"></div>
                        </div>
                    </div>
                @endforeach
                @foreach($data as $detail)
                <input type="hidden" name="asset_master_id" id="asset_master_id" class="form-control" value="{{ $detail->asset_master_id }}">
                @endforeach
                <div id="dynamicFieldsContainer" class="form-group"></div>

                        <div class="checkbox mb-3">
                            <div class="form-check">
                            </div>
                        </div>
                        <div class="text-center">
                        <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Submit</button>
                        <a href="{{ url('asset_list') }}">
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
        document.addEventListener('DOMContentLoaded', (event) => {
            const addFieldBtn = document.getElementById('addFieldBtn');
            const dynamicFieldsContainer = document.getElementById('dynamicFieldsContainer');
            const submitBtn = document.getElementById('submitBtn');

            addFieldBtn.addEventListener('click', function() {
                addInputField();
                checkSubmitButton();
            });

            function addInputField() {
                // Create a div with the form-group class
                const formGroupDiv = document.createElement('div');
                formGroupDiv.className = 'form-group';

                // Create the row div
                const rowDiv = document.createElement('div');
                rowDiv.className = 'row';

                var spacerColDiv = document.createElement('div');
                spacerColDiv.classList.add('col-3');

                // Create the input column div
                const inputColDiv = document.createElement('div');
                inputColDiv.className = 'col-4';

                // Create the input field
                const inputField = document.createElement('input');
                inputField.type = 'text';
                inputField.name = 'asset_details[]';
                inputField.className = 'form-control';
                inputField.placeholder = 'Enter the Asset Details';
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
                buttonColDiv.className = 'col-3';

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
                removeBtn.className = 'btn btn-danger';
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
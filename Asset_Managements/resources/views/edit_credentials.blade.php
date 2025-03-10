<x-app-layout :assets="$assets ?? []">

    <?php

    $os_master = App\Models\Os_Master::where('os_status', '=', 'Y')
        ->select('os_masters.*')
        ->get();

    $version_master = App\Models\Version_Master::where('version_status', '=', 'Y')
        ->select('version_masters.*')
        ->get();

    ?>

    <div class="row">
        <div class="col-1">
        </div>
        <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit Credentials</h4>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('edited_save_credentials') }}" method="POST" name="new_entry_form" id="new_entry_form" onsubmit="" enctype="multipart/form-data" onsubmit="return validateForm()">

                        @csrf

                        @foreach($data as $item)

                        @php
                           $filtered_value = preg_replace('/[^A-Za-z]/', '', $item->serial_number);
                        @endphp

                        <div class="form-group">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" style="line-height: 40px;">Serial Number</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="serial_number" id="serial_number" class="form-control" required value="{{ $item->serial_number }}" maxlength="30" readonly style="background-color: #EAECEE;">
                                    <input type="hidden" id="valueHolder" value="{{ $item->serial_number }}">
                                </div>

                                <div class="col-2">
                                @if ($filtered_value !== 'YJMB')
                                    <button type="button" id="addFieldBtn" class="btn btn-primary" style="">Add Field ( + )</button>
                                @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="selected_os_name">OS Name <span class="text-danger"></span></label>
                                </div>
                                <div class="col-6">
                                    <select class="form-select mb-3 shadow-none" name="selected_os_name" id="selected_os_name" onchange="toggleFields()" required>
                                        <!-- <option value="" selected disabled>Select the OS Name</option> -->
                                        @foreach ($os_master as $os)
                                        @foreach ($data as $editdata)
                                        @if ($os['os_master_id'] == $editdata->os_master_id)
                                        <optgroup label="{{ $os['os_name'] }}">
                                            @foreach ($version_master as $vs)
                                            @if ($vs['os_master_id'] == $os['os_master_id'] && $vs['version_master_id'] == $editdata->version_master_id)
                                            <option value="{{ $vs['os_master_id'] }}~{{ $vs['version_master_id'] }}">
                                                @if ($vs['os_master_id'] != 2 && $vs['os_master_id'] != 4)
                                                {{ $os['os_name'] }} - {{ $vs['version_name'] }}
                                                @else
                                                {{ $vs['version_type'] }} - {{ $vs['version_name'] }}
                                                @endif
                                            </option>
                                            @endif
                                            @endforeach
                                        </optgroup>
                                        @endif
                                        @endforeach
                                        @endforeach
                                    </select>
                                    <span id="error-message" class="text-danger" style="display:none;">Please select an OS Name</span>
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>

                        @if ($filtered_value !== 'YJMB')
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" style="line-height: 40px;">User Name</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="user_name" id="user_name" class="form-control" required value="{{ $item->user_name }}" maxlength="30"><br>
                                </div>

                                <div class="col-2"></div>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                @if ($filtered_value !== 'YJMB')
                                    <label class="form-label fw-bold" style="line-height: 40px;">User Password</label>
                                @else
                                <label class="form-label fw-bold" style="line-height: 40px;">Pin Number</label>
                                @endif
                                </div>
                                <div class="col-6">
                                    <input type="text" name="password" id="password" class="form-control" required value="{{ $item->password }}" maxlength="30"><br>
                                </div>

                                <div class="col-2"></div>
                            </div>
                        </div>

                        @if ($filtered_value !== 'YJMB')
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" style="line-height: 40px;">Root Password</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="root_password" id="root_password" class="form-control" required value="{{ $item->root_password ?? '-' }}" maxlength="30"><br>
                                </div>

                                <div class="col-2"></div>
                            </div>
                        </div>
                        @endif

                        @endforeach

                      
                        @foreach($data as $item)
                            @php
                                $mysqlUserPassword = json_decode($item->mysql_user_password, true);
                            @endphp

                            @if (!empty($mysqlUserPassword))
                                @foreach($mysqlUserPassword as $passwordInfo)
                                    <!-- Row for Service -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4 d-flex justify-content-end align-items-center">
                                                <label class="form-label fw-bold">Service</label>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="credential_title[]" class="form-control" value="{{ $passwordInfo['Service'] }}">
                                            </div>
                                            <div class="col-2"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Row for User Name -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4 d-flex justify-content-end align-items-center">
                                                <label class="form-label fw-bold">User Name</label>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="credential_value[]" class="form-control" required value="{{ $passwordInfo['User Name'] }}" maxlength="30">
                                            </div>
                                            <div class="col-2"></div>
                                        </div>
                                    </div>

                                    <!-- Row for Password -->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4 d-flex justify-content-end align-items-center">
                                                <label class="form-label fw-bold">Password</label>
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="credential_label[]" class="form-control" value="{{ $passwordInfo['Password'] }}">
                                            </div>
                                            <div class="col-2">
                                                
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    
                                               
                        @foreach($data as $detail)
                        <input type="hidden" name="credential_id" id="credential_id" class="form-control" value="{{ $detail->credential_id }}">
                        @endforeach

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

                        <div id="dynamicFieldsContainer"></div>

                        <div class="checkbox mb-3">
                            <div class="form-check">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="SubmitBtn" class="btn btn-primary">Submit</button>
                            <a href="{{ url('system_credentials_list') }}">
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
                <!-- <br>
            </center>  -->
                <!-- <button type="button" class="btn btn-success" aria-label="Close" style="margin-top:40px;">Close</button> -->
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var rootPasswordInput = document.getElementById('root_password');
        if (rootPasswordInput.value === '-') {
            rootPasswordInput.disabled = true;
        }
    });
</script>

    <script>
        function validateForm() {
            const osSelect = document.getElementById('selected_os_name');
            const errorMessage = document.getElementById('error-message');

            if (osSelect.value === "") {
                errorMessage.style.display = 'block';
                return false; // Prevent form submission
            } else {
                errorMessage.style.display = 'none';
                return true; // Allow form submission
            }
            
        }

        function toggleFields() {
            // Your existing toggleFields logic here
        }

         // Add a click event listener to the document body
        $('body').on('click', function(e) 
            {
            // Check if the click target is outside of the modal
            if (!$('#responseModal').is(e.target) && $('#responseModal').has(e.target).length === 0) 
            {
                // Close the modal if the click is outside
                $('#responseModal').modal('hide');
                clearFormFields();
                location.reload();
            }
        });

        $(document).on('keydown', function(e) 
            {
            if (e.key === 'Escape') 
            {
                $('#responseModal').modal('hide');
                clearFormFields();
                location.reload();

            }
              });

              $('#responseModal .btn-success').on('click', function()
            {
        $('#responseModal').modal('hide');
                clearFormFields();
                location.reload();
              });

              $('#responseModal button.close').on('click', function() 
          {
                        $('#responseModal').modal('hide');
                clearFormFields();
                location.reload();
              });


    </script>


<script>
        $(document).ready(function() {
            // Get the value of the hidden input
            var selectedValue = $('#valueHolder').val();

            alert(selectedValue);

            // Check the value and hide/show the submit button
            if (selectedValue === 'YJMB') {
                $('#addFieldBtn').hide();
            } else {
                $('#addFieldBtn').show();
            }

            // Event listener example to show/hide based on user action
            $('#someOtherElement').on('change', function() {
                selectedValue = $(this).val();
                if (selectedValue === 'YJMB') {
                    $('#addFieldBtn').hide();
                } else {
                    $('#addFieldBtn').show();
                }
            });
        });
    </script>

<script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const assetSelect = document.getElementById('selected_os_name');
            const dynamicFieldsContainer = document.getElementById('dynamicFieldsContainer');
            const addFieldBtn = document.getElementById('addFieldBtn');
            const assetForm = document.getElementById('assetForm');

            const selectedValue = $('#serial_number').val().replace(/[^a-zA-Z]/g, '');

            assetSelect.addEventListener('change', function() {
                dynamicFieldsContainer.innerHTML = '';
                addFieldBtn.style.display = 'block';
                addInputField();
            });

            addFieldBtn.addEventListener('click', function() {
                addInputField();
            });

            assetForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const selectedAsset = assetSelect.value;
                const inputValues = Array.from(dynamicFieldsContainer.querySelectorAll('input[name="asset_details[]"]')).map(input => input.value);

                console.log('Selected Asset:', selectedAsset);
                console.log('Input Values:', inputValues);
            });

            function addInputField() {

                const selectedValue = $('#serial_number').val().replace(/[^a-zA-Z]/g, '');

                if (selectedValue === 'YJMB') {
                    $('#pin_number_field').show();
                    $('#os_field').show();
                    $('#user_name_field').hide();
                    $('#user_password_field').hide();
                    $('#root_password_field').hide();
                    $('#dynamicFieldsContainer').hide();
                    $('#selected_os_name').attr('required', '');
                    $('#root_password').removeAttr('required');
                    $('#user_name').removeAttr('required');
                    $('#user_password').removeAttr('required');
                   
                      // Remove 'required' attribute and then remove form groups
            $('input[name="asset_titles[]"]').each(function() {
                $(this).removeAttr('required').closest('.form-group').remove();
            });

            $('input[name="asset_details[]"]').each(function() {
                $(this).removeAttr('required').closest('.form-group').remove();
            });

            $('input[name="asset_label[]"]').each(function() {
                $(this).removeAttr('required').closest('.form-group').remove();
            });

                }else{

                const formGroupDiv = document.createElement('div');
                formGroupDiv.className = 'form-group';

                const rowDiv = document.createElement('div');
                rowDiv.className = 'row';

                const spacerColDiv = document.createElement('div');
                spacerColDiv.classList.add('col-1');

                const inputTitleDiv = document.createElement('div');
                inputTitleDiv.classList.add('col-3');

                const inputColDiv = document.createElement('div');
                inputColDiv.className = 'col-3';

                const inputlabelDiv = document.createElement('div');
                inputlabelDiv.className = 'col-3';

                // Generate unique IDs
                const uniqueId = Math.floor(Math.random() * 1000);
                const idPrefix = 'inputField-' + uniqueId + '-';

                const inputTitleField = document.createElement('input');
                inputTitleField.type = 'text';
                inputTitleField.id = idPrefix + 'title';
                inputTitleField.name = 'asset_titles[]';
                inputTitleField.className = 'form-control';
                inputTitleField.placeholder = 'Enter the Service name';
                inputTitleField.required = true;
                inputTitleField.maxLength = 30;

                const inputField = document.createElement('input');
                inputField.type = 'text';
                inputField.id = idPrefix + 'details';
                inputField.name = 'asset_details[]';
                inputField.className = 'form-control';
                inputField.placeholder = 'Enter the User Name';
                inputField.required = true;
                inputField.maxLength = 30;

                const inputlabelField = document.createElement('input');
                inputlabelField.type = 'text';
                inputlabelField.id = idPrefix + 'label';
                inputlabelField.name = 'asset_label[]';
                inputlabelField.className = 'form-control';
                inputlabelField.placeholder = 'Enter the Password';
                inputlabelField.required = true;
                inputlabelField.maxLength = 30;

                // Add event listener to validate the input field for alphabets only
                inputField.addEventListener('input', function() {
                    this.value = this.value.replace(/[^a-zA-Z0-9!@#$%^&*()-=_+[\]{}|;:'",.<>?]/g, ''); // Allow alphanumeric values and specific special characters, but disallow spaces
                });

                inputlabelField.addEventListener('input', function() {
                    this.value = this.value.replace(/[^a-zA-Z0-9!@#$%^&*()-=_+[\]{}|;:'",.<>?]/g, ''); 
                });

                inputColDiv.appendChild(inputField);

                inputlabelDiv.appendChild(inputlabelField);

                inputTitleDiv.appendChild(inputTitleField);

                const buttonColDiv = document.createElement('div');
                buttonColDiv.className = 'col-2';

                const addBtn = document.createElement('button');
                addBtn.type = 'button';
                addBtn.className = 'btn btn-primary';
                addBtn.textContent = 'Add Field';
                addBtn.onclick = function() {
                    addInputField();
                };

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger';
                removeBtn.textContent = 'Remove ( - )';
                removeBtn.onclick = function() {
                    formGroupDiv.remove();
                };

                buttonColDiv.appendChild(removeBtn);

                rowDiv.appendChild(spacerColDiv);
                rowDiv.appendChild(inputTitleDiv);
                rowDiv.appendChild(inputColDiv);
                rowDiv.appendChild(inputlabelDiv);
                rowDiv.appendChild(buttonColDiv);

                formGroupDiv.appendChild(rowDiv);

                dynamicFieldsContainer.appendChild(formGroupDiv);

            }
        }
        
        });
    </script>

</x-app-layout>
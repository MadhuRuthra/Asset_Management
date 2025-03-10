<x-app-layout :assets="$assets ?? []">


    <?php
    $os_master = App\Models\Os_Master::where('os_status', '=', 'Y')
        ->select('os_masters.*')
        ->get();

    $version_master = App\Models\Version_Master::where('version_status', '=', 'Y')
        ->select('version_masters.*')
        ->get();

        $asset_managers = App\Models\Asset_manager::where(function($query) {
            $query->whereRaw("REGEXP_REPLACE(asset_serial_no, '[^A-Z]', '') = 'YJMB'")
                  ->orWhereRaw("REGEXP_REPLACE(asset_serial_no, '[^A-Z]', '') = 'YJLP'")
                  ->orWhereRaw("REGEXP_REPLACE(asset_serial_no, '[^A-Z]', '') = 'YJPC'");
        })
        ->where('assigned_status', 'Y')
        ->select('asset_serial_no')
        ->get();
    ?>

    <style>
        .input-group-append {
            cursor: pointer;
        }

        .input-group-text {
            border-left: none;
            background: none;
            height: 42px;
        }

        .fa-eye,
        .fa-eye-slash {
            cursor: pointer;
        }
    </style>

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



    <div class="d-flex justify-content-end">
        <a href="{{ url('create_os') }}">
            <button type="submit" class="btn btn-danger btn-round {{activeRoute(route('create_os'))}}">Create OS</button>
        </a>
    </div>

    <div class="row">
        <div class="col-1">
        </div>
        <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Credentials Entry</h4>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('savesystemcredentials') }}" method="POST" name="new_entry_form" id="new_entry_form" enctype="multipart/form-data" >

                        @csrf

                        <div class="form-group">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="serial_number">Serial No <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <select class="form-select mb-3 shadow-none" name="serial_number" id="serial_number" onchange="checkSerialNumber()">
                                        <option selected disabled>Select the Serial No</option>
                                        @foreach ($asset_managers as $asset)
                                        <option value="{{ $asset['asset_serial_no'] }}">{{ $asset['asset_serial_no'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>

                        <div class="form-group" id="pin_number_field" style="display: none;">
                            <div class="row">
                                <!-- <div class="col-2"></div> -->
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="pin_number">Pin Number <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="pin_number" name="pin_number" placeholder="Enter the Pin Number" title="Pin Number" minlength="1" maxlength="20" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" data-toggle="pin_number">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>

                        <div class="form-group" id="os_field" style="display: none;">
                            <div class="row">
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="Asset Type">OS Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <select class="form-select mb-3 shadow-none" name="selected_os_name" id="selected_os_name" required>
                                        <option selected disabled>Select the OS Name</option>
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                    <span id="osError" style="color:red; display:none;">Please select an OS</span>
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>
                        

                        <div class="form-group" id="user_name_field" style="display: none;">
                            <div class="row">
                                <!-- <div class="col-2"></div> -->
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="User name">User Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Please Enter the User Name" required title="User Name" minlength="1" maxlength="30">
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>

                        <div class="form-group" id="user_password_field" style="display: none;">
                            <div class="row">
                                <!-- <div class="col-2"></div> -->
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="user_password">User Password <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter the User Password" required title="User Password" minlength="1" maxlength="20">
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" data-toggle="user_password">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2"> <button type="button" id="addFieldBtn" class="btn btn-primary" style="display: none;">Add Field ( + )</button></div>
                            </div>
                        </div>

                        <div class="form-group" id="root_password_field" style="display: none;">
                            <div class="row">
                                <!-- <div class="col-2"></div> -->
                                <div class="col-4 d-flex justify-content-end align-items-center">
                                    <label class="form-label fw-bold" for="root_password">Root Password <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="root_password" name="root_password" placeholder="Enter the Root Password" title="Root Password" minlength="1" maxlength="20" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" data-toggle="root_password">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <div class="row">
                            <div class="col-2"></div>
                                <div class="col-4 text-center">
                                    <label class="form-label fw-bold" for="Remarks ">Mysql user & Password :</label>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="mysql_user_password" name="mysql_user_password" placeholder="Please Enter the Remarks" title="Remarks" required minlength="1" maxlength="100">
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                            <div class="col-2"></div>
                                <div class="col-4 text-center">
                                    <label class="form-label fw-bold" for="Remarks ">Mongodb user & Password :</label>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="mongodb_user_password" name="mongodb_user_password" placeholder="Please Enter the Remarks" title="Remarks" required minlength="1" maxlength="100">
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </div> -->

                        <div id="dynamicFieldsContainer"></div>

                        <div class="checkbox mb-3">
                            <div class="form-check">
                            </div>
                        </div>


                        <div class="text-center">
                            <button type="submit" id ="submitBtn" class="btn btn-primary">Submit</button>
                            <a href="{{ url('system_credentials') }}" class="btn btn-danger">Cancel</a>
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
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Function to toggle fields based on serial number selection
            $('#serial_number').on('change', function() {
                var selectedValue = $(this).val().replace(/[^a-zA-Z]/g, '');

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

                } else {
                    $('#pin_number_field').hide();
                    $('#os_field').show();
                    $('#user_name_field').show();
                    $('#user_password_field').show();
                    $('#root_password_field').show();
                    $('#dynamicFieldsContainer').show();
                    $('#root_password').attr('required', '');
                    $('#pin_number').removeAttr('required');

                }
            });


            // Function to toggle fields based on OS selection
            function toggleFields() {

                var osSelect = document.getElementById("selected_os_name");
                var firstNumber = osSelect.options[osSelect.selectedIndex].value;
                var selectedOsId = firstNumber.split('~')[0];

                var rootPasswordField = document.getElementById("root_password_field");
                var rootPasswordInput = document.getElementById("root_password");

                // By default, display all fields and set required attributes
                rootPasswordField.style.display = "block";
                rootPasswordInput.setAttribute("required", "");

                // If OS ID is 1 or 3, hide unnecessary fields and remove required attribute
                if (selectedOsId == 1 || selectedOsId == 3 || selectedOsId == 4 || selectedOsId == 5) {
                    rootPasswordField.style.display = "none";
                    rootPasswordInput.removeAttribute("required");
                }
            }

            // Ensure the function is called when the selection changes
            document.getElementById("selected_os_name").addEventListener("change", toggleFields);

            // Initial call to set the correct visibility on page load
            toggleFields();

            // Hide all fields by default on page load
            $('#pin_number_field').hide();
            $('#os_field').hide();
            $('#user_name_field').hide();
            $('#user_password_field').hide();
            $('#root_password_field').hide();
            $('#selected_os_name').attr('required', '');
            $('#root_password').removeAttr('required');


        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const assetSelect = document.getElementById('selected_os_name');
            const dynamicFieldsContainer = document.getElementById('dynamicFieldsContainer');
            const addFieldBtn = document.getElementById('addFieldBtn');
            const assetForm = document.getElementById('assetForm');


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
                    this.value = this.value.replace(/[^a-zA-Z0-9!@#$%^&*()-=_+[\]{}|;:'",.<>?]/g, ''); // Allow alphanumeric values and specific special characters, but disallow spaces
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

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const serialNumberInput = document.getElementById('serial_number');

            serialNumberInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase(); // Convert input to uppercase
            });
        });
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script>
        document.querySelectorAll('.toggle-password').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                const input = document.getElementById(this.getAttribute('data-toggle'));
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');

                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        });
    </script>

    <script>
        // Utility function to clear all options from a select element
        function clearOptions(selectElement) {
            while (selectElement.options.length > 0) {
                selectElement.remove(0);
            }
        }

        // Utility function to clear all optgroups from a select element
        function clearOptgroups(selectElement) {
            let optgroups = selectElement.getElementsByTagName('optgroup');
            while (optgroups.length > 0) {
                selectElement.removeChild(optgroups[0]);
            }
        }

        // Main function to check the serial number and update the select options
        function checkSerialNumber() {
            var serialNumber = document.getElementById('serial_number');
            var osField = document.getElementById('os_field');
            var osSelect = document.getElementById('selected_os_name');

            var selectedValue = serialNumber.value.replace(/[^a-zA-Z]/g, '');

            // Clear existing options and optgroups
            clearOptions(osSelect);
            clearOptgroups(osSelect);

            // Add "Any OS" option
            var anyOption = document.createElement('option');
            anyOption.text = 'Select System OS';
            anyOption.disabled = true;
            anyOption.selected = true;
            osSelect.appendChild(anyOption);

            if (selectedValue === 'YJMB') {
                osField.style.display = 'block';

                // Add optgroup and options dynamically for specific os_master_id values
                @foreach($os_master as $os)
                var optgroup = document.createElement('optgroup');
                optgroup.label = "{{ $os['os_name'] }}";
                var hasOptions = false;

                @foreach($version_master as $vs)
                @if(in_array($vs['os_master_id'], [4, 5]) && $vs['os_master_id'] == $os['os_master_id'])
                var option = document.createElement('option');
                option.value = "{{ $vs['os_master_id'] }}~{{ $vs['version_master_id'] }}";
                option.text = "{{ $vs['os_master_id'] != 2 && $vs['os_master_id'] != 4 ? $os['os_name'] . ' - ' . $vs['version_name'] : $vs['version_type'] . ' - ' . $vs['version_name'] }}";
                optgroup.appendChild(option);
                hasOptions = true;
                @endif
                @endforeach

                if (hasOptions) {
                    osSelect.appendChild(optgroup);
                }
                @endforeach

            } else {
                osField.style.display = 'block';

                // Add optgroup and options dynamically for specific os_master_id values
                @foreach($os_master as $os)
                var optgroup = document.createElement('optgroup');
                optgroup.label = "{{ $os['os_name'] }}";
                var hasOptions = false;

                @foreach($version_master as $vs)
                @if(in_array($vs['os_master_id'], [1, 2, 3]) && $vs['os_master_id'] == $os['os_master_id'])
                var option = document.createElement('option');
                option.value = "{{ $vs['os_master_id'] }}~{{ $vs['version_master_id'] }}";
                option.text = "{{ $vs['os_master_id'] != 2 && $vs['os_master_id'] != 4 ? $os['os_name'] . ' - ' . $vs['version_name'] : $vs['version_type'] . ' - ' . $vs['version_name'] }}";
                optgroup.appendChild(option);
                hasOptions = true;
                @endif
                @endforeach

                if (hasOptions) {
                    osSelect.appendChild(optgroup);
                }
                @endforeach
            }
        }
    </script>


</x-app-layout>
<!DOCTYPE html>
<html>
<head>
    <title>Enquiry Form</title>
    <link href="https://www.phntechnology.com/assets/img/logo-nobg.png" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body{
            background-color: #31547c;
        }
        .form_bg{
            background-color: #fff;
            height: 100%;
            position: relative;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
    </style>
</head>
<body>
    <div class="container">
       
        <div class="row justify-content-center"> 
        <h1 class="mt-2 text-center text-white mb-3">Enquiry Form</h1>
            <div class="col-lg-7 form_bg"> 
                    @if (session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                    @endif

                <form action="{{ route('enquiry.submit') }}" method="POST" class="mt-4" onsubmit="return validateForm()">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required pattern="[A-Za-z\s]+" title="Name should only contain alphabets" />
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required />
                    </div>

                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile Number:</label>
                        <input type="tel" name="mobile"  pattern="[0-9]{10}" id="mobile" class="form-control" value="{{ old('mobile') }}" required pattern="[0-9]{10}" title="Mobile number should be 10 digits" maxlength="10"/>
                    </div>
                   

                    <div class="mb-3">
                        <label for="state" class="form-label">State:</label>
                        <select name="state" id="state" class="form-select" value="{{ old('state') }}" required>
                            <option value="">Select State</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="district" class="form-label">District:</label>
                        <select name="district" id="district" value="{{ old('district') }}" class="form-select" required>
                            <option value="">Select District</option>
                        </select>
                    </div>

                    <!-- Add Captcha field here -->
                    <div class="form-group mt-4 mb-4">
                        <div class="captcha">
                            <span>{!! captcha_img('math') !!}</span>
                            <button type="button" class="btn btn-danger" class="reload" id="reload"> 
                            ↻
                            </button>
                        </div>
                        </div>
                        <div class="form-group mb-4">
                            <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha" required>
                        </div>

                    <div class="text-center mb-3">
                    <a href="{{ route('enquiry_form') }}" class="btn btn-secondary">Cancel</a>
             
                        <button type="submit" class="btn btn-primary">Submit</button>   
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
     
        $(document).ready(function() {
            // Fetch JSON data
            $.getJSON('/json/states-and-districts.json', function(data) {
                var states = data.states;

                // Populate the State dropdown
                var stateDropdown = $('#state');
                $.each(states, function(index, state) {
                    stateDropdown.append('<option value="' + state.state + '">' + state.state + '</option>');
                });

                // Handle State dropdown change event
                stateDropdown.change(function() {
                    var selectedState = $(this).val();
                    var districts = states.find(function(state) {
                        return state.state === selectedState;
                    }).districts;

                    // Populate the District dropdown based on the selected state
                    var districtDropdown = $('#district');
                    districtDropdown.empty();
                    $.each(districts, function(index, district) {
                        districtDropdown.append('<option value="' + district + '">' + district + '</option>');
                    });
                });
            });
        });
    </script>
       <script>
        function validateForm() {
            var nameInput = document.getElementById('name');
            var emailInput = document.getElementById('email');
            var mobileInput = document.getElementById('mobile');
            var stateSelect = document.getElementById('state');
            var districtSelect = document.getElementById('district');

            // Validate Name (Accepts only alphabets)
            var namePattern = /^[A-Za-z\s]+$/;
            if (!namePattern.test(nameInput.value)) {
                alert('Please enter a valid name (only alphabets are allowed).');
                nameInput.focus();
                return false;
            }

            // Validate Email (HTML5 form validation)
            if (!emailInput.checkValidity()) {
                alert('Please enter a valid email address.');
                emailInput.focus();
                return false;
            }

            // Validate Mobile Number (HTML5 pattern)
            if (!mobileInput.checkValidity()) {
                alert('Please enter a valid 10-digit mobile number.');
                mobileInput.focus();
                return false;
            }

            // Validate State (Dropdown validation)
            if (stateSelect.value === '') {
                alert('Please select a state.');
                stateSelect.focus();
                return false;
            }

            // Validate District (Dropdown validation)
            if (districtSelect.value === '') {
                alert('Please select a district.');
                districtSelect.focus();
                return false;
            }

            // Add validation for captcha field here

            // Form is valid, allow form submission
            return true;
        }
    </script>
    <script type="text/javascript">
$('#reload').click(function () {
$.ajax({
type: 'GET',
url: 'reload-captcha',
success: function (data) {
$(".captcha span").html(data.captcha);
}
});
});
</script>
</body>
</html>

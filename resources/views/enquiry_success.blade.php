<!DOCTYPE html>
<html>
<head>
    <title>Enquiry Form - Success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body{
            background-color: #7C53E3;
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
    <div class="container text-white">
        <h1 class="mt-5 ">Enquiry Form Submitted Successfully</h1>

        <p>We have received your details and will get back to you soon.</p>

        <!-- Add any additional content or instructions here -->

        <a href="{{ route('enquiry_form') }}" class="btn btn-primary">Submit Another Enquiry</a>
    </div>
</body>
</html>

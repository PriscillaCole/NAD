<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information</title>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 20px auto;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            flex-grow: 1;
        }
        .basic-info {
            flex: 0 1 30%;
            margin-right: 10px;
        }
        .additional-info {
            margin-left: 10px;
        }
        h2 {
            text-align: center;
        }
        img {
            display: block;
            margin: 0 auto;
            border-radius: 50%;
            width: 200px;
            height: 200px;
            object-fit: cover;
            object-position: center;
            margin-bottom: 20px;
        }
        .details {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            color: black;
        }
        .back-arrow {
            margin-bottom: 5px;
            cursor: pointer;
            font-size: 24px;
            color: black; /* Default color */
        }
        .back-arrow:hover {
            color: orange; /* Color on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="card basic-info">
        <div class="back-arrow" onclick="window.history.back()">&#8592; </div>
            <h2>Basic Information</h2>
           
            <?php
            $profilePicture = $staff->profile_picture ? asset('storage/' . $staff->profile_picture) : asset('storage/person.png');
            ?>
            <img src="{{ $profilePicture }}" alt="profile">
            <div class="details">
                <span class="label">Staff ID:</span> {{$staff->staff_number}}
            </div>
            <div class="details">
                <span class="label">Name:</span> {{$staff->name}}
            </div>
            <div class="details">
                <span class="label">Position:</span> {{$staff->title}}
            </div>
            <div class="details">
                <span class="label">Duty station:</span> {{$staff->duty_station}}
            </div>
        </div>
        <div class="card additional-info">
            <h2>Additional Details</h2>
            <div class="details">
                <span class="label">Date of birth:</span> {{$staff->date_of_birth}}
            </div>
            <div class="details">
                <span class="label">Email:</span> {{$staff->email}}
            </div>
            <div class="details">
                <span class="label">Phone:</span> {{$staff->telephone}}
            </div>
            <div class="details">
                <span class="label">Contract start date:</span> {{$staff->contract_start}}
            </div>
            <div class="details">
                <span class="label">Contract end date:</span> {{$staff->contract_end}}
            </div>
            <div class="details">
                <span class="label">Marital Status:</span> {{$staff->marital_status}}
            </div>
            <div class="details">
                <span class="label">Next of kin:</span> {{$staff->next_of_kin}}
            </div>
            <div class="details">
                <span class="label">Next of kin relationship:</span> {{$staff->relationship}}
            </div>
            <div class="details">
                <span class="label">Next of kin contact:</span> {{$staff->contact_of_kin}}
            </div>
            <div class="details">
                <span class="label">Home district:</span> {{$staff->home_district}}
            </div>
            <div class="details">
                <span class="label">NSSF number:</span> {{$staff->nssf}}
            </div>
            <div class="details">
                <span class="label">TIN number:</span> {{$staff->tin}}
            </div>
            <div class="details">
                <span class="label">Bank name:</span> {{$staff->bank}}
            </div>
            <div class="details">
                <span class="label">Bank account number:</span> {{$staff->bank_account}}
            </div>
        </div>
    </div>
</body>
</html>

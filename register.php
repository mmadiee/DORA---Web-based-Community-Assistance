<?php
session_start();
require_once "acc-verify.php";

if (isset($_POST['submit'])) {
    $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);
    if ($usertype === "Donor-Volunteer") {
        $acctype = 1;
    } elseif ($usertype === "Assistance") {
        $acctype = 2;
    } elseif ($usertype === "SocialWorker") {
        $acctype = 3;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register as Donor and Volunteer</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/icon/favicon-16x16.png">
    <link rel="manifest" href="img/icon/site.webmanifest">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    .modal {
        position: fixed;
        background-color: white;
        max-width: 900px;
        width: 60%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .modal-content {
    text-align: center;
    max-width: 100%; 
    padding: 10px;
    height: 30%;
    position: relative;
    overflow-y: auto;
    background-color: white;
    margin-left: 5px;
    }

    .modal-inner {
        max-height: 100%; 
        overflow-y: auto; 
        padding: 20px;
    }
    #agreeButton {
    background-color: blue;
    color: white;
    width: 20%;
    border-radius: 5px;
    right: 50px; 
    text-align: center;
    padding: 10px;
    cursor: pointer;
    margin-left: 80%;
    font-size: 18px;
    }

    #agreeButton:hover {
        background-color: #034078;
    }
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 0;
    }

    .modal-content h2{
        padding-top: 10px;
    }
    .modal-inner p{
        text-align: justify;
    }
    .form-container form{
       text-align: left;
    }
    
    </style>

</head>
<body >

<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      
      <h3 style="text-align: center">REGISTRATION FORM</h3>
      <?php
      if(isset($errors)){
         foreach($errors as $errors){
            echo '<div class="message">'.$errors.'</div>';
         }
      }

      ?>

      <!--User Type-->
      <div class="row">
        <label for="usertype" ><b>User Type:</b></label> 
                    <div class="col-75">
                        <select type="select" id="usertype" name="usertype" class="box" required onchange="togglePaypalEmailField()">
                        <option value="" disabled selected hidden>Select User Type</option>
                        <option value="Donor-Volunteer">Donor-Volunteer</option>
                        <option value="Assistance">Assistance Applicant</option>
                        <option value="SocialWorker">SocialWorker</option>
                        </select>
                        <input type="hidden" name="acctype" value="<?php echo $acctype; ?>">
                    </div>
        </div>
        <!--PAYPAL EMAIL -->
        <label for="paypal_account" id="paypalaccountLabel" style="display: none;"><b>PayPal Email:</b></label>
        <input type="text" id="paypal_account" name="paypal_account" placeholder="Enter PayPal Email" class="box" 
         style="display: none;">   
      
    <label for="lname" ><b>Last Name:</b></label>
    <label for="fname" style="margin-left:160px"><b>First Name:</b></label>
    <label for="mname" style="margin-left:160px"><b>Middle Name:</b></label><br>
        <!--Last Name-->
        <input type="text" style="width: 250px" name="lname" placeholder="Enter Last Name" class="box" 
        required value="<?php echo isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : ''; ?>">
      <!--First Name-->
        <input type="text" style="width: 250px" name="fname" placeholder="Enter First Name" class="box" 
        required value="<?php echo isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : ''; ?>">
      <!--Middle Name-->
        <input type="text" style="width: 250px" name="mname" placeholder="Enter Middle Name" class="box" 
        required value="<?php echo isset($_POST['mname']) ? htmlspecialchars($_POST['mname']) : ''; ?>">

    <label for="email" ><b>Email:</b></label>  
        <input type="email" name="email" placeholder="Enter Email" class="box" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
      
    <label for="birthday"><b>Birthday:</b></label>
    <input type="date" name="birthday" class="box" required 
       max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" 
       value="<?php echo isset($_POST['birthday']) ? htmlspecialchars($_POST['birthday']) : ''; ?>">

    
    <div class="row">
      <label for="gender" ><b>Gender:</b></label> 
                <div class="col-75">
                    <select type="select" id="gender" name="gender"  class="box" required>
                    <option value="" disabled selected hidden>Select Gender</option>
                    <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                    </select>
                </div>
    </div>
    
             <!--Contact-->
            <label for="contact"><b>Contact Number:</b></label><br>
            <select name="country_code" class="box" style="width: 250px; overflow-y: scroll;">
                <option value="" disabled selected hidden>Select Country Code</option>
                <option value="+93">+93 (Afghanistan)</option>
                <option value="+355">+355 (Albania)</option>
                <option value="+994">+994 (Azerbaijan)</option>
                <option value="+359">+359 (Bulgaria)</option>
                <option value="+86">+86 (China)</option>
                <option value="+506">+506 (Costa Rica)</option>
                <option value="+420">+420 (Czech Republic)</option>
                <option value="+20">+20 (Egypt)</option>
                <option value="+372">+372 (Estonia)</option>
                <option value="+33">+33 (France)</option>
                <option value="+995">+995 (Georgia)</option>
                <option value="+49">+49 (Germany)</option>
                <option value="+30">+30 (Greece)</option>
                <option value="+852">+852 (Hong Kong)</option>
                <option value="+354">+354 (Iceland)</option>
                <option value="+91">+91 (India)</option>
                <option value="+98">+98 (Iran)</option>
                <option value="+353">+353 (Ireland)</option>
                <option value="+972">+972 (Israel)</option>
                <option value="+81">+81 (Japan)</option>
                <option value="+254">+254 (Kenya)</option>
                <option value="+212">+212 (Morocco)</option>
                <option value="+95">+95 (Myanmar)</option>
                <option value="+977">+977 (Nepal)</option>
                <option value="+92">+92 (Pakistan)</option>
                <option value="+63">+63 (Philippines)</option>
                <option value="+351">+351 (Portugal)</option>
                <option value="+974">+974 (Qatar)</option>
                <option value="+7">+7 (Russia)</option>
                <option value="+966">+966 (Saudi Arabia)</option>
                <option value="+27">+27 (South Africa)</option>
                <option value="+94">+94 (Sri Lanka)</option>
                <option value="+886">+886 (Taiwan)</option>
                <option value="+992">+992 (Tajikistan)</option>
                <option value="+256">+256 (Uganda)</option>
                <option value="+971">+971 (United Arab Emirates)</option>
                <option value="+44">+44 (United Kingdom)</option>
                <option value="+1">+1 (United States)</option>
                <option value="+998">+998 (Uzbekistan)</option>

            </select>
            <input type="text" id="contact" name="contact" placeholder="Enter Contact Number" class="box" style="width: 500px;"
                required pattern="[0-9]{10}" title="Mobile number must be 10 digits" 
                value="<?php echo isset($_POST['contact']) ? htmlspecialchars($_POST['contact']) : ''; ?>"><br>
            
            <!-- Hidden input field to store combined country code and contact number -->
            <input type="hidden" name="full_contact" id="full_contact" value="">

        
        <!-- Address -->    
        <label for="city"><b>City/Province:</b></label>
        <input type="text" id="city" name="city" placeholder="Enter City/Province" class="box"
        required value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>">

        <label for="municipality" id="municipalityLabel" ><b>Municipality:</b></label>
        <input type="text" id="municipality" name="municipality" placeholder="Enter Municipality" class="box"
        required value="<?php echo isset($_POST['municipality']) ? htmlspecialchars($_POST['municipality']) : ''; ?>">

        <label for="brgy" id="brgyLabel" ><b>Barangay:</b></label>
        <input type="text" id="brgy" name="brgy" placeholder="Enter Barangay" class="box"
        required value="<?php echo isset($_POST['brgy']) ? htmlspecialchars($_POST['brgy']) : ''; ?>">

        <label for="street" id="streetLabel" ><b>Street:</b></label>
        <input type="text" id="street" name="street" placeholder="Enter Street"class="box"
        required value="<?php echo isset($_POST['street']) ? htmlspecialchars($_POST['street']) : ''; ?>">


        <label for="occupation" ><b>Occupation:</b></label> 
        <input type="occupation" name="occupation" placeholder="Enter Occupation" class="box" required value="<?php echo isset($_POST['occupation']) ? htmlspecialchars($_POST['occupation']) : ''; ?>">
    
      
      <label for="name" ><b>Password:</b></label> 
        <input type="password" name="password" placeholder="Enter Password" class="box" required value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['cpassword']) : ''; ?>">
      <label for="name" ><b>Confirm Password:</b></label> 
        <input type="password" name="cpassword" placeholder="Confirm Password" class="box" required value="<?php echo isset($_POST['cpassword']) ? htmlspecialchars($_POST['cpassword']) : ''; ?>">
      <label for="image" style="text-align: center; display: block;"><b>Upload Profile Picture</label></b>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png" required>
    
        <!--Valid ID-->
        <label for="image" style="text-align: center; display: block;"><b>Upload Valid ID</label></b>
                <select name="idtype" class="box" style="width: 250px;">
                    <option value="" disabled selected hidden>Select Type of ID</option>
                    <option value="Passport">Passport</option>
                    <option value="Driver's License">Driver's License</option>
                    <option value="PhilHealth ID">PhilHealth ID</option>
                    <option value="PRC ID">PRC ID</option>
                    <option value="National ID">National ID</option>
                    <option value="NBI Clearance">NBI Clearance</option>
                    <option value="TIN ID">TIN ID</option>
                    <option value="Postal ID">Postal ID</option>
                </select>
        <input type="file" name="valid_image" class="box" style="width: 500px;" accept="image/jpg, image/jpeg, image/png">
        
      <input type="checkbox" name="consent" id="consent" style="margin-top: 16px; font-size: 12px;" checked>
          <label for="consent" style="font-style: italic; margin-top: 18px; font-size: 14px; text-align: center;">
            I have read and understood the <b>Privacy Statement</b>,
            and I give my consent to use my information for the purpose outlined in DORA's Privacy Policy.<span style="color: red">*</span>
          </label>
      
      <input type="submit" name="submit" value="Register Now" class="btn" onclick="return validateForm()">


      <p class="box" style="text-align: center">Already have an account? <a href="login.php">Login Now</a></p>
   </form>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   function validateForm() {
    const lname = document.getElementsByName('lname')[0].value;
    const fname = document.getElementsByName('fname')[0].value;
    const mname = document.getElementsByName('mname')[0].value;
    const email = document.getElementsByName('email')[0].value;
    const birthday = document.getElementsByName('birthday')[0].value;
    const gender = document.getElementById('gender').value;
    const contact = document.getElementById('contact').value;
    const address = document.getElementsByName('city')[0].value;
    const address = document.getElementsByName('municipality')[0].value;
    const address = document.getElementsByName('brgy')[0].value;
    const address = document.getElementsByName('street')[0].value;
    const occupation = document.getElementsByName('occupation')[0].value;
    const password = document.getElementsByName('password')[0].value;
    const cpassword = document.getElementsByName('cpassword')[0].value;
    const image = document.getElementsByName('image')[0].value;

    // Perform field validation here (e.g., check if fields are empty or meet certain criteria)
    if (lname === '' || fname === '' || mname === '' || email === '' || birthday === '' || gender === '' || contact === '' || 
        city === '' || municipality === '' || brgy === '' || street === '' || occupation === '' || password === '' || cpassword === '' || image === '') {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'All fields Except Valid ID are required!',
        });
        return false;  
    }

    return confirmalert();
}

function confirmalert() {
    var userSelection = confirm("Are you sure you want to submit?");
    return userSelection;  
}
</script>



<!--Contact-->
<script>
const countryCodeInput = document.getElementById('country_code');
const contactInput = document.getElementById('contact');
const fullContactInput = document.getElementById('full_contact');

countryCodeInput.addEventListener('input', updateFullContact);
contactInput.addEventListener('input', updateFullContact);

function updateFullContact() {
    // Get the selected country code and contact number
    const countryCode = countryCodeInput.value;
    const contactNumber = contactInput.value;

    const fullContact = countryCode + contactNumber;

    fullContactInput.value = fullContact;
}
</script>

<script>
function togglePaypalEmailField() {
    const usertypeSelect = document.getElementById('usertype');
    const paypalaccountLabel = document.getElementById('paypalaccountLabel');
    const paypalaccountInput = document.getElementById('paypal_account');

    if (usertypeSelect.value === 'SocialWorker') {
        // If the user selects "Social Worker," show the PayPal email field.
        paypalaccountLabel.style.display = 'block';
        paypalaccountInput.style.display = 'block';
    } else {
        // If the user selects any other user type, hide the PayPal email field.
        paypalaccountLabel.style.display = 'none';
        paypalaccountInput.style.display = 'none';
    }
}
</script>

</body>
</html>

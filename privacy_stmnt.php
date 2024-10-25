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
    
    </style>

</head>
<body onload="showModalOnConsentAndCheckCheckbox()">


<!--OVERLAY-->
<div class="overlay" id="overlay"></div>

<!-- MODAL -->
<div id="modal" class="modal" >
    <div class="modal-content">
        <div class="modal-inner" style="max-height: 460px; overflow-y: auto;">
        <h2>Privacy Statement</h2><br>
            <p>At DORA, we are committed to protecting your privacy and ensuring the security of your personal 
                information. This Privacy Policy is designed to help you understand how we collect, use, and 
                protect your personal data in accordance with the Data Privacy Act and other relevant regulations. 
                By using our services, you agree to the practices outlined in this policy.<br><br>
            
            <b>1. Information Collected</b><br>

            We may collect and store the following information when you use our website:<br><br>
            
            Personal Information:<br> This includes your name, email address, contact information, and other personally identifiable 
            information you provide when volunteering, donating, or applying for assistance programs.<br><br>
            
            Volunteering Information:<br> Information related to your volunteering activities, including the type of assistance you 
            provide and your availability.<br><br>
            
            Donation Information:<br> Details about your donation transactions, such as the amount, date, and method of donation.<br><br>
            
            Assistance Program Applications:<br> Information submitted when applying for assistance programs, including financial details, 
            proof of need, and personal history.<br><br>
            
            
           <b>2. Use of Information</b><br>
            
            We use the information collected for the following purposes:<br><br>
            
            Transparency Reports:<br> Your information may be used in transparency reports to demonstrate the impact of donation drives, ensuring 
            donors have visibility into how their contributions are making a difference.<br><br>
            
            Turnout Reports:<br> Information regarding volunteers and assistance program applicants is used to create turnout reports that help us 
            optimize our programs and better allocate resources to those in need.<br><br>
            
            Communications:<br> We may contact you to provide updates on your volunteer activities, donation transactions, and information about assistance 
            programs. You can opt out of these communications at any time.<br><br>
            
            Platform Improvement:<br> Data analysis is used to enhance our website and improve the user experience, making it easier for volunteers, 
            donors, and program applicants to engage with our platform.<br><br>
            
            
            <b>3. Disclosure of Information</b><br>
            We do not sell, rent, or trade your personal information to third parties. We may share your information just for the transparency 
            and turnout reports with the trusted service providers who assist us in operating our website and delivering services.<br><br>
             
            
            <b>4. Your Rights</b><br>
            You have the right to:
            Request to correct any inaccuracies in your personal information.<br><br>
            
            <b>5. Consent</b><br>
            By using DORA, you consent to the collection and use of your information as outlined in this privacy statement.<br><br>
            
            <b>6. Changes to this Privacy Statement</b><br>
            
            We may update this privacy statement to reflect changes in our practices or for legal and regulatory reasons. 
            Updates will be posted on our website with the effective date.<br><br>
            
            <b>Contact Us</b><br>
            
            If you have any questions or concerns about this privacy statement or the way your information is handled, please contact 
            us at <a href="projectsbydora@gmail.com">projectsbydora@gmail.com.</a><br><br>
            
            Thank you for your trust you give to DORA website. Your support and participation are invaluable in making our platform a force for good in the community.<br></p>
     
            <button id="agreeButton" onclick="redirectToRegisterPage()">I Agree!</button>
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
function showModalOnConsentAndCheckCheckbox() {
    const modal = document.getElementById('modal');
    const overlay = document.getElementById('overlay');
    const consentCheckbox = document.getElementById('consent');
    const registrationForm = document.getElementById('registration-form');

    // Show the modal and overlay
    modal.style.display = 'block';
    overlay.style.display = 'block';

    registrationForm.style.display = 'none';
}
</script>

<script>
   document.getElementById('agreeButton').addEventListener('click', function () {
    const modal = document.getElementById('modal');
    const overlay = document.getElementById('overlay');
    const consentCheckbox = document.getElementById('consent'); 

    // Hide the modal and overlay
    modal.style.display = 'none';
    overlay.style.display = 'none';

    consentCheckbox.checked = true;
});
</script>

<script>
function redirectToRegisterPage() {
    window.location.href = "register.php";
}
</script>

</body>
</html>
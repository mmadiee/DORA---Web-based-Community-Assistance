<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to DORA</title>

    <link href="css/about.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    
    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/icon/favicon-16x16.png">
    <link rel="manifest" href="img/icon/site.webmanifest">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    

    <style>
        .contact-section {
            text-align: right;
            translate: (120%,100%);
        }
        .sticky-footer{
            position: sticky;
            top: 100%;
            padding-top: 15px;
            margin-bottom: -20px;
        }
        .contact-section::before {
            content: '';
            width: 1px;
            height: 88%;
            background-color: #ccc; /* Choose your desired color */
            position: absolute;
            top: 0;
            border: 1.5px solid white;
            margin-left: -160px; /* Adjust the position as needed */
            margin-top: 22px;
        }
        .contact-btn{
            border: 1px solid white;
            font-size: 15px;
            background-color: transparent;
            width: 20%;
            height: 7%;
            padding-left: 15px;
            padding-right: 15px;
            padding-bottom: 6px;
            padding-top: 6px;
            border-radius: 15px;
            color: white;
            margin-right: 15px;
        }
        .contact-btn:hover{
            background-color:white;
            color: #1282A2;
            text-decoration: none; 
        }
        
        
    </style>
</head>
<body>
    <!--LOADER-->
    <script src="js/loader.js"></script>
    <div class="loader"></div>

        <!--NAV BAR-->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a href="index.php" class="navbar-brand"><img src="dora_logo.png" width="120" height="30" ></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="donation.php">Donations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="volunteer.php">Volunteers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="assistance.php">Assistance</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    <!--Main Content-->
    <div class="header">
        <h1>About us</h1>
    </div>
    <section>
        <div class="container logo-image">
            <center><img class="responsive w-25" src="img/about/dora_logo.png"></center>
        </div>
        <div class="container w-75">
            <div class="description">
                <p>
                    
                    The name DORA stands for "<b>Development of Rural Areas</b>". 
                    DORA is a website that provides information beneficial to the community, 
                    specifically those from rural areas who are considered as disadvantaged and underprivileged. 
                    With DORA, people who need help or want to help has a way to access ongoing <b>donation drives</b>, 
                    <b>volunteering opportunities</b>, and <b>assistance</b>.
                </p>
                
                <p>
                    <br>
                    <b>Our Mission Statement</b><br>
                     DORA provides a thriving online community assistance platform that connects volunteers, those in 
                    need of assistance, and donors, fostering a culture of compassion, empowerment, and support. We are
                    committed to building an online tool where individuals and organizations can come together to make 
                    a positive impact on the community, one act of kindness at a time.
                </p>
                
                <p>
                    <b>Our Vision Statement</b><br>
                    We aspire to build a community where every person can access and provide assistance, fostering 
                    kindness and solidarity. We aim to empower and inspire people to transform their communities by 
                    working together to address pressing social and humanitarian challenges.
                </p>
            </div>
        </div>
    </section>

    <section>


    <!-- USER ROLES -->
    <br><br>
    
    <center><h2 style="margin-bottom: 80px;">Understanding User Roles</h2></center>

    <!-- DONOR/VOLUNTEER -->
    <div class="form-container">

    <div class="form-container">
    <button id="dvbtn" class="icon-button" type="button">
        <i class="fas fa-hand-holding-medical"></i><br><br> <span style="white-space: nowrap;">Donor/Volunteer
    </button>

    
    <form action="" method="post" enctype="multipart/form-data">
        <?php
        if(isset($errors)){
            foreach($errors as $errors){
                echo '<div class="message">'.$errors.'</div>';
            }
        }
        ?>
  
    <!-- V/D MODAL -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-inner">
                <h2>Donor and Volunteer Role</h2><br>
                <p>Donors play a vital role in supporting charitable initiatives and organizations.
                Volunteers are essential in driving hands-on support and impact in various projects 
                and initiatives. Both Donors' and Volunteers' primary roles and actions in a system
                often involve:<br><br>
                
                <b>Donors:</b> <br><br>
                
                View and Select Donation Drives:<br>
                Donors have the opportunity to explore various donation drives and projects, each 
                dedicated to a specific cause or need. They can browse these projects to find the ones 
                that resonate with their values and interests.<br><br>
                
                Make Financial Contributions: <br>
                Donors can choose a specific donation drive and make financial contributions to support the cause. 
                Depending on the system, they can use PayPal as a mode of payment for donation transactions.<br><br>
                
                Review and Modify Profile Information: <br>
                It's crucial for Donors to maintain an up-to-date profile within the system. This allows them to 
                edit or modify their profile personal information.<br><br>
                
                View Donation History: <br>
                Donors can access their donation history within the system. This feature enables them to keep track 
                of their previous contributions, ensuring transparency and accountability.<br><br>
                
                <b>Volunteers:</b> <br><br>
                
                Explore Volunteering Opportunities:  <br>
                Volunteers can browse through a list of volunteering opportunities and projects. These projects 
                cover a wide range of causes, and volunteers can choose the ones that align with their skills, 
                interests, and availability.<br><br>
                
                Select Projects to Volunteer: <br>
                Once a volunteering opportunity is identified, volunteers can express their interest and commitment 
                to a specific project. Depending on the system, they need to go through an application or 
                registration process.<br><br>
                
                Access Project Details: <br>
                 Volunteers can access comprehensive information about the projects they've chosen, including 
                 project goals, schedules, and other requirements. This helps them prepare and participate 
                 effectively.<br><br>
                 
                Maintain and Update Profile: <br>
                 Similar to Donors, it's important for Volunteers to keep their profiles accurate. 
                 The sytem allows the user to edit their profile information.<br><br>
                 
                View Volunteer History:<br>
                 Volunteers can track and access their volunteer history within the system. This feature allows 
                 them to see the impact they've had, the projects they've been involved in, and the skills they've 
                 contributed.<br><br>
                 
                 Receive a Generated E-ID: <br>
                  If their registration as a volunteer is verified, volunteers may receive a generated Electronic ID 
                  (E-ID). This E-ID serves as a unique identifier and is used for tracking, verification, and 
                  communication related to their volunteer work.<br><br>
    
                <p>If you are interested in joining, <a href="register.php">Register now!</a> </p>
                
                <a href="login.php">
                <button id="okButton">Close</button>
                </a>
                
            </div>
        </div>
    </div>

    <!--OVERLAY-->
    <div class="overlay" id="overlay1"></div>

    

    <!-- ASSISTANCE -->
    <div class="form-container1" style="margin-left: 200px;">
    
    <button id="assbtn" class="icon-button1" type="button">
        <i class="fa-solid fa-users"></i><br><br> <span style="white-space: nowrap;"> Assistance Applicant
    </button>

        <form action="" method="post" enctype="multipart/form-data">
        <?php
        if(isset($errors)){
            foreach($errors as $errors){
                echo '<div class="message">'.$errors.'</div>';
            }
        }
    ?>
    

    <!--  ASSISTANCE MODAL -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <div class="modal-inner">
                <h2>Assistance Applicant Role</h2><br>
                <p>Assistance Applicants are individuals seeking support from specific assistance programs. 
                Their role within the system involves several key responsibilities and actions:<br><br>
                
                
                View Ongoing Programs:<br>
                Assistance Applicants can explore the list of ongoing assistance programs within the system. These 
                programs are tailored to address various needs, and applicants can review them to identify 
                those that align with their specific requirements.<br><br>
                
                Select a Specific Project: <br>
                Once an Assistance Applicant identifies a program that matches their 
                needs, they can choose a specific project within that program. This selection process allows 
                them to target the type of assistance they require.<br><br>
                
                Submit Proof and Reason: <br>
                Applicants are required to provide supporting documentation and reasons explaining why they need 
                assistance from the selected project. This step ensures that assistance is directed to those who 
                genuinely require it.<br><br>
                
                Receive Assistance:<br>
                 If their application is approved and verified, Assistance Applicants become eligible to receive 
                 assistance from the program they applied to. The nature of assistance can vary, ranging from 
                 financial aid to services, goods, or other forms of support.<br><br>
                
                
               View and Edit Profile Information:  <br>
                Applicants are encouraged to maintain an accurate and up-to-date profile within the system. This 
                helps in the application process and allows for efficient communication. They can edit their 
                personal information and contact details as needed.<br><br>
                
                View Assistance Application History: <br>
                Applicants have the ability to access a record of their past and current assistance applications. 
                This history provides transparency and allows them to track their interactions with 
                the system.<br><br>
                
                Generate QR Code: <br>
                 Once their assistance application is verified and approved, Assistance Applicants may receive a 
                 generated QR code. This QR code can serve as a unique identifier and may be used for tracking, 
                 verification, and communication related to their application.<br><br>
                
    
                <p>If you are interested in joining, <a href="register_assistance.php">Register now!</a> </p>
                
                <a href="login_assistance.php">
                <button id="okButton">Close</button>
                </a>
                
            </div>
        </div>
    </div>

    <!--OVERLAY-->
    <div class="overlay" id="overlay2"></div>




    

    <!-- SOCIAL WORKER -->
    <div class="form-container2" style="margin-left: 200px;">

    <button id="socbtn" class="icon-button2" type="button">
        <i class="fa-solid fa-chalkboard-user"></i><br><br><span style="white-space: nowrap;"> Social Worker
    </button>

 
        <form action="" method="post" enctype="multipart/form-data">
        <?php
        if(isset($errors)){
            foreach($errors as $errors){
                echo '<div class="message">'.$errors.'</div>';
            }
        }
    ?>
    

    <!--  SOCIAL WORKER MODAL -->
    <div id="modal2" class="modal">
        <div class="modal-content">
            <div class="modal-inner">
            <h2>Social Worker Role</h2><br>
            <p>The Social Worker Role plays a crucial role in managing and overseeing various aspects of the system, 
            ensuring that assistance and support are provided efficiently. Here's a brief overview of their 
            responsibilities and capabilities within the system::<br><br>
            
            <b>Project Management: </b> Social workers have the authority to create and manage volunteer, assistance, and 
            donation projects in the system. This includes defining project details, objectives, and requirements.<br>

            <b>Applicant and Donor Monitoring: </b> They are responsible for monitoring applicants, volunteers, and donors. Social workers 
            can verify and invalidate applications and transactions based on specific criteria and guidelines. This 
            helps ensure the integrity and effectiveness of the assistance provided.<br>

            <b>Data Analytics: </b> Social workers have access to data analytics tools, allowing them to gather insights and 
            generate reports on the activities of donors, volunteers, and assistance applicants. These insights can 
            inform decision-making and improve the allocation of resources.<br>
            
            <b>E-ID and QR Code Generation:</b> They can generate and provide E-IDs and QR codes to users as needed. These 
            codes serve as unique identifiers and proof of application or transaction status.<br>
            
            <b>User Communication: </b> Social workers play a key role in keeping users updated regarding their application or 
            transaction status. They provide notifications and feedback to applicants and donors, ensuring clear and timely 
            communication.<br><br>

            <p>If you are interested in joining, <a href="register_socialworker.php">Register now!</a> </p>
            
            <a href="login_socialworker.php">
            <button id="okButton">Close</button>
            </a>
            
        </div>
    </div>
</div>

    <!--OVERLAY-->
    <div class="overlay" id="overlay3"></div>


    <style>
    
    .icon-button {
    position: absolute;
    transform: translate(-50%, -50%);
    border: none;
    cursor: pointer;
    padding: 18px;
    border-radius: 30%;
    margin-bottom: 345px;
    margin-left: 100px;
    background-color: transparent;
    padding: 10px;
}

    .icon-button1 {
    position: absolute;
    translate: (50%,50%);
    border: none;
    cursor: pointer;
    padding: 18px;
    border-radius: 30%;
    margin-bottom: 345px;
    margin-left: 100px;
    background-color: transparent;
    padding: 10px;
    }
    .icon-button2 {
    position: absolute;
    translate: (50%,50%);
    border: none;
    cursor: pointer;
    padding: 18px;
    border-radius: 30%;
    margin-bottom: 345px;
    margin-left: 100px;
    background-color: transparent;
    padding: 10px;
    }


    .icon-button i {
    font-size: 70px;
    color: #001F54;
    margin-top: 3px;
}

    .icon-button1 i {
    font-size: 70px; 
    color: #001F54;
    margin-top: 3px;
    }

    .icon-button2 i {
    font-size: 70px; 
    color: #001F54;
    margin-top: 3px;
    }

    
    .icon-button:hover i {
    color: #a7a6a6;
}
     .icon-button1:hover i {
        color: #a7a6a6;
    }

    .icon-button2:hover i {
        color: #a7a6a6;
    }
    .form-container {
        position: relative; 
        min-height: 100px; 
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
      
        
    }
    .form-container1 {
        position: relative; 
        min-height: 100px; 
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        
    }

    .form-container2 {
        position: relative; 
        min-height: 100px; 
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        
    }
    .form-container .icon-button {
        top: 10px; 
        right: 400px; 
        
    }

    .form-container1 .icon-button1 {
        top: -80px; 
        right: 160px;
    }

    .form-container2 .icon-button2 {
        top: -100px; 
        right: -100px;
    }

    .modal {
    position: fixed;
    top: 80%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 100%;
    width: 60%;
    height: 100%; /* Set the desired height */
    background-color: transparent;
    overflow: hidden;
}
    

    .modal-content {
    text-align: center;
    max-width: 100%; 
    margin: 0 auto;
    padding: 30px;
    height: 50%;
    position: relative;
    overflow-y: auto;
    }
    
    

    .modal-inner {
        max-height: 100%; 
        overflow-y: auto; 
        padding: 20px;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        font-size: 40px;
        margin-right: 18px;
        padding: 14px;
    }
    #okButton {
    background-color: #001F54;
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

    #okButton:hover {
        background-color: #a7a6a6;
    }
    .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); 
            overflow: hidden;
        }

    
    .modal-content h2{
        padding-top: 10px;
    }
    .modal-inner p{
        text-align: justify;
    }
    @media screen and (max-width: 768px) {
        .info-button {
            top: 5px; /* Adjust button position for smaller screens */
            right: 5px; /* Adjust button position for smaller screens */
        }
        .form-container{
            padding: 10px;
        }
    }

    </style>



</section>

    <section>
        <div class="container feature-title" style="margin-bottom: -60px;">
            <center><h2 style="margin-top: -90px;">Explore our website's features</h2></center>
        </div>

        <div class="container links w-75">
            <div class="row gy-3">
                <div class="col-md-4 text-center">
                    <div class="card h-100">
                        <img src="img/about/donation.jpg" class="card-img-top">
                        <div class="card-body">
                          <a href="donation.php" class="btn w-100">Donations</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card h-100">
                        <img src="img/about/volunteers.jpg" class="card-img-top">
                        <div class="card-body">
                          <a href="volunteer.php" class="btn w-100">Volunteers</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card h-100">
                        <img src="img/about/assistance.jpg" class="card-img-top">
                        <div class="card-body">
                          <a href="assistance.php" class="btn w-100">Assistance</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>

   <style>


.accordion-button {
    font-weight: 600;
}

.accordion-collapse {
    text-align: justify;
}

   </style> 
<!-- FAQ Section -->
<section>
    <div class="container">
        <h2>Frequently Asked Questions</h2><br>

        <div class="accordion" id="faqAccordion">
            <!-- FAQ Item 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                        Can you donate using other payment channels?
                    </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        No, the only payment channel available for donations on DORA is PayPal.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        Can I apply for a specific volunteer project multiple times?
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        No, you are only allowed to submit one application per volunteer project.
                    </div>
                </div>
            </div>


            <!-- FAQ Item 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        Is there a registration fee to join DORA?
                    </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        No, there is no registration fee to join DORA. Registration is free for all users, whether you're a Donor/Volunteer, an Assistance Applicant, or a Social Worker.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        Can I change my user role after registration?
                    </button>
                </h2>
                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        No, your user role is fixed and cannot be changed after registration. When you create an account on DORA, you will select a user role (Donor/Volunteer, Assistance Applicant, or Social Worker), and this role will remain consistent throughout your membership. Please choose your user role carefully during registration.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                        What kind of assistance programs are available on DORA?
                    </button>
                </h2>
                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        DORA offers a variety of assistance programs, including financial aid, educational support, healthcare assistance, and more. You can explore these programs in the Assistance section and apply for the one that aligns with your needs.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq6">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                        How can I contact DORA for inquiries?
                    </button>
                </h2>
                <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="faq6" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        If you have questions or need assistance, you can contact us by visiting the Contact Us page. Fill out the contact form, and our team will respond to your inquiry as soon as possible.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 7 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq7">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                        How can I reset my password if I forget it?
                    </button>
                </h2>
                <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="faq7" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        If you forget your password, you can use the "Forgot Password" feature on the login page. Follow the instructions provided to reset your password via the email associated with your DORA account.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 8 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq8">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                        What happens if I can no longer commit to a volunteer project I signed up for?
                    </button>
                </h2>
                <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="faq8" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        If you can no longer commit to a volunteer project, please inform the project organizer as soon as possible. Open communication is important to ensure a smooth project experience for all parties involved.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 9 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq9">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                        How can I become a verified social worker on DORA?
                    </button>
                </h2>
                <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="faq9" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        To become a verified social worker on DORA, simply sign up as a Social Worker on the DORA website and submit the required documentation, including a valid ID or relevant qualifications. After that, the admin will review your submission, and upon verification, you will be granted verified social worker status.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 10 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq10">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                        How can I verify the authenticity of assistance applicants or projects on DORA?
                    </button>
                </h2>
                <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="faq10" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        DORA has a thorough verification process for assistance applicants and projects. We verify information, review documents, and maintain transparency to ensure the authenticity of all participants and initiatives.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <br><br>
    <!--FOOTER-->
    <footer class="sticky-footer">
        <!-- <h2>Footer Stick to the Bottom</h2> -->
        <div class="container">
            <div class="row">
                <div class="col-4" style="margin-left: 110px;">
                    <ul>
                        <li><a href="about.php">About</a></li>
                        <li><a href="donation.php">Donations</a></li>
                        <li><a href="volunteer.php">Volunteers</a></li>
                        <li><a href="assistance.php">Assistance</a></li>
                    </ul>
                </div>
                <div class="col-6 text-right" style="padding-top: 10px; margin-left: 70px;">
                    <div class="contact-section" >
                        <p class="" style="letter-spacing: 2px; color: white; font-size: 15px"><b>Have Questions<br> or Concerns?</b></p>
                        <a href="contact.php" class="contact-btn">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
        <p style="text-align: center"> © Copyright DORA 2023.</p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>



    <script>
    // Donor/Volunteer Modal
    const dvInfoButton = document.querySelector('#dvbtn');
    const dvModal = document.querySelector('#modal');
    const dvOverlay = document.querySelector('#overlay1');
    const dvCloseModal = document.querySelector('#okButton');

    dvInfoButton.addEventListener('click', () => {
        dvModal.style.display = 'block';
        dvOverlay.style.display = 'block';
        document.body.style.overflow = 'hidden'; 
    });

    dvCloseModal.addEventListener('click', () => {
        dvModal.style.display = 'none';
        dvOverlay.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    window.addEventListener('click', (event) => {
        if (event.target === dvModal) {
            dvModal.style.display = 'none';
            dvOverlay.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    // Assistance Modal
    const assInfoButton = document.querySelector('#assbtn');
    const assModal = document.querySelector('#modal1');
    const assOverlay = document.querySelector('#overlay2');
    const assCloseModal = document.querySelector('#okButton');

    assInfoButton.addEventListener('click', () => {
        assModal.style.display = 'block';
        assOverlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    });

    assCloseModal.addEventListener('click', () => {
        assModal.style.display = 'none';
        assOverlay.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    window.addEventListener('click', (event) => {
        if (event.target === assModal) {
            assModal.style.display = 'none';
            assOverlay.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

      // Social Worker Modal
      const socInfoButton = document.querySelector('#socbtn');
    const socModal = document.querySelector('#modal2');
    const socOverlay = document.querySelector('#overlay3');
    const socCloseModal = document.querySelector('#okButton');

    socInfoButton.addEventListener('click', () => {
        socModal.style.display = 'block';
        socOverlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    });

    socCloseModal.addEventListener('click', () => {
        socModal.style.display = 'none';
        socOverlay.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    window.addEventListener('click', (event) => {
        if (event.target === socModal) {
            socModal.style.display = 'none';
            socOverlay.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });




</script>



</body>
</html>
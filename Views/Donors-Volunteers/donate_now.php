<?php include 'includes/config.php';?>
<?php 

session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:/login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:/index.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Now</title>

    <link rel="stylesheet" href="css/donation.css">
    <link rel="stylesheet" href="css/dn-now.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $paypalClientId; ?>&currency=PHP&commit=true"></script>

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
              <?php echo'
                  <ul class="navbar-nav ms-auto">
                      <li class="nav-item">
                          <a class="nav-link" href="about.php">About</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link active" href="donation.php">Donations</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="volunteer.php">Volunteers</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="dv_userdashboard.php">Profile</a>
                      </li>
                      <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                      </li>
                  </ul>
                '?>
            </div>
        </div>
    </nav>

  <!-- TITLE BARS -->
    <div class="header">
      <h1>Donate Now</h1>
    </div>

    <!-- Content-->
      <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_don_proj where don_project_id  = '$id'";
        $result = mysqli_query($conn, $sql);

         //COMPUTATION
        $sql3 = "SELECT SUM(amount) FROM tbl_transaction WHERE don_project_id = $id AND stat = 'verified'";
        $result1 = mysqli_query($conn, $sql3); 
        $row1 = mysqli_fetch_assoc($result1);
        $totaldonation = $row1['SUM(amount)']; 

        while ($row = mysqli_fetch_array($result)){
          //PROGRESS BAR
            $percentage = ($totaldonation / $row['goal']) * 100;
            $remaining = $row['goal'] - $totaldonation;

            if($remaining <= 0){
              $remaining = 0;
            }
      ?>
      
      <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['donation_amount'])) {
        $donation = $_POST['donation_amount'];
            } elseif (isset($_POST['submit_custom_amount'])) {
        $donation = $_POST['custom_amount'];
            } 
        }
      ?>

    <div class="back-btn">  
      <a href="donation_projects.php?id=<?php echo $id ?>"><button type="button" class="btn">Back to Project Details</button></a>
    </div>

    <div class="container w-75 title">
      <div class="title-box">
        <div class="row">
          <div class="col-8">
          <p class="donate-to">Donate to</p>
            <h3><?php echo $row['title']; ?></h3>
          </div>
          <div class="col-4">
            <div class="box">
              <p class="progress-raised">&#8369; <?php echo number_format($totaldonation); ?> raised</p>
              <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: <?php echo $percentage; ?>%"></div>
              </div>
              <?php
              if ($totaldonation >= $row['goal']) {
                  echo '<p class="progress-to-go">Goal Reached!</p>';
              } else {
                  echo '<p class="progress-to-go">&#8369; ' . number_format($remaining) . ' to go</p>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container top-color w-50"></div>

    <div class="container w-50 don-form">
      <div class="mode text-center">
        <img class="logo" src="img/PayPal.jpg">
      </div>

<div class="container w-75 fields">
        <div class="row">
            <form>
                <div class="form-group">
                    <span class="input-container">
                        <label for="donation_field">Donation Amount</label>
                        <div class="custom-field">
                            <span class="currency">&#8369;</span>
                                <input type="text" min="50" max="<?php echo $remaining?>" id="donation_field" class="donation_input" value="<?php echo number_format($donation) ?>" readonly />
                        </div>
                    </span>

                    <div class="instruction" style="text-align: center;">
                        Please click the button below and follow the instructions provided to complete your <strong>&#8369;<?php echo number_format($donation) ?></strong> donation.
                    </div>
                    

                    <div class="transaction-fee-note" style="text-align: center; font-size: smaller; font-style: italic;">
                        <p>Transaction fee will apply.<br> Estimated fee for this donation: <strong>&#8369;<span id="transaction_fee_amount" style="font-weight: bold;"></span></strong></p>
                    </div>
                    
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="hidden" id="user_id" value="<?php echo $user_id; ?>">

                    <!-- CHECK OUT BUTTON HERE -->
                    <div class="paypal" style="text-align: center;">
                        <div id="paypal-button-container"></div>
                        <!-- Paypal script -->
                        <script>
                            let donationAmount = <?php echo $donation; ?>;
                            const paypalFeePercentage = 0.039; // PayPal fee percentage
                            const paypalFixedFee = 15; // PayPal fixed fee
                            
                            
                            // Function to calculate the amount to be sent for donationAmount to be received in net
                            function calculateSendingAmountForDonation() {
                                const desiredNetAmount = donationAmount; // Desired net amount to receive
                            
                                const sendingAmount = (desiredNetAmount + paypalFixedFee) / (1 - paypalFeePercentage);
                            
                                return sendingAmount.toFixed(2); // Ensure two decimal places for the value
                            }

                            // Function to show an alert if the donation exceeds remaining amount
                            function showAlertIfExceedsRemaining() {
                                if (donationAmount > <?php echo $remaining; ?>) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Donation amount exceeds the remaining project amount!',
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'OK'
                                    });
                                    return true; // Returns true if donation exceeds remaining
                                }
                                return false; // Returns false if donation is within the remaining limit
                            }

                            paypal.Buttons({
                                createOrder: function(data, actions) {
                                    return actions.order.create({
                                        purchase_units: [{
                                            amount: {
                                                value: calculateSendingAmountForDonation()
                                            }
                                        }]
                                    });
                                },
                                onApprove: function (data, actions) {
                                    return actions.order.capture().then(function (details) {

                                        // Formatting the donation amount with the correct currency symbol
                                        const formatter = new Intl.NumberFormat('en-PH', {
                                            style: 'currency',
                                            currency: 'PHP' 
                                        });
                                        
                                        const formattedAmount = formatter.format(donationAmount);
                                        const transactionDetails = {
                                            donation_amount: donationAmount,
                                            don_project_id: '<?php echo $id; ?>',
                                            transaction_id: details.id // Retrieve the transaction ID from PayPal details
                                            // Add more details as needed
                                        };
                                
                                        // Send transaction details to the server
                                        fetch('process_donation.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                            },
                                            body: JSON.stringify(transactionDetails),
                                        })
                                        .then(response => response.text())
                                        .then(result => {
                                            console.log(result); // Log the server response
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Thank you!',
                                                html: `Your donation of ${formattedAmount} was successful.`,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'OK'
                                            });
    
                                            // Redirect to the homepage after a delay (adjust as needed)
                                            setTimeout(function() {
                                                window.location.href = '/Views/Donors-Volunteers/dv_userdashboard.php';
                                            }, 3000); // Redirect after 3 seconds
                                        })
                                        .catch(error => {
                                            console.error('Error:', error); // Log any errors
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'An error occurred during the payment process. Please try again.',
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'OK'
                                            });
                                        });
                                    });
                                }
                            }).render('#paypal-button-container');
                            
                        </script>
                    </div>
                </div>
            </form>
        </div>
    </div>

    </div>    
  </div>
  <?php } ?>
  
    <script>
        // Ensure script runs after DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            let donationAmount = <?php echo $donation; ?>;
            // Calculate the transaction fee (customize this logic based on your fee calculation)
            const paypalFeePercentage = 0.039; // Sample PayPal fee percentage
            const paypalFixedFee = 15; // Sample PayPal fixed fee
            const transactionFee = (donationAmount * paypalFeePercentage) + paypalFixedFee;
            
            // Update the transaction fee amount in the HTML
            document.getElementById('transaction_fee_amount').textContent = transactionFee.toFixed(2); // Set the calculated fee in the placeholder
        });
    </script>

  <!--FOOTER-->
  <footer class="sticky-footer">
        <!-- <h2>Footer Stick to the Bottom</h2> -->
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="donation.php">Donations</a></li>
            <li><a href="volunteer.php">Volunteers</a></li>
            <li><a href="social_assistance.php">Assistance</a></li>
        </ul>
        <p> © Copyright DORA 2023.</p>
    </footer>
        

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    

  </body>
</html>
<?php
 include 'header.php';

function generateReferralCode($level) {
  $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  $referralCode = '';
  $length = 8;

  for ($i = 0; $i < $length; $i++) {
      $referralCode .= $characters[rand(0, strlen($characters) - 1)];
  }

  $referralCode .= $level;

  return $referralCode;
}

function registerUser($referrerId = null, $referrerLevel = 0) {
  $referralCode = generateReferralCode($referrerLevel + 1);

  $query = "INSERT INTO users (referral_code, id, level) VALUES (?, ?, ?)";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$referralCode, $referrerId, $referrerLevel + 1]);

  return $referralCode;
}

function signUpWithReferral($referralCode, $newUserId) {
  $query = "SELECT id, level FROM users WHERE referral_code = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$referralCode]);

  $referrer = $stmt->fetch();
  
  if ($referrer) {
      $referrerId = $referrer['id'];
      $referrerLevel = $referrer['level'];
      $query = "UPDATE users SET referrer_id = ?, level = ? WHERE id = ?";
      $stmt = $pdo->prepare($query);
      $stmt->execute([$Id, $referrerLevel + 1, $newUserId]);
  }
}

/*function getReferralInformation($userId) {
  $query = "SELECT referral_code, referrer_id, level FROM users WHERE id = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$userId]);

  $user = $stmt->fetch();
  
  if ($user) {
      $referralCode = $user['referral_code'];
      $referrerId = $user['referrer_id'];
      $level = $user['level'];
      $query = "SELECT referral_code, level FROM users
*/


?>

<!DOCTYPE html>
<html>
<head>
  <title>Signup Form</title>
  <script>
    function validateForm() {
      var phoneNumber = document.forms["signupForm"]["phone_number"].value;
      var otp = document.forms["signupForm"]["otp"].value;
      var password = document.forms["signupForm"]["password"].value;

      // Check if at least one of the fields is filled
      if (phoneNumber == "" && otp == "" && password == "") {
        alert("Please fill in at least one of the following fields: Phone Number, OTP, or Password");
        return false;
      }

      if (phoneNumber != "" && !isValidPhoneNumber(phoneNumber)) {
        alert("Invalid phone number");
        return false;
      }

      if (password != "" && password.length < 8) {
        alert("Password must be at least 8 characters long");
        return false;
      }

      // If all validations pass, the form can be submitted
      return true;
    }

    function isValidPhoneNumber(phoneNumber) {
      var phoneRegex = /^\d{10}$/;
      return phoneRegex.test(phoneNumber);
    }
  </script>
</head>

<body class="lg:w-96 md:w-96 sm:w-96 xs:w-full mx-auto overflow-auto shadow h-100">
  <section class="bg-gray-100 h-screen">

    <div>
      <img src="assets/images/logo.png" class="logos">
      <h6 class="text-sm text-gray-600 text-center font-light pt-1">100% legal and safety platform</h6>
    </div>


    <section id="qlogincontent">
      <form class="w-11/12 mx-auto mt-5" method="post" action="login.php" name="signupForm" onsubmit="return validateForm()"  >
        <h2 class="text-sm text-gray-600 font-light pb-4">Already have an account? <a href="login.php"><Span
              class="font-bold" style="border-bottom:1px solid red">Login</Span></a>
        </h2>

        <div class="input-container bg-white">
          <i class="fas fa-mobile-alt icon"></i>
          <span class="font-medium text-xl py-3 px-2">+91</span>
          
          <input
            class="appearance-none bg-transparent border-none w-full text-gray-900 mr-3 py-3 text-sm px-2 leading-tight focus:outline-none"
            type="text" placeholder="Input Mobile Phone Number" name="phone_number"  id = "phone_number" aria-label="Full name" required>
        </div>
        
           <div class="grid grid-cols-2 mt-2">
                    <div class="bg-white flex">
                        <i class="far fa-comment-alt icon"></i>
                        <input
                            class="appearance-none bg-transparent border-none w-full text-gray-900 mr-3 py-3 text-sm px-2 leading-tight focus:outline-none"
                            type="text" placeholder="Verification code" name="otp" id = "otp" aria-label="Full name" >
                    </div>
                    <div class="text-center">
                        <button class="bg-orange-500 w-11/12  mx-auto py-3 text-sm text-white  rounded text-md ">
                            OTP
                        </button>
                    </div>
                </div>


        <div class="input-container bg-white mt-2">
          <i class="fas fa-key icon"></i>
          <input
            class="appearance-none bg-transparent border-none w-full text-gray-900 mr-3 py-3 text-sm px-2 leading-tight focus:outline-none bg-white "
            type="password" placeholder="Password" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"  id = "password"aria-label="Fnameull" required>
        </div>


        <div class="input-container bg-white">
          <i class="fas fa-gift icon"></i>

          <?php
           
            if(isset($_GET['refer']))
            {
              $code=$_GET['refer'];
              ?>
              <input
              class="appearance-none bg-transparent border-none w-full text-gray-900 mr-3 py-3 text-sm px-2 leading-tight focus:outline-none"
              type="text" placeholder="Recommendation Code" name="referal_code" value="<?php echo $code;?>" aria-label="Full name">
           <?php 
            }
            else 
            {
              ?>
               <input
              class="appearance-none bg-transparent border-none w-full text-gray-900 mr-3 py-3 text-sm px-2 leading-tight focus:outline-none"
              type="text" placeholder="Recommendation Code" name="referal_code"  aria-label="Full name">
              <?php 
            }
          ?>
        
        </div>

        <h6 class="text-sm text-gray-600 text-center font-light pt-1">Welcome Bonus <span
            class="font-bold text-orange-500">+&#8377;121</span></h6>


        <div class="text-center mt-5">
          <button type="submit" name="submit"
            class="w-full rounded-md text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4
                focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
            Create Account
          </button>
        </div>
        <div class="text-center mt-5">
          <h6 class="text-sm text-gray-600 text-center font-light pt-1">By signing up, you agree to our <span
              class="font-bold text-green-500">Terms & Conditions</span> and <span
              class="font-bold text-green-500">Privacy Policy.</span></h6>
        </div>

        <div class="text-center mt-8">
          <h6 class="text-sm text-gray-900 text-center font-bold pt-1">Safety & Relived</h6>
          <h6 class="text-sm text-gray-600 text-center font-light pt-1">1 CRORE+USERS 18 LAKH+INVESTORS 150 CRORE+USER
            INCOME</h6>
          <br>
          <h6 class="text-sm text-gray-600 text-center font-light pt-1">@ Copyright 2023 BharatWin. All rights reserved.
          </h6>

        </div>
      </form>
     
</body>
</html>

    </section>
    
    <script src="assets/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets/jquery.min.js"></script>
    <script type="text/javascript" src="assets/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="assets/9volume.js"></script>
    <script type="text/javascript">

      function getOtp() {
        
        console.log($("#phone_number").val());
      }

          //  callAjax('form', 'process.php?&phone_number=', 'otp');
          //  return false;

    </script>

<script>
var myInput = document.getElementById("password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}
myInput.onkeyup = function() {
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
}
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }

  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>










</body>

</html>
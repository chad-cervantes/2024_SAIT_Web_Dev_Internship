<?php
// Start the session at the beginning of the file
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Login</title>
  <style>
     body {
      font-family: Arial;
     }
  </style>
</head>
<body>
  <div class="full-screen-container">
  <div class="login-container">
    <form method="GET" action="payment-login.php">
      <h1 class="login-title">Anime Creators Payment Login</h1>
      <h2>Sign Up</h2>
      <div class="username-input">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="password-input">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <!--Password Visibility Toggle-->
        <input type="checkbox" onclick="myFunction()">Show Password
      </div>
      <button class="login-button" type="submit">Sign Up</button>
   </form>
     <form method="POST" action="payment-login.php">
      <h2>Login</h2>
      <div class="username-input">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="password-input">
        <label for="password">Password</label>
        <input type="password" id="password2" name="password" required>
      <!--Password Visibility Toggle-->
        <input type="checkbox" onclick="myFunction2()">Show Password
      </div>
      <button class="login-button" type="submit">Login</button>
    </form>
    <!-- Login for card 2 in marketplace.html -->
    <form method="POST" action="payment-login.php" id="login-form">
      <h2>Login for Card 2</h2>
      <div class="card-username-input">
        <input type="text" id="username-card-2" name="username-2" placeholder="Username" required>
      </div>
      <div class="card-password-input">
	<input type="password" id="password3-card-2" name="password-2" placeholder="Password" required>
        <!-- Password Visibility Toggle -->
        <input type="checkbox" onclick="myFunction3()">Show Password
      </div>
        <button id="submitButton" class="card-submit-payment-button" type="submit">Submit</button>
        <!-- PayPal button container -->
        <div id="paypal-button-popup" class="popup">
          <div class="popup-content" style="padding: 50px">
            <button class="close-button" id="closePopup">&times;</button>
            <div id="paypal-button-container-2" style="width: 95%; margin: auto;"></div>
          </div>
        </div>
      </form>
  </div>
  </div>
  <script>
  function myFunction() {
    let x = document.getElementById("password");
      if (x.type === "password") {
    x.type = "text";
      } else {
    x.type = "password";
      }
    }

    function myFunction2() {
    let y = document.getElementById("password2");
      if (y.type === "password") {
    y.type = "text";
      } else {
    y.type = "password";
      }
    }

    // Show password in card 2
  function myFunction3() {
  let y = document.getElementById("password3-card-2");
  if (y.type === "password") {
      y.type = "text";
  } else {
      y.type = "password";
  }
}
  </script>

<?php
$folderPath = 'login-user/';

if (!file_exists($folderPath)) {
  mkdir($folderPath, 0777, true);
}
?>

<?php
// REGISTRATION
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    //Create $username & $password variables
    $username = $_GET["username"];
    $password = $_GET["password"];

    // Trim whitespace from username and password
    $username = trim($username);
    $password = trim($password);

 // Check if username or password is blank
    if (empty($username) || empty($password)) {
        echo '<script>alert("Username and password cannot be blank. Please enter valid values.");</script>';
        exit();
    }


// Check if username contains spaces
if (strpos($username, ' ') !== false) {
    echo '<script>';
    echo 'alert("Username cannot contain spaces. Please enter a valid username.");';
    echo 'window.location.href = "marketplace.html";'; // Redirect 
    echo '</script>';
    exit();
}


// Check if password contains spaces
if (strpos($password, ' ') !== false) {
    echo '<script>';
    echo 'alert("Password cannot contain spaces. Please enter a valid username.");';
    echo 'window.location.href = "marketplace.html";'; // Redirect 
    echo '</script>';
    exit();
}
 
    // Ensure that the username and password have limited characters
    $minUsernameLength = 5;
    $maxUsernameLength = 15;
    
    $minPasswordLength = 5;
    $maxPasswordLength = 15;

   // Check if username length is within limits
if (strlen($username) < $minUsernameLength || strlen($username) > $maxUsernameLength) {
    echo '<script>';
    echo 'alert("Username must be between ' . $minUsernameLength . ' & ' . $maxUsernameLength . ' characters.");';
    echo 'window.location.href = "marketplace.html";'; // Redirect using JavaScript
    echo '</script>';
    exit();
} elseif (strlen($password) < $minPasswordLength || strlen($password) > $maxPasswordLength) {
    echo '<script>';
    echo 'alert("Password must be between ' . $minPasswordLength . ' & ' . $maxPasswordLength . ' characters.");';
    echo 'window.location.href = "marketplace.html";'; // Redirect using JavaScript
    echo '</script>';
    exit();
}

    // Validate and sanitize user input
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    // Create a directory for the user with their username as the folder name
    $userDirectory = "login-user/$username";

    //Ensures if the filename is a directory
    if (!is_dir($userDirectory)) {
        // If the directory doesn't exist, create it
        if (!mkdir($userDirectory, 0777, true)) {
            echo '<script>alert("Failed to create user directory. Please try again.");</script>';
            exit();
        }

        // Save the password in a text file within the user's directory
        $passwordFile = fopen("$userDirectory/plaintext_password.txt", "w");
        if ($passwordFile) {
            fwrite($passwordFile, $password);
            fclose($passwordFile);
        } else {
            echo '<script>alert("Failed to create password file. Please try again.");</script>';
            exit();
        }

        // Create userLibrary.html and write initial content
        $paymentInfoFile = fopen("$userDirectory/userLibrary.html", "w");
        if ($paymentInfoFile) {
            $initialContent = "Welcome, $username!\nHere is a list of your latest purchases.\nRecommended products based on your purchases.\n";
            fwrite($paymentInfoFile, $initialContent);
            fclose($paymentInfoFile);
        } else {
            echo '<script>alert("Failed to create payment info file. Please try again.");</script>';
            exit();
        }  
        // Display a success alert
        echo '<script>alert("Registration successful!");</script>';
    } else {
        // Display an alert if the username already exists
        echo '<script>alert("Username already exists. Please choose a different username.");</script>';
	    exit();
    }
}
?>  

<?php
// LOGIN VERIFICATION (Main login)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Sanitize and validate the username (e.g., only allow alphanumeric characters)
    if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        $userDirectory = "login-user/$username";
       
        if (is_dir($userDirectory)) {
            $storedPassword = file_get_contents("$userDirectory/plaintext_password.txt");

            if ($password === trim($storedPassword)) {
                
		        $_SESSION["username"] = $username;

            // Check if the card already exists in the user's file
            $userLibraryFile = "$userDirectory/userLibrary.html";
            $cardExists = file_get_contents($userLibraryFile);

            if (!strpos($cardExists, '<!--Card 2: Digital Product-->')) {

            // Start buffering output
            ob_start();

            // Echo the HTML code
            echo '<!--Card 2: Digital Product-->' .
                  '<div class="card" style="padding: 1rem; border: none; border-radius: 1vw; background: white; box-shadow: 0px 5px 5px 0px rgba(0,0,0,.5); text-align: center; width: 30%; height: 90%">' .
                    '<img class="card-image" src="https://animecreators.synology.me/directory/content/alex\'s/books/comic/Comic.png" style="display: block; max-width: 80vw; width: 25vw; height: 30vh; object-fit: fill; object-position: center; aspect-ratio: 16 / 9; margin: auto; border: solid;
                                    border-radius: 1vw;">'.
                    '<div class="card-title" style="font-size: 3vh; padding: 1rem; padding-bottom: 0; margin-bottom: .25rem;">' .
                      'Comic' .
                    '</div>' .
                  '<div class="card-body" style="font-size: 2vh; padding: 0 1rem;">' .
                    'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facilis doloremque repudiandae reiciendis eum cumque, dolore qui iusto tempora vel fugit ducimus possimus nemo repellat sequi est consequatur vero nostrum voluptates!' .
                  '</div>' .
                  '<div class="card-price" style="font-size: 3vh; padding: 1rem;">' .
                    '$1.50' .
                  '</div>' .
                  '<div class="card-footer" style="padding: 0.025vw; padding-bottom: 0; margin-top: 0.052vw;">' .
                  '<a href="#">' .
                    '<button class="info-button" style="background-color: hsl(128, 46%, 43%); color: white; font-size: 1rem; font-weight: bold; border: none; border-radius: .5vw; padding: 1vw 1.5vw; cursor: pointer; width: 25vw; height: 5vh;">More Info Here</button>' .
                  '</a>' .
                  '<a href="#" id="buy-now-link-2">' .
                    '<button onclick="setSelectedProductPrice(1.50)"  class="buy-now-button" id="buy-now-button-card-2" style="background-color: hsl(9, 18%, 61%); color: white; font-size: 1rem; font-weight: bold;  border: none; border-radius: .5vw; padding: 1vw 1.5vw; cursor: pointer; width: 25vw; height: 5vh;">Buy Now</button>' .
                  '</a>' .
                  '<form method="POST" action="payment-login.php" id="login-form">' .
                    '<h2>Login</h2>' .
                    '<div class="username-input">' .
                      '<input type="text" id="username" name="username" style="padding: .8vh; border: 1px solid; border-radius: .3vw; outline: none; font-size: 2vh; font-weight: lighter; color: black; background-color: white; width: 90%;" placeholder="Username" required>' .
                    '</div>' .
                    '<div class="password-input">' .
                      '<input type="password" id="password3" name="password" style="padding: .8vh; border: 1px solid; border-radius: .3vw; outline: none; font-size: 2vh; font-weight: lighter; color: black; background-color: white; width: 90%;" placeholder="Password" required>' .
                      '<!-- Password Visibility Toggle -->' .
                      '<input type="checkbox" onclick="myFunction3()">Show Password' .
                                  '</div>' .
                  '<div id="paypal-button-container-2" style="width: 95%; margin: auto;"></div>' .
                              '</form>' .
                              '</div>' .
                            '</div>';

            // Get the buffered output
            $html_content = ob_get_clean();

            // Append the card's HTML content to the user's file
            file_put_contents($userLibraryFile, $html_content, FILE_APPEND | LOCK_EX);
          }

            // Redirect to the user's file
            header("Location: $userLibraryFile");
            exit();
            } else {
                 echo '<script>alert("Incorrect username and/or password.");</script>';

		// Use header() to redirect back to the main page (marketplace.html)
            	if(isset($_SERVER['HTTP_REFERER'])) {
                	header("Location: " . $_SERVER['HTTP_REFERER']);
            	} else {
                	header("Location: marketplace.html");
                	exit();
            	}

		   }
                } else {
                    echo '<script>alert("Incorrect username and/or password.");</script>';

		 }
            } else {
                echo '<script>alert("Incorrect username and/or password.");</script>';

	     } 
        }
?>

<?php

// Debugging to see if the user accounts exist
function consoleLogUserAccounts($directory) {
    $files = scandir($directory);
    $accounts = array();

    foreach($files as $file) {
        if ($file !== "." && $file !== ".." && is_dir($directory . "/" . $file)) {
            $accounts[] = $file;
        }
    }
    echo "Account list: " . implode(",", $accounts);
}

// Function to log the output of file_get_contents
function logFileContents($filePath) {
    // Check if the file exists
    if (file_exists($filePath)) {
        // Get the contents of the file
        $fileContents = file_get_contents($filePath);

        // Output the file contents for debugging
        echo "File contents of $filePath: <br>";
        echo $fileContents;
    } else {
        // Handle the case where the file doesn't exist
        echo "Error: File not found - $filePath";
    }
}

// LOGIN VERIFICATION (Card 2)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verify login for cards (in this case, card 2)
    $username_card_2 = $_POST["username-2"];
    $password_card_2 = $_POST["password-2"];

    // Sanitize and validate the username (e.g., only allow alphanumeric characters)
    if (!preg_match("/^[a-zA-Z0-9]+$/", $username_card_2)) {
        $userDirectory_card_2 = "login-user/$username_card_2";

        // Check if the directory exists
        if (file_exists($userDirectory_card_2) && is_dir($userDirectory_card_2)) {
            $storedPassword_card_2 = file_get_contents("$userDirectory_card_2/plaintext_password.txt");

            // Log the contents of the password file
            logFileContents("$userDirectory_card_2/plaintext_password.txt");

            if ($password_card_2 === trim($storedPassword_card_2)) {
                $_SESSION["username-2"] = $username_card_2;

                // Check if the card already exists in the user's file
                $userLibraryFile_card_2 = "$userDirectory_card_2/userLibrary.html";
                $cardExists_card_2 = file_get_contents($userLibraryFile_card_2);

                if (!strpos($cardExists_card_2, '<!--Card 2: Digital Product-->')) {

                    // Start buffering output
                    ob_start();

                    // Echo the HTML code
                    echo '<!--Card 2: Digital Product-->' .
                        '<div class="card" style="padding: 1rem; border: none; border-radius: 1vw; background: white; box-shadow: 0px 5px 5px 0px rgba(0,0,0,.5); text-align: center; width: 30%; height: 90%">' .
                        '<img class="card-image" src="https://animecreators.synology.me/directory/content/alex\'s/books/comic/Comic.png" style="display: block; max-width: 80vw; width: 25vw; height: 30vh; object-fit: fill; object-position: center; aspect-ratio: 16 / 9; margin: auto; border: solid;
                                border-radius: 1vw;">'.
                        '<div class="card-title" style="font-size: 3vh; padding: 1rem; padding-bottom: 0; margin-bottom: .25rem;">' .
                        'Comic' .
                        '</div>' .
                        '<div class="card-body" style="font-size: 2vh; padding: 0 1rem;">' .
                        'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facilis doloremque repudiandae reiciendis eum cumque, dolore qui iusto tempora vel fugit ducimus possimus nemo repellat sequi est consequatur vero nostrum voluptates!' .
                        '</div>' .
                        '<div class="card-price" style="font-size: 3vh; padding: 1rem;">' .
                        '$1.50' .
                        '</div>' .
                        '<div class="card-footer" style="padding: 0.025vw; padding-bottom: 0; margin-top: 0.052vw;">' .
                        '<a href="#">' .
                        '<button class="info-button" style="background-color: hsl(128, 46%, 43%); color: white; font-size: 1rem; font-weight: bold; border: none; border-radius: .5vw; padding: 1vw 1.5vw; cursor: pointer; width: 25vw; height: 5vh;">More Info Here</button>' .
                        '</a>' .
                        '<a href="#" id="buy-now-link-2">' .
                        '<button onclick="setSelectedProductPrice(1.50)"  class="buy-now-button" id="buy-now-button-card-2" style="background-color: hsl(9, 18%, 61%); color: white; font-size: 1rem; font-weight: bold;  border: none; border-radius: .5vw; padding: 1vw 1.5vw; cursor: pointer; width: 25vw; height: 5vh;">Buy Now</button>' .
                        '</a>' .
                        '<form method="POST" action="payment-login.php" id="login-form">' .
                        '<h2>Login</h2>' .
                        '<div class="username-input">' .
                        '<input type="text" id="username" name="username" style="padding: .8vh; border: 1px solid; border-radius: .3vw; outline: none; font-size: 2vh; font-weight: lighter; color: black; background-color: white; width: 90%;" placeholder="Username" required>' .
                        '</div>' .
                        '<div class="password-input">' .
                        '<input type="password" id="password3" name="password" style="padding: .8vh; border: 1px solid; border-radius: .3vw; outline: none; font-size: 2vh; font-weight: lighter; color: black; background-color: white; width: 90%;" placeholder="Password" required>' .
                        '<!-- Password Visibility Toggle -->' .
                        '<input type="checkbox" onclick="myFunction3()">Show Password' .
                        '</div>' .
                        '<div id="paypal-button-container-2" style="width: 95%; margin: auto;"></div>' .
                        '</form>' .
                        '</div>' .
                        '</div>';

                    // Get the buffered output
                    $html_content_card_2 = ob_get_clean();

                    // Append the card's HTML content to the user's file
                    file_put_contents($userLibraryFile_card_2, $html_content_card_2, LOCK_EX);
                }

                // Delay the redirection by 1 minute
                sleep(60); // 1 minute delay for popup to appear before the homepage

                // Redirect to the user's file
                header("Location: $userLibraryFile_card_2");
                exit();
            } else {
                echo '<script>alert("Incorrect username and/or password.");</script>';

                // Use header() to redirect back to the main page (marketplace.html)
                if(isset($_SERVER['HTTP_REFERER'])) {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                } else {
                    header("Location: marketplace.html");
                    exit();
                }

                // End the script execution
                exit();
            }
        } else {
            echo '<script>alert("Incorrect username and/or password.");</script>';
        }
    } else {
        echo '<script>alert("Incorrect username and/or password.");</script>';
    }
}

// Console log user accounts
consoleLogUserAccounts("login-user");

?>

</body>
</html>
     
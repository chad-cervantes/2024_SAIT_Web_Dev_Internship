// Variable to store the selected product price
let selectedProductPrice = 0;
  
// Function to set the selected product price
function setSelectedProductPrice(price) {
  selectedProductPrice = price;
}

//Card 1 - Digital Product

// Event listener for the Buy Now button click
     document.getElementById('buy-now-link').addEventListener('click', function (event) {
// Prevent the default link behavior
     event.preventDefault();

     // PP
     paypal.Buttons({
       createOrder: function(data, actions) {
       // Use the selected product price dynamically
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: selectedProductPrice.toFixed(2) // Set the amount based on the selected product price
           }
         }]
       });
     },
     onApprove: function(data, actions) {
      // Handle the approval (e.g., redirect to a success page)
      alert('Transaction approved!');
     }
   }).render('#paypal-button-container');
  // Optionally, you can hide or disable the Buy Now button after the PayPal button is rendered
  document.getElementById('buy-now-link').style.display = 'none';
 });


// Card 2 

// Beginning: This is the code where the Buy button hides and displays the login form

// BUY  BUTTON

// Hide login form initially
document.getElementById('login-form').style.display = 'none';

// Event listener for the "Buy" button
document.getElementById('buy-now-link-2').addEventListener('click', function(event) {
// Prevent the default link behavior
event.preventDefault();

// Show login form
document.getElementById('login-form').style.display = 'block';

// Middle: This is the code where the PayPal button is rendered

// PP
// Render PayPal button

let paypalButtonTimer;

// This initiates the PayPal button creation using the PayPal SDK
paypal.Buttons({
  

  // This defines a function that will be called to create an order when the PayPal button is clicked
  createOrder: function(data, actions) {
      clearTimeout(paypalButtonTimer);
      // This returns a call to the PayPal API to create an order
      return actions.order.create({
          // This specifies the purchase units (items) included in the order
          purchase_units: [{
              // This specifies the amount of the purchase
              amount: {
                  value: selectedProductPrice.toFixed(2) // This sets the value of the purchase to the selectedProductPrice variable, rounded to two decimal places
              }
          }]
      });
  },
  // This defines a function that will be called when the user approves the transaction on PayPal
  onApprove: function(data, actions) {
      alert('Transaction approved!'); // This displays an alert message indicating that the transaction has been approved
  },
  // This defines a function that will be called when the user cancels the transaction on PayPal
  onCancel: function(data, actions) {
    alert('Transaction cancelled.'); // This displays an alert message indicating that the transaction has been cancelled

     // Redirect back to marketplace.html
     window.location.href = "marketplace.html";
}
}).render('#paypal-button-container-2'); // This renders the PayPal button inside the element with the ID 'paypal-button-container-2'

// Set a timer to redirect to marketplace.html if the PayPal button is not clicked within 1 minute
paypalButtonTimer = setTimeout(function() {
window.location.href = "marketplace.html";
}, 60000); // 1:00 minute

// This hides the element with the ID 'buy-now-link-2' after the PayPal button is rendered
document.getElementById('buy-now-link-2').style.display = 'none'; 
});


// SUBMIT BUTTON in Login Form

// This retrieves the HTML element with the ID 'login-form' and assigns it to the variable 'loginForm'
const loginForm = document.getElementById('login-form');

// This adds an event listener to the 'click' event of the 'loginForm' element. When the form is submitted, the specified function is executed
loginForm.addEventListener('submit', function(event) {

// This retrieves the HTML element with the ID 'paypal-button-popup' and assigns it to the variable 'popup'
const popup = document.getElementById('paypal-button-popup');

// This changes the CSS display property of the 'popup' element to 'block', making it visible
popup.style.display = 'block';
});


// Paypal button Popup Form in Card 2

// This defines a function named 'openPopupFormCard2'
function openPopupFormCard2() {


function authenticateUser(username, password) {
// Create a new XMLHttpRequest object
var xhr = new XMLHttpRequest();


// Configure the request
xhr.open('POST', 'payment-login.php', true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


// Define a callback function to handle the response
xhr.onload = function() {
  console.log('XHR status:', xhr.status); // Log XHR status
  if (xhr.status >= 200 && xhr.status < 300) {
  
// Request was successful
  var response = xhr.responseText;
  console.log('Response:', response); // Log response
  
if (response === 'success') {
    // Authentication successful, display PayPal button
      document.getElementById('paypal-button-popup').style.display = 'block';
  } else {
    // Authentication failed, display error message
      alert('Invalid username or password. Please try again.');
   }
} else {
  // Request failed, display error message
  alert('An error occurred. Please try again later.');
 }
};


// Handle any errors that occur during the request
xhr.onerror = function() {
  console.error('Request failed');
// Display an error message
  alert('An error occurred. Please try again later.');
};


// Convert the username and password to URL-encoded format
const formData = 'username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password);
console.log('Form data:', formData); // Log form data


// Send the request with the form data
xhr.send(formData);
}


// This function is called when the user submits the form
function handleSubmit() {
// Get the username and password from the form fields
const usernameCard2 = document.getElementById('username-card-2').value.trim();
const passwordCard2 = document.getElementById('password3-card-2').value.trim();


// Check if both the username and password are not empty
if (usernameCard2 !== '' && passwordCard2 !== '') {
// Call the authenticateUser function with the username and password
  console.log('Submitting form...'); // Log form submission
  authenticateUser(usernameCard2, passwordCard2); // Fix the parameter names here
} else {
// Display an alert message instructing the user to enter their username and password if they are empty
  alert('Please enter your username and password.');
}
}
handleSubmit();
};


// Combined event listener for submit and close buttons

// This line adds an event listener to the entire document for the 'click' event. When a click event occurs anywhere within the document, the specified function will be executed.
document.addEventListener('click', function(event) {
// Handle click events for the submit button

// This line checks if the element that triggered the click event has an id attribute equal to 'submitCard2Button'.
// event.target refers to the element that triggered the click event.
// event.target.id retrieves the id attribute of the element that triggered the click event.
if (event.target.id === 'submitCard2Button') {
    // If the clicked element has the id 'submitCard2Button', this line calls the function openPopupFormCard2().
    openPopupFormCard2();
    console.log('Submit button clicked');
    startTimerOnPopup();
}

// Handle click events for the close button

// This line checks if the element that triggered the click event has an id attribute equal to 'closePopup'.
if (event.target.id === 'closePopup') {
    event.preventDefault();

    // This line retrieves a reference to an HTML element with the id 'paypal-button-popup'. This element represents the popup form that needs to be closed.
    const popup = document.getElementById('paypal-button-popup');
    // This line sets the CSS style of the popup element to 'none', effectively hiding it from view.
    popup.style.display = 'none';
}
});

// Function to start the timer for redirection to a user's homepage (userLibrary.html file)
function startTimer(duration, display) {
let timer = duration, minutes, seconds;
        
setInterval(function () {

    // parseInt parses a string and returns an integer
minutes = parseInt(timer / 60, 10);
seconds = parseInt(timer % 60, 10);

    // minutes and seconds will be represented as two digits; add leading zeros to minutes and seconds
minutes = minutes < 10 ? "0" + minutes : minutes;
seconds = seconds < 10 ? "0" + seconds : seconds;

display.textContent = minutes + ":" + seconds;

    if (--timer < 0) {
  // Redirect after timer ends
  window.location.href = "userLibrary.html";
  }

}, 1000);
}

// Function to start the timer when the page is loaded
function startTimerOnPopup() {
let oneMinute = 60,
  display = document.querySelector('#timer');
startTimer(oneMinute, display);
};


// End: This is where the PayPal button's popup container opens up when you correctly enter your username and password


// Show password
function showPassword() {
let y = document.getElementById("password3-card-2");
if (y.type === "password") {
  y.type = "text";
} else {
  y.type = "password";
  console.log('Password shown');
}
}

//Card 3 - Physical Product
      
// Execute PayPal button click programmatically
      paypal.Buttons({
        onClick: function() {
// Definte input variables and their value
            let first_name = document.getElementById('first_name').value;
            let last_name = document.getElementById('last_name').value;
            let address = document.getElementById('address').value;
            let city = document.getElementById('city').value;
            let province = document.getElementById('province').value;
            let postal_code = document.getElementById('postal_code').value;
            let phone_number = document.getElementById('phone_number').value;
            let email = document.getElementById('email').value;
    
//Ensure that all required inputs are included
            function validateForm() {
                if (first_name.length === 0 || first_name.length == null) {
                    alert("First name is required");
                    return false;
                }
                if (last_name.length === 0 || last_name.length == null) {
                    alert("Last name is required");
                    return false;
                }
                if (address.length === 0 || address.length == null) {
                    alert("Address is required");
                    return false;
                }
                if (city.length === 0 || city.length == null) {
                    alert("City is required");
                    return false;
                }
                if (province.length === 0 || province.length == null) {
                    alert("Province is required");
                    return false;
                }
                if (postal_code.length === 0 || postal_code.length == null) {
                    alert("Postal code is required");
                    return false;
                }
                if (phone_number.length === 0 || phone_number.length == null) {
                    alert("Phone number is required");
                    return false;
                }
                if (email.length === 0 || email.length == null) {
                    alert("Email is required");
                    return false;
                }
                // Additional validation logic can be added here if needed
                return true;
            }
    
            // Validate the form before proceeding
            return validateForm();
        },
        createOrder: function(data, actions) {
            // Use the selected product price dynamically
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: selectedProductPrice.toFixed(2) // Set the amount based on the selected product price
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            // Handle the approval (e.g., redirect to a success page)
            alert('Transaction approved!');
        }
    }).render('#paypal-button-container-3');
    
  
     //Payment Popup Form in card 3

      function openPopupForm() {
        document.getElementById('popup-form').style.display = 'block';
      }

      document.getElementById('buy-now-button').addEventListener('click', openPopupForm);

      function closePopupForm() {
        document.getElementById('popup-form').style.display = 'none';
      } 

   //Show Password Checkbox for Registration & Login
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
   

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .signup-container {
            background-color: white;
            padding: 2rem;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 1rem;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form id="signupForm">
            <div class="form-group">
                <label for="fname">First name</label>
                <input type="text" name="fname" id="lname" required>
            </div>
            <div class="form-group">
                <label for="lname">Last name</label>
                <input type="text" name="lname" id="lname" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div class="form-group">
            <div style="display: flex;">
                <span>Gender:</span>
                
                   <span>Male</span>
                   <input type="radio" name="gender" id="male" value="male" checked>
                   <span>Female</span>
                   <input type="radio" name="gender" id="female" value="female">
            </div><br>
            <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" required>
            </div>
            <div class="form-group">
                    <label for="phone">Enter a phone number:</label>
                    <input type="text" id="phone" name="phone"  required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" required>
                <div id="passwordError" class="error"></div>
            </div>
           
            <button type="submit">Sign Up</button>
             <a href="<?base_url() ?>login">Login</a>
        </form>
    </div>
    <script>
       document.getElementById('signupForm').addEventListener('submit', function(event) {
       event.preventDefault(); // Prevent default form submission

    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('cpassword').value;
    const errorElement = document.getElementById('passwordError');

    errorElement.textContent = '';

    if (password !== confirmPassword) {
        errorElement.textContent = 'Passwords do not match';
        return;
    }

    // Collect form data
    const formData = new FormData(this); 
    fetch('<?= base_url() ?>Signup/submit', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Signup successful!');
            window.location.href = '<?= base_url() ?>login';
        } else {
            alert('Signup failed: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while signing up.');
    });
});

    </script>

</body>

</html>

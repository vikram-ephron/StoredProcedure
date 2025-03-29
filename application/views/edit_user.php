
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>

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
    <h2>Edit User</h2>

    <form action="<?php echo site_url('admin/user/update'); ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

        <div class="form-group">
            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" value="<?php echo $user['firstname']; ?>">
        </div>

        <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>">
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select name="gender">
                <option value="male" <?php echo ($user['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo ($user['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" name="age" value="<?php echo $user['age']; ?>">
        </div>

        <div class="form-group">
            <label for="number">Phone Number:</label>
            <input type="text" name="number" value="<?php echo $user['number']; ?>">
        </div>

        <div class="form-group">
            <label for="modify">Status:</label>
            <select name="modify">
                <option value="1" <?php echo ($user['modify'] == 1) ? 'selected' : ''; ?>>Active</option>
                <option value="0" <?php echo ($user['modify'] == 0) ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>

        <button type="submit">Update</button>
    </form>
</div>

</body>
</html>

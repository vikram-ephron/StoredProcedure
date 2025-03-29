<pre>
<?php //print_r($this->session->all_userdata()); ?>
</pre>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .btn { display: inline-block; padding: 10px 20px; margin: 10px; text-decoration: none; color: white; border-radius: 5px; }
        .btn-login { background-color: #4CAF50; }
        .btn-signup { background-color: #008CBA; }
    </style>
</head>
      <body>
          <div class="container">
          <p>simple welcome page</p>
          <div>
              <a href="<?php echo base_url('login'); ?>" class="btn btn-login">Login</a>
              <a href="<?php echo base_url('signup'); ?>" class="btn btn-signup">Sign Up</a>
          </div>
          </div>
      </body>
</html>
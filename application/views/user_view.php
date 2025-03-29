<pre>
<?php //print_r($this->session->all_userdata()); ?>
</pre>

<!DOCTYPE html>
<html>
<head>
    <title>AJAX DataTable</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<body>
<p>Logged in as: <?php echo $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname'); ?> &nbsp; <a href="<?php echo site_url('login/logout'); ?>">Logout</a></p>

    <table id="user_table" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Moble Number</th>
                <th>Status</th>
                <th>Action</th>


                <!-- Add other columns as needed -->
            </tr>
        </thead>
    </table>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#user_table').DataTable({
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo site_url('admin/user/get_users'); ?>",
                    "type": "POST"
                },
                "columns": [
                    {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }},
                    {
                    "data": "firstname",
                    "render": function(data, type, row) {
                        return data + ' ' + row.lastname;
                    }
                },
                    { "data": "email" },
                    { "data": "gender" },
                    { "data": "age"},
                    { "data": "number" },
                    {
                    "data": "modify",
                    "render": function(data, type, row) {
                        return data == 1 ? "Active" : "Inactive";
                      }
                    },
                    {
                    "data": null,  // This column doesn't need to correspond to any data field
                    "render": function(data, type, row) {
                        // Generate buttons for Edit, Delete, and View
                        return `
                            <a href="<?php echo site_url('admin/user/edit/'); ?>${row.id}" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(${row.id})">Delete</button>
                        `;
                        }
                    }
                    
                    
                ]
            });
        });

        function deleteUser(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            $.ajax({
                url: "<?php echo site_url('admin/user/delete/'); ?>" + userId,
                type: "POST",
                success: function(response) {
                    $('#user_table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    alert("Error deleting user: " + error);
                }
            });
        }
    }

    </script>
</body>
</html>

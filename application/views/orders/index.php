<!-- application/views/orders/index.php -->

<?php
// echo "----------";
// print_r( $orders);exit();


?>


<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Orders Management</h4>
                    <a href="<?= base_url('orders/create') ?>" class="btn btn-primary">New Order</a>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form action="<?= base_url('orders') ?>" method="get" class="mb-4">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search by user or product" value="<?= $search ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="">All Statuses</option>
                                    <option value="pending" <?= ($status == 'pending') ? 'selected' : '' ?>>Pending</option>
                                    <option value="processing" <?= ($status == 'processing') ? 'selected' : '' ?>>Processing</option>
                                    <option value="shipped" <?= ($status == 'shipped') ? 'selected' : '' ?>>Shipped</option>
                                    <option value="delivered" <?= ($status == 'delivered') ? 'selected' : '' ?>>Delivered</option>
                                    <option value="cancelled" <?= ($status == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <a href="<?= base_url('orders') ?>" class="btn btn-outline-secondary btn-block">Reset</a>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Results Summary -->
                    <div class="mb-3">
                        Found <?= $total_rows ?> order(s)
                    </div>
                    
                    <!-- Orders Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($orders)): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><?= $order['id'] ?></td>
                                            <td>
                                                <?= $order['user_name'] ?><br>
                                                <small class="text-muted"><?= $order['email'] ?></small>
                                            </td>
                                            <td><?= $order['product_name'] ?></td>
                                            <td><?= $order['quantity'] ?></td>
                                            <td>$<?= number_format($order['total_price'], 2) ?></td>
                                            <td>
                                                <?php 
                                                    $status_class = '';
                                                    switch($order['status']) {
                                                        case 'pending': $status_class = 'badge bg-warning'; break;
                                                        case 'processing': $status_class = 'badge bg-info'; break;
                                                        case 'shipped': $status_class = 'badge bg-primary'; break;
                                                        case 'delivered': $status_class = 'badge bg-success'; break;
                                                        case 'cancelled': $status_class = 'badge bg-danger'; break;
                                                    }
                                                ?>
                                                <span class="<?= $status_class ?>"><?= ucfirst($order['status']) ?></span>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                            <td>
                                                <a href="<?= base_url('orders/view/'.$order['id']) ?>" class="btn btn-sm btn-info">View</a>
                                                <a href="<?= base_url('orders/edit/'.$order['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                                                <a href="<?= base_url('orders/delete/'.$order['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No orders found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-3">
                        <?= $pagination ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
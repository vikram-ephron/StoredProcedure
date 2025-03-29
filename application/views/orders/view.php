<!-- application/views/orders/view.php -->

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Order Details #<?= $order['id'] ?></h4>
                    <a href="<?= base_url('orders') ?>" class="btn btn-secondary">Back to Orders</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Customer Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Name:</th>
                                    <td><?= $order['user_name'] ?></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td><?= $order['email'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Order Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Order Date:</th>
                                    <td><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
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
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td><?= date('M d, Y H:i', strtotime($order['updated_at'])) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5>Product Details</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Description</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $order['product_name'] ?></td>
                                        <td><?= $order['description'] ?></td>
                                        <td class="text-right">$<?= number_format($order['price'], 2) ?></td>
                                        <td class="text-center"><?= $order['quantity'] ?></td>
                                        <td class="text-right">$<?= number_format($order['total_price'], 2) ?></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">Order Total:</th>
                                        <th class="text-right">$<?= number_format($order['total_price'], 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="<?= base_url('orders/edit/'.$order['id']) ?>" class="btn btn-primary">Edit Order</a>
                        <a href="<?= base_url('orders/delete/'.$order['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">Delete Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
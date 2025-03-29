<!-- application/views/orders/create.php -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Create New Order</h4>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors() ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?= base_url('orders/create') ?>" method="post">
                        <div class="form-group mb-3">
                            <label for="user_id">Customer</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">Select Customer</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>"><?= $user['firstname'] ?> (<?= $user['email'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="product_id">Product</label>
                            <select name="product_id" id="product_id" class="form-control" required>
                                <option value="">Select Product</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= $product['id'] ?>"><?= $product['name'] ?> - $<?= number_format($product['price'], 2) ?> (<?= $product['stock'] ?> in stock)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Order</button>
                            <a href="<?= base_url('orders') ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

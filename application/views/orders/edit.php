<!-- application/views/orders/edit.php (continued) -->
<div class="form-group mb-3">
                            <label>Quantity</label>
                            <input type="text" class="form-control" value="<?= $order['quantity'] ?>" readonly>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label>Total Price</label>
                            <input type="text" class="form-control" value="$<?= number_format($order['total_price'], 2) ?>" readonly>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="status">Order Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending" <?= ($order['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                                <option value="processing" <?= ($order['status'] == 'processing') ? 'selected' : '' ?>>Processing</option>
                                <option value="shipped" <?= ($order['status'] == 'shipped') ? 'selected' : '' ?>>Shipped</option>
                                <option value="delivered" <?= ($order['status'] == 'delivered') ? 'selected' : '' ?>>Delivered</option>
                                <option value="cancelled" <?= ($order['status'] == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Order</button>
                            <a href="<?= base_url('orders') ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
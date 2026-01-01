<?php include 'header.php'; ?>

<div class="container">
    <h2>Restaurants</h2>

    <?php if (!empty($restaurants)): ?>
        <div class="row">
            <?php foreach ($restaurants as $restaurant): ?>
                <div class="col-md-4">
                    <a href="<?php echo site_url('pos/index?restaurant_id=' . $restaurant['id']); ?>" 
                       class="text-decoration-none text-dark">

                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo htmlspecialchars($restaurant['name']); ?>
                                </h5>
                                <p class="card-text">
                                    <?php echo htmlspecialchars($restaurant['address']); ?>
                                </p>
                            </div>
                        </div>

                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No restaurants found.</p>
    <?php endif; ?>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
<?php
$seoTitle = !empty($product['meta_title']) && $product['meta_title'] !== '0' ? $product['meta_title'] : ($product['name'] . ' | Buy Online at ' . APP_NAME);
$seoDesc = !empty($product['meta_description']) && $product['meta_description'] !== '0' ? $product['meta_description'] : substr(strip_tags($product['description'] ?? ($product['name'] . ' premium quality item at ' . APP_NAME)), 0, 160);
$seoKeywords = !empty($product['meta_keywords']) && $product['meta_keywords'] !== '0' ? (is_array($product['meta_keywords']) ? implode(', ', $product['meta_keywords']) : $product['meta_keywords']) : ($product['name'] . ', fashion, premium wear, ' . APP_NAME);
$seoImage = !empty($product['image_url']) ? BASE_URL . ltrim(explode(',', $product['image_url'])[0], '/') : BASE_URL . 'pictures/default.png';
$seoUrl = url('product_show?id=' . $product['id']);
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($seoTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars($seoDesc) ?>">
<meta name="keywords" content="<?= htmlspecialchars($seoKeywords) ?>">
<link rel="canonical" href="<?= htmlspecialchars($seoUrl) ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="product">
<meta property="og:url" content="<?= htmlspecialchars($seoUrl) ?>">
<meta property="og:title" content="<?= htmlspecialchars($seoTitle) ?>">
<meta property="og:description" content="<?= htmlspecialchars($seoDesc) ?>">
<meta property="og:image" content="<?= htmlspecialchars($seoImage) ?>">
<meta property="product:price:amount" content="<?= htmlspecialchars($product['price']) ?>">
<meta property="product:price:currency" content="Rs">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?= htmlspecialchars($seoUrl) ?>">
<meta property="twitter:title" content="<?= htmlspecialchars($seoTitle) ?>">
<meta property="twitter:description" content="<?= htmlspecialchars($seoDesc) ?>">
<meta property="twitter:image" content="<?= htmlspecialchars($seoImage) ?>">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-papvJkn1+lUOHJZ4KJ/4DhrOd2NT6lUP0N9IuqkQKbtVsjG6uE1j+rT6lCz2/0Rvx+3rj2eBx/NrG85K+YdC7Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link rel="stylesheet" href="<?= BASE_URL ?>css/navbar.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/footer.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/colors.css">
   <link rel="stylesheet" href="<?= BASE_URL ?>css/single-product.css">
   <link href="<?= BASE_URL ?>css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
  /* PRODUCT SECTION */
.product-section {
  padding: 60px 0;
}

.gallery-wrap .main-img-wrap {
  overflow: hidden;
  position: relative;
}

.gallery-wrap .main-img-wrap img {
  width: 100%;
  height: auto;
  transition: transform 0.4s ease;
}

.gallery-wrap .main-img-wrap:hover img {
  transform: scale(1.05);
}

.badge-tag {
  background-color: #c52c1e;
  color: #fff;
  font-weight: 600;
  padding: 0.4rem 0.8rem;
  border-radius: 0.25rem;
  top: 10px;
  left: 10px;
  font-size: 0.8rem;
}

.product-info-wrap {
  background-color: var(--bg-card, #0a0a0a);
}

.review-row .stars i {
  margin-right: 2px;
}

.price-block .current-price {
  color: var(--accent-bronze, #ca9745);
}
.price-block .old-price {
  font-size: 0.95rem;
}

.spec-chips .spec-chip {
  font-size: 0.85rem;
}


.cart{
  background: linear-gradient(135deg, var(--accent-bronze, #ca9745) 0%, #ca9745 100%);
  color: #1a0f0a;
  border: none;
  font-weight: 700;
  border-radius: 12px;
  transition: all 0.3s ease;
}
.cart:hover{
  background: #1a0f0a;
  border: 2px solid var(--accent-bronze, #ca9745);
  color: var(--accent-bronze, #ca9745);
}

.trust-badges .trust-item {
  background-color: rgba(202, 151, 69, 0.08);
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-size: 0.85rem;
  display: flex;
  align-items: center;
  border: 1px solid rgba(202, 151, 69, 0.2);
}

.share-row a {
  color: rgba(255,255,255,0.7);
  font-size: 1rem;
  transition: 0.3s;
}

.share-row a:hover {
  color: var(--accent-bronze, #ca9745);
}


/* Responsive */
@media (max-width: 992px) {
  .product-section {
    padding: 30px 0;
  }

  .gallery-wrap .main-img-wrap img {
    max-height: 60vh;
    object-fit: cover;
  }

  .product-info-wrap {
    padding: 1.25rem !important;
  }

  .add-to-cart-row {
    flex-direction: column;
    align-items: stretch;
  }

  .trust-badges,
  .share-row {
    justify-content: center;
  }
}

@media (max-width: 576px) {
  .gallery-wrap {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .thumbnail-row {
    justify-content: center;
  }

  .trust-badges {
    display: grid !important;
    grid-template-columns: 1fr;
    gap: 10px;
  }

  .single-qty-control {
    width: 100%;
    justify-content: space-between;
  }

  .qty-btn-single {
    min-width: 42px;
  }
}
</style>
</head>
<body>
<?php include('header.php'); ?>


<!-- ── PRODUCT ── -->
<section class="product-section py-5">
  <div class="container">
    <div class="row g-5">

      <!-- Gallery -->
      <div class="col-lg-6">
        <?php
            $productImages = array_filter(array_map('trim', explode(',', $product['image_url'] ?? '')), function($imgPath) {
                return !empty($imgPath) && file_exists(BASE_PATH . '/public/' . $imgPath);
            });
            $productImages = array_values($productImages);
            $mainImage = $productImages[0] ?? '';
        ?>
        <div class="gallery-wrap fade-up">
          <div class="main-img-wrap position-relative rounded">
            <span class="badge-tag position-absolute">New</span>
            <img id="mainImg" src="<?= BASE_URL ?>/<?= htmlspecialchars($mainImage) ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="img-fluid rounded">
            <button type="button" id="prevImgBtn" class="image-nav-btn btn btn-light position-absolute top-50 start-0 translate-middle-y">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button type="button" id="nextImgBtn" class="image-nav-btn btn btn-light position-absolute top-50 end-0 translate-middle-y">
                <i class="bi bi-chevron-right"></i>
            </button>
          </div>
          <?php if(count($productImages) > 1): ?>
          <div class="thumbnail-row d-flex flex-wrap gap-2 mt-3">
              <?php foreach ($productImages as $index => $imgPath): ?>
                  <?php if (!empty($imgPath)): ?>
                  <button type="button" class="thumb-button border-0 bg-transparent p-0" data-index="<?= $index ?>">
                      <img src="<?= BASE_URL ?>/<?= htmlspecialchars($imgPath) ?>" alt="<?= htmlspecialchars($product['name']) ?> thumbnail" class="img-thumbnail rounded" style="max-width:80px; height:auto;">
                  </button>
                  <?php endif; ?>
              <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <style>
        .image-nav-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            opacity: 0.85;
            border: 1px solid rgba(0,0,0,0.08);
            transform: translateY(-50%);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        .image-nav-btn:hover {
            opacity: 1;
        }
        .thumb-button img {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .thumb-button.active-thumb img {
            box-shadow: 0 0 0 2px rgba(202, 151, 69,0.85);
            transform: scale(1.03);
        }
      </style>

      <!-- Product Info -->
      <div class="col-lg-6">
        <div class="product-info-wrap p-4 rounded h-100 d-flex flex-column justify-content-between">

          <div>
            <!-- Category & Title -->
            <p class="product-category text-muted small mb-1 fade-up"><?= htmlspecialchars($product['article_number']); ?></p>
            <h1 class="product-title fw-bold mb-3 fade-up delay-1"><?= htmlspecialchars($product['name']); ?></h1>

            <!-- Ratings & Stock -->
            <div class="review-row d-flex align-items-center mb-3 fade-up delay-1">
              <div class="stars me-2">
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="far fa-star text-warning"></i>
              </div>
              <span class="review-count text-decoration-none me-3">(<?= htmlspecialchars($reviewSummary['count']); ?> Reviews)</span>
              
              <?php if ((int)$product['quantity'] <= 0): ?>
                  <span class="stock-status out-of-stock text-danger fw-bold">
                      <i class="fas fa-times-circle me-1"></i> Out of Stock
                  </span>
              <?php elseif ((int)$product['quantity'] < 10): ?>
                  <span class="stock-status low-stock text-warning fw-bold">
                      <i class="fas fa-exclamation-triangle me-1"></i> Only <?= $product['quantity'] ?> left in stock!
                  </span>
              <?php else: ?>
                  <span class="stock-status in-stock text-success fw-bold">
                      <i class="fas fa-check-circle me-1"></i> In Stock (<?= $product['quantity'] ?> available)
                  </span>
              <?php endif; ?>
              </div>

            <!-- Price -->
            <div class="price-block mb-3 fade-up delay-2">
              <span class="current-price fs-3 fw-bold">Rs. <?= htmlspecialchars($product['price']); ?></span>
              
              <?php if (isset($product['sale_discount_percent']) && (int)$product['sale_discount_percent'] > 0): ?>
                  <span class="save-tag badge bg-success ms-2 text-light">Save <?= (int)$product['sale_discount_percent']; ?>%</span>
              <?php endif; ?>
            </div>
 <?php
            $tags = $product['meta_keywords'] ?? [];

            // If it's JSON stored in DB
            if (is_string($tags)) {
                $decoded = json_decode($tags, true);
                $tags = $decoded ?: explode(',', $tags);
            }

            // Limit to 4 tags only
            $tags = array_slice(array_filter($tags), 0, 4);
        ?>

        <?php foreach ($tags as $tag): ?>
            <span class="badge px-3 py-2" style="background-color:rgba(202, 151, 69,0.15); color:#ca9745; border:1px solid rgba(202, 151, 69,0.3);">
                <?= htmlspecialchars(trim($tag)); ?>
            </span>
        <?php endforeach; ?>
            <hr class="divider">

            <!-- Description -->
            <p class="short-desc text-secondary mb-3 fade-up delay-2"><?= htmlspecialchars($product['description']); ?></p>



            <!-- Size and Fabric Selectors Form -->
            <form method="POST" action="<?= url('') ?>cart_add" id="cartForm" class="fade-up delay-3">
                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                <input type="hidden" name="qty" id="formQty" value="1">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                
                <div class="row g-3 mb-4">
                    <!-- Size Radios -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-light" style="font-size: 0.9rem; letter-spacing: 0.5px;">SIZE</label>
                        <?php
                        $sizeStock = [];
                        if (!empty($product['size'])) {
                            $parts = explode(',', $product['size']);
                            foreach ($parts as $p) {
                                $p = trim($p);
                                if (empty($p)) continue;
                                $sub = explode(':', $p);
                                if (count($sub) === 2) {
                                    $sizeStock[trim($sub[0])] = (int)trim($sub[1]);
                                } else {
                                    $sizeStock[$p] = (int)$product['quantity'];
                                }
                            }
                        }

                        $defaultSize = '';
                        foreach ($sizeStock as $sz => $stk) {
                            if ($stk > 0) {
                                $defaultSize = $sz;
                                break;
                            }
                        }
                        ?>
                        <div class="d-flex flex-wrap gap-2" style="padding: 12px; background-color: rgba(255,255,255,0.05); border: 1px solid rgba(202, 151, 69, 0.3); border-radius: 12px;">
                            <?php foreach ($sizeStock as $sz => $stk): ?>
                                <label class="form-check form-check-inline mb-2" style="margin: 0; cursor: <?= ($stk <= 0 ? 'not-allowed' : 'pointer') ?>;">
                                    <input class="form-check-input" type="radio" name="size" value="<?= htmlspecialchars($sz) ?>" <?= ($sz === $defaultSize ? 'checked' : '') ?> <?= ($stk <= 0 ? 'onclick="alert(\'This size is currently out of stock!\'); return false;"' : '') ?> required>
                                    <span class="form-check-label" style="padding: 8px 14px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.15); <?= ($stk <= 0 ? 'opacity:0.5;' : '') ?> background: rgba(255,255,255,0.08); color: #fff;">
                                        <?= htmlspecialchars($sz) ?> <?php if ($stk <= 0): ?>(Out of stock)<?php endif; ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Quantity & Add to Cart -->
                <div class="d-flex align-items-center gap-3">
                    <div class="single-qty-control" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(202, 151, 69, 0.3); border-radius: 12px; display: inline-flex; align-items: center; padding: 4px;">
                        <button class="qty-btn-single btn btn-link text-light text-decoration-none" type="button" onclick="changeQty(-1)" style="font-size: 1.5rem; font-weight: 300; padding: 0 15px; border: none; box-shadow: none;">−</button>
                        <input class="qty-input-single text-center text-light bg-transparent border-0" type="number" id="qty" value="1" min="1" max="99" readonly style="width: 50px; font-size: 1.1rem; font-weight: bold; pointer-events: none;">
                        <button class="qty-btn-single btn btn-link text-light text-decoration-none" type="button" onclick="changeQty(1)" style="font-size: 1.5rem; font-weight: 300; padding: 0 15px; border: none; box-shadow: none;">+</button>
                    </div>
                    
                    <div class="flex-grow-1">
                        <?php if ((int)$product['quantity'] <= 0): ?>
                            <button type="button" class="btn w-100 d-flex align-items-center justify-content-center disabled" style="background: #333; color: #777; border: 1px solid #444; border-radius: 12px; height: 52px; font-weight: bold; cursor: not-allowed;" disabled>
                                <i class="fas fa-times-circle me-2"></i> Out of Stock
                            </button>
                        <?php else: ?>
                            <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center cart" style="height: 52px; font-size: 1.05rem; font-weight: 700; border-radius: 12px;">
                                <i class="fas fa-shopping-bag me-2"></i> Add to Cart
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

            <?php if (isset($_SESSION['wishlist_error'])): ?>
                <div class="alert alert-danger mt-3" role="alert" style="background-color: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.35); color: #f8d7da;">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($_SESSION['wishlist_error']); ?>
                </div>
                <?php unset($_SESSION['wishlist_error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['wishlist_success'])): ?>
                <div class="alert alert-success mt-3" role="alert" style="background-color: rgba(25, 135, 84, 0.15); border: 1px solid rgba(25, 135, 84, 0.35); color: #d1e7dd;">
                    <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($_SESSION['wishlist_success']); ?>
                </div>
                <?php unset($_SESSION['wishlist_success']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['customer_id'])): ?>
                <form method="POST" action="<?= url('wishlist_toggle') ?>" class="mt-3">
                    <input type="hidden" name="product_id" value="<?= (int)$product['id']; ?>">
                    <input type="hidden" name="redirect_to" value="<?= htmlspecialchars('product_show?id=' . (int)$product['id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center" style="height: 52px; border-radius: 12px; border: 1px solid <?= $isWishlisted ? 'rgba(220, 53, 69, 0.7)' : 'rgba(202, 151, 69, 0.7)' ?>; background: <?= $isWishlisted ? 'rgba(220, 53, 69, 0.18)' : 'rgba(255,255,255,0.08)' ?>; color: <?= $isWishlisted ? '#f8d7da' : '#ffffff' ?> !important; font-weight: 700;">
                        <i class="<?= $isWishlisted ? 'fas fa-heart' : 'far fa-heart' ?> me-2"></i>
                        <?= $isWishlisted ? 'Remove from Wishlist' : 'Add to Wishlist' ?>
                    </button>
                </form>
            <?php else: ?>
                <div class="mt-3">
                    <a href="<?= url('customer_login') ?>" class="btn w-100 d-flex align-items-center justify-content-center" style="height: 52px; border-radius: 12px; border: 1px solid rgba(202, 151, 69, 0.7); background: rgba(255,255,255,0.08); color: #ffffff !important; font-weight: 700; text-decoration: none; transition: all 0.3s ease;">
                        <i class="far fa-heart me-2"></i> Login to save wishlist
                    </a>
                </div>
            <?php endif; ?>
 
          </div>
  </div>
</div>

          <!-- Trust Badges & Share -->
          <div class="mt-auto d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="trust-badges d-flex flex-wrap gap-2">
              <div class="trust-item"><i class="bi bi-truck fs-5"></i> Free Shipping over Rs. 5,000</div>
              <div class="trust-item"><i class="bi bi-arrow-left fs-5"></i> 30-Day Returns</div>
              <div class="trust-item"><i class="bi bi-shield fs-5"></i> 2-Year Warranty</div>
              <div class="trust-item"><i class="bi bi-lock fs-5"></i> Secure Checkout</div>
            </div>
            <div class="share-row d-flex gap-2 align-items-center">
              <span>Share:</span>
              <a href="https:/www.facebook.com"><i class="bi bi-facebook"></i></a>
              <a href="https:/www.x.com"><i class="bi bi-twitter"></i></a>
              <a href="https:/www.pinterest.com"><i class="bi bi-pinterest"></i></a>
              <a href="https:/www.whatsapp.com"><i class="bi bi-whatsapp"></i></a>
            </div>
          </div>

        </div>
      
   

    <!-- Product Tabs -->
    <div class="product-tabs mt-5">
      <ul class="nav nav-tabs" id="productTabs">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-desc">Description</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-specs">Specifications</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-reviews" id="reviewTab">Reviews (<?= htmlspecialchars($reviewSummary['count']); ?>)</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-shipping">Shipping</button></li>
      </ul>
      <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="tab-desc"><?= htmlspecialchars($product['description']); ?></div>
        <div class="tab-pane fade" id="tab-specs">
          <table class="specs-table table table-bordered mt-3">
            <tr><td>Size</td><td><?= htmlspecialchars($product['size']); ?></td></tr>
            <tr><td>Fabric Type</td><td><?php 
                $fabricType = trim($product['Fabric_Type'] ?? '');
                if ($fabricType === '') {
                    $nameText = ($product['name'] ?? '') . ' ' . ($product['description'] ?? '');
                    if (stripos($nameText, 'active') !== false || stripos($nameText, 'gym') !== false || stripos($nameText, 'mesh') !== false) {
                        $fabricType = 'Premium Polyester / Cotton Blend';
                    } elseif (stripos($nameText, 'hoodie') !== false || stripos($nameText, 'sweat') !== false || stripos($nameText, 'pant') !== false || stripos($nameText, 'shorts') !== false) {
                        $fabricType = 'Premium Fleece / French Terry';
                    } else {
                        $fabricType = '100% Premium Cotton';
                    }
                }
                echo htmlspecialchars($fabricType);
            ?></td></tr>
            <tr><td>Design Type</td><td><?= htmlspecialchars($product['Designing']); ?></td></tr>
          </table>
        </div>
        <!-- Reviews -->
        <div class="tab-pane fade" id="tab-reviews">
          <?php if (!empty($_SESSION['review_success'])): ?>
            <div class="alert alert-success mb-3"><?= htmlspecialchars($_SESSION['review_success']); ?></div>
            <?php unset($_SESSION['review_success']); ?>
          <?php endif; ?>
          <?php if (!empty($_SESSION['review_error'])): ?>
            <div class="alert alert-danger mb-3"><?= htmlspecialchars($_SESSION['review_error']); ?></div>
            <?php unset($_SESSION['review_error']); ?>
          <?php endif; ?>

          <!-- Summary -->
          <div class="review-summary">
            <div>
              <div class="big-rating"><?= htmlspecialchars($reviewSummary['average'] ?: '0.0'); ?></div>
              <div class="big-stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <i class="<?= $i <= round($reviewSummary['average']) ? 'fas fa-star' : 'far fa-star'; ?>"></i>
                <?php endfor; ?>
              </div>
              <div class="big-count">Based on <?= htmlspecialchars($reviewSummary['count']); ?> review<?= $reviewSummary['count'] === 1 ? '' : 's'; ?></div>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-lg-8">
              <?php if (count($reviews) === 0): ?>
                <div class="review-card">
                  <p class="review-text">No reviews yet. Be the first to review this product.</p>
                </div>
              <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                  <div class="review-card">
                    <div class="reviewer-name"><?= htmlspecialchars($review['reviewer_name'] ?: 'Customer'); ?></div>
                    <div class="stars mb-1">
                      <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="<?= $i <= (int)$review['rating'] ? 'fas fa-star' : 'far fa-star'; ?>"></i>
                      <?php endfor; ?>
                    </div>
                    <div class="review-date"><?= date('F j, Y', strtotime($review['created_at'])); ?> · Verified Purchase</div>
                    <p class="review-text"><?= nl2br(htmlspecialchars($review['comment'])); ?></p>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

          <div class="review-form-section mt-4">
            <?php if (!empty($_SESSION['customer_id'])): ?>
              <?php if ($canReview): ?>
                <div class="card p-4 mb-4">
                  <h5>Leave a Review</h5>
                  <form method="POST" action="<?= url('') ?>product_review">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    <div class="mb-3">
                      <label class="form-label">Rating</label>
                      <select name="rating" class="form-control" required>
                        <option value="">Choose rating</option>
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                          <option value="<?= $i; ?>"><?= $i; ?> star<?= $i > 1 ? 's' : ''; ?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Your Review</label>
                      <textarea name="comment" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                  </form>
                </div>
              <?php else: ?>
                <div class="alert alert-info mb-4"><?= htmlspecialchars($reviewNotice ?: 'You cannot submit a review for this product.'); ?></div>
              <?php endif; ?>
            <?php else: ?>
              <div class="alert alert-info mb-4">Please <a href="<?= url('') ?>customer_login">login</a> to submit a review.</div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Shipping -->
        <div class="tab-pane fade" id="tab-shipping">
          <div class="row">
            <div class="col-lg-7">
              <div class="desc-body">
                <h5>Shipping Options</h5>
                <table class="specs-table mt-3">
                  <tr><td>Standard Shipping</td><td>3–5 business days · Free over Rs. 5,000</td></tr>
                  <tr><td>Express Shipping</td><td>1–2 business days · Rs. 1,299</td></tr>
                  <tr><td>Overnight</td><td>Next business day · Rs. 2,499</td></tr>
                  <tr><td>International</td><td>7–14 business days · From Rs. 1,999</td></tr>
                </table>
                <h5 style="margin-top:28px;">Returns Policy</h5>
                <p>We offer free returns within 30 days of purchase. Items must be in original, unused condition with all packaging and accessories included. Initiate a return from your account or contact our support team.</p>
                <h5>Warranty</h5>
                <p>This product is covered by a 2-year international warranty against manufacturing defects. Extended warranty plans are available at checkout.</p>
              </div>
            </div>
          </div>
        </div>

 </div>
    </div>
 </div>
  </div>
</section>

<!-- ── RELATED PRODUCTS ── -->
<style>
/* ── Theme-adaptive CSS variables for the Related section ── */
/* Default (light) theme values */
.related-section {
  --rs-bg: #fdfbf7;
  --rs-card-bg: #ffffff;
  --rs-text: #1a1a1a;
  --rs-muted: #555;
  --rs-empty-bg: #1a0f0a;
  --rs-empty-text: #ca9745;
  --rs-empty-p: #e0e0e0;
  --rs-empty-icon-bg: linear-gradient(135deg, #2a1f1a, #1a0f0a);
}

/* Luxury (dark) theme overrides */
.theme-luxury .related-section,
body .related-section {
  --rs-bg: var(--page-card-bg, #fdfbf7);
  --rs-card-bg: var(--page-card-bg, #ffffff);
  --rs-text: var(--text-primary, #1a1a1a);
}

.related-section {
  padding: 80px 0 100px;
  background: var(--rs-bg);
  position: relative;
  overflow: hidden;
  border-top: 1px solid rgba(202, 151, 69,0.15);
}
.related-section::before {
  content: '';
  position: absolute;
  top: 0; left: 50%;
  transform: translateX(-50%);
  width: 80%; height: 500px;
  background: radial-gradient(ellipse at top, rgba(202, 151, 69,0.08) 0%, transparent 70%);
  pointer-events: none;
}
.related-section .section-eyebrow {
  display: inline-block;
  font-size: 0.75rem;
  font-weight: 800;
  letter-spacing: 4px;
  text-transform: uppercase;
  color: #b38230 !important;
  background: linear-gradient(135deg, rgba(202, 151, 69,0.1) 0%, rgba(202, 151, 69,0.15) 100%);
  border: 1px solid rgba(202, 151, 69,0.3);
  padding: 6px 20px;
  border-radius: 50px;
  margin-bottom: 20px;
  box-shadow: 0 4px 15px rgba(202, 151, 69, 0.1);
}
.related-section .section-heading {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 700;
  color: var(--rs-text);
  margin-bottom: 60px;
  position: relative;
}
.related-section .section-heading span {
  color: transparent;
  background: linear-gradient(135deg, #ca9745, #b38230);
  -webkit-background-clip: text;
  background-clip: text;
  font-style: italic;
}

/* Staggered Card Entrance */
@keyframes cardEntrance {
  from { opacity: 0; transform: translateY(50px); }
  to { opacity: 1; transform: translateY(0); }
}
.rel-card-wrapper {
  opacity: 0;
  animation: cardEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
.rel-card-wrapper:nth-child(1) { animation-delay: 0.1s; }
.rel-card-wrapper:nth-child(2) { animation-delay: 0.2s; }
.rel-card-wrapper:nth-child(3) { animation-delay: 0.3s; }
.rel-card-wrapper:nth-child(4) { animation-delay: 0.4s; }

/* Related Product Cards */
.rel-card {
  background: var(--rs-card-bg);
  border: 1px solid rgba(202, 151, 69,0.15);
  border-radius: 20px;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  position: relative;
  height: 100%;
  display: flex;
  flex-direction: column;
  box-shadow: 0 10px 30px rgba(0,0,0,0.03);
}
.rel-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 50px rgba(0,0,0,0.08), 0 0 0 2px rgba(202, 151, 69,0.4);
}
.rel-card-img {
  position: relative;
  overflow: hidden;
  aspect-ratio: 3/4;
  background: #f0ebe0;
}
.rel-card-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
  display: block;
}
.rel-card:hover .rel-card-img img {
  transform: scale(1.1);
}
.rel-card-badge {
  position: absolute;
  top: 15px;
  left: 15px;
  background: linear-gradient(135deg, #ca9745, #b38230);
  color: #fff;
  font-size: 0.7rem;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  padding: 6px 14px;
  border-radius: 30px;
  z-index: 2;
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
.rel-card-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);
  opacity: 0;
  transition: opacity 0.4s ease;
  z-index: 1;
}
.rel-card:hover .rel-card-overlay {
  opacity: 1;
}
.rel-card-quick-view {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%) translateY(20px);
  opacity: 0;
  z-index: 3;
  white-space: nowrap;
  background: rgba(255,255,255,0.9);
  backdrop-filter: blur(10px);
  color: #1a1a1a;
  font-size: 0.85rem;
  font-weight: 700;
  padding: 10px 24px;
  border-radius: 40px;
  text-decoration: none;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}
.rel-card-quick-view:hover {
  background: #1a1a1a;
  color: #ca9745;
}
.rel-card:hover .rel-card-quick-view {
  opacity: 1;
  transform: translateX(-50%) translateY(0);
}
.rel-card-body {
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 12px;
  flex: 1;
  background: var(--rs-card-bg);
}
.rel-card-stars {
  display: flex;
  align-items: center;
  gap: 4px;
  font-size: 0.85rem;
}
.rel-card-stars i { color: #ca9745; }
.rel-card-name {
  font-family: 'Playfair Display', serif;
  font-size: 1.15rem;
  font-weight: 700;
  color: var(--rs-text) !important;
  margin: 0;
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.rel-card-price {
  font-size: 1.2rem;
  font-weight: 800;
  color: #ca9745;
}
.rel-card-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  width: 100%;
  padding: 14px 20px;
  border-radius: 12px;
  background: linear-gradient(135deg, #ca9745, #b38230);
  color: #1a0f0a;
  font-size: 0.95rem;
  font-weight: 800;
  border: none;
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  margin-top: auto;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  box-shadow: 0 4px 15px rgba(202, 151, 69, 0.3);
}
.rel-card-btn:hover {
  background: #1a0f0a;
  color: #ca9745;
  box-shadow: 0 10px 25px rgba(26, 15, 10, 0.3);
  transform: translateY(-2px);
}
.rel-card-btn i {
  font-size: 1.1rem;
  transition: transform 0.3s ease;
}
.rel-card-btn:hover i {
  transform: scale(1.1) rotate(-5deg);
}

/* ── Empty State ── Light & Elegant ── */
.empty-state-wrapper {
  position: relative;
  padding: 80px 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  background: linear-gradient(135deg, #fdf9f3 0%, #f5ead8 100%);
  border-radius: 30px;
  margin: 0 auto;
  max-width: 900px;
  border: 1px solid rgba(202, 151, 69,0.2);
  box-shadow: 0 20px 50px rgba(202, 151, 69,0.08), 0 2px 8px rgba(0,0,0,0.04);
}
/* Luxury dark theme override */
.theme-luxury .empty-state-wrapper {
  background: linear-gradient(135deg, #1a0f0a 0%, #2a1a0e 100%);
  border-color: rgba(202, 151, 69,0.25);
  box-shadow: 0 30px 60px rgba(0,0,0,0.3);
}
.empty-state-bg-shapes {
  position: absolute;
  width: 450px;
  height: 450px;
  background: radial-gradient(circle, rgba(202, 151, 69, 0.15) 0%, rgba(0,0,0,0) 70%);
  top: -100px;
  left: -100px;
  animation: drift 12s infinite alternate ease-in-out;
  pointer-events: none;
}
.empty-state-bg-shapes.two {
  top: auto; left: auto;
  bottom: -150px; right: -100px;
  background: radial-gradient(circle, rgba(202, 151, 69, 0.1) 0%, rgba(0,0,0,0) 70%);
  animation: drift 15s infinite alternate-reverse ease-in-out;
}
@keyframes drift {
  100% { transform: translate(40px, 40px); }
}
.empty-state-content {
  position: relative;
  z-index: 2;
  background: rgba(255, 255, 255, 0.65);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(202, 151, 69, 0.2);
  border-radius: 28px;
  padding: 60px 50px;
  max-width: 650px;
  text-align: center;
  box-shadow: 0 15px 40px rgba(202, 151, 69,0.08), 0 2px 8px rgba(0,0,0,0.04);
  animation: zoomFadeIn 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes zoomFadeIn {
  0% { opacity: 0; transform: scale(0.92) translateY(25px); }
  100% { opacity: 1; transform: scale(1) translateY(0); }
}
.empty-state-content .icon-container {
  width: 100px;
  height: 100px;
  margin: 0 auto 30px;
  background: linear-gradient(135deg, #ca9745, #b38230);
  border: none;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 15px 35px rgba(202, 151, 69,0.35);
  animation: pulseLuxury 3s infinite;
  position: relative;
}
.empty-state-content .icon-container svg {
  width: 45px;
  height: 45px;
  fill: #ffffff;
}
.empty-state-content .icon-container::after {
  content: '';
  position: absolute;
  inset: -10px;
  border-radius: 50%;
  border: 1px dashed rgba(202, 151, 69, 0.5);
  animation: spinBorder 15s linear infinite;
}
@keyframes pulseLuxury {
  0% { box-shadow: 0 0 0 0 rgba(202, 151, 69, 0.4), 0 15px 35px rgba(202, 151, 69,0.25); }
  70% { box-shadow: 0 0 0 20px rgba(202, 151, 69, 0), 0 15px 35px rgba(202, 151, 69,0.25); }
  100% { box-shadow: 0 0 0 0 rgba(202, 151, 69, 0), 0 15px 35px rgba(202, 151, 69,0.25); }
}
@keyframes spinBorder {
  100% { transform: rotate(360deg); }
}
.empty-state-content h3 {
  font-family: 'Playfair Display', serif;
  font-size: 2.5rem;
  font-weight: 700;
  color: #1a0f0a !important;
  margin-bottom: 16px;
  letter-spacing: 0.5px;
}
.empty-state-content p {
  color: #5c3c26 !important;
  font-size: 1.1rem;
  line-height: 1.8;
  margin-bottom: 40px;
}
.btn-empty-state {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 16px 40px;
  background: linear-gradient(135deg, #ca9745, #b38230);
  color: #1a0f0a !important;
  border-radius: 50px;
  font-size: 1.05rem;
  font-weight: 900;
  text-decoration: none !important;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  letter-spacing: 1.5px;
  text-transform: uppercase;
  border: none;
  box-shadow: 0 8px 25px rgba(202, 151, 69,0.35);
}
.btn-empty-state:hover {
  background: #1a0f0a;
  color: #ca9745 !important;
  transform: translateY(-4px);
  box-shadow: 0 15px 35px rgba(26,15,10,0.2);
}
.btn-empty-state i {
  transition: transform 0.3s ease;
}
.btn-empty-state:hover i {
  transform: translateX(6px);
}
</style>

<section class="related-section">
  <div class="container">
    <div class="text-center mb-2 fade-up">
      <span class="section-eyebrow">Curated For You</span>
    </div>
    <h2 class="section-heading text-center fade-up delay-1">Related <span>Products</span></h2>

    <?php if (!empty($related_products)): ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
      <?php foreach($related_products as $rel): ?>
      <?php
        $relImages = array_filter(array_map('trim', explode(',', $rel['image_url'] ?? '')));
        $relImage = array_values($relImages)[0] ?? '';
        $relPrice = number_format((float)$rel['price']);
      ?>
      <div class="col rel-card-wrapper">
        <div class="rel-card">
          <div class="rel-card-img">
            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($relImage) ?>" alt="<?= htmlspecialchars($rel['name']) ?>" loading="lazy">
            <span class="rel-card-badge">Top Pick</span>
            <div class="rel-card-overlay"></div>
            <a href="<?= url('product_show?id=' . (int)$rel['id']) ?>" class="rel-card-quick-view">
              <i class="fas fa-eye me-1"></i> Quick View
            </a>
          </div>
          <div class="rel-card-body">
            <div class="rel-card-stars">
              <?php for($s=0; $s<5; $s++): ?>
                <i class="<?= $s < 4 ? 'fas fa-star' : 'far fa-star' ?>"></i>
              <?php endfor; ?>
            </div>
            <h4 class="rel-card-name"><?= htmlspecialchars($rel['name']) ?></h4>
            <div class="rel-card-price">
              Rs. <?= $relPrice ?>
            </div>
            <form method="POST" action="<?= url('cart_add') ?>" style="margin-top: auto;">
              <input type="hidden" name="product_id" value="<?= (int)$rel['id'] ?>">
              <input type="hidden" name="qty" value="1">
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
              <input type="hidden" name="redirect_to" value="product_show?id=<?= (int)$product['id'] ?>">
              <button type="submit" class="rel-card-btn">
                <i class="fas fa-shopping-bag"></i> Add to Cart
              </button>
            </form>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    
    <?php else: ?>
    <div class="empty-state-wrapper">
      <div class="empty-state-bg-shapes"></div>
      <div class="empty-state-bg-shapes two"></div>
      <div class="empty-state-content">
        <div class="icon-container">
          <!-- Inline SVG so it always renders perfectly -->
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.5 5.6L5 7l1.4-2.5L5 2l2.5 1.4L10 2 8.6 4.5 10 7 7.5 5.6zm12 9.8L17 14l1.4-2.5L17 9l2.5 1.4L22 9l-1.4 2.5L22 14l-2.5-1.4zM22 2l-2.5 1.4L17 2l1.4 2.5L17 7l2.5-1.4L22 7l-1.4-2.5L22 2zm-7.63 5.29c-.39-.39-1.02-.39-1.41 0L1.29 18.96c-.39.39-.39 1.02 0 1.41l2.34 2.34c.39.39 1.02.39 1.41 0L16.71 11.04c.39-.39.39-1.02 0-1.41l-2.34-2.34z"/>
          </svg>
        </div>
        <?php if (empty($_SESSION['customer_id'])): ?>
          <h3>Unlock AI Magic</h3>
          <p>Sign in to let our intelligent AI analyze your unique style and seamlessly curate a hyper-personalized collection of luxury products just for you.</p>
          <a href="<?= url('') ?>customer_login" class="btn-empty-state">Sign In & Discover <i class="fas fa-arrow-right ms-2"></i></a>
        <?php else: ?>
          <h3>Curating Your Style...</h3>
          <p>Our AI is currently analyzing your tastes. Browse a few more products, and we'll instantly generate a stunning personalized collection tailored to your exact preferences.</p>
          <a href="<?= url('') ?>products" class="btn-empty-state">Explore Collection <i class="fas fa-arrow-right ms-2"></i></a>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>






<?php include('footer.php');?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function changeQty(amount){
    let qtyInput = document.getElementById('qty');
    let formQty = document.getElementById('formQty');

    let current = parseInt(qtyInput.value) || 1;
    current += amount;

    if(current < 1) current = 1;
    if(current > 99) current = 99;

    qtyInput.value = current;
    formQty.value = current; // sync
}

// also sync manually typed value
document.getElementById('qty').addEventListener('input', function(){
    document.getElementById('formQty').value = this.value;
});

(function() {
    const galleryImages = <?= json_encode($productImages) ?>;
    const mainImg = document.getElementById('mainImg');
    const prevBtn = document.getElementById('prevImgBtn');
    const nextBtn = document.getElementById('nextImgBtn');
    const thumbButtons = document.querySelectorAll('.thumb-button');
    let currentImageIndex = 0;
    let sliderInterval = null;

    function getImageUrl(path) {
        return "<?= BASE_URL ?>/" + path;
    }

    function setGalleryImage(index) {
        if (!galleryImages.length) return;
        if (index < 0) index = galleryImages.length - 1;
        if (index >= galleryImages.length) index = 0;
        currentImageIndex = index;
        if (mainImg) {
            mainImg.src = getImageUrl(galleryImages[currentImageIndex]);
        }
        thumbButtons.forEach(btn => btn.classList.toggle('active-thumb', parseInt(btn.dataset.index) === currentImageIndex));
    }

    function startGalleryAutoplay() {
        stopGalleryAutoplay();
        sliderInterval = setInterval(() => setGalleryImage(currentImageIndex + 1), 3000);
    }

    function stopGalleryAutoplay() {
        if (sliderInterval) {
            clearInterval(sliderInterval);
            sliderInterval = null;
        }
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            setGalleryImage(currentImageIndex - 1);
            startGalleryAutoplay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            setGalleryImage(currentImageIndex + 1);
            startGalleryAutoplay();
        });
    }

    thumbButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            setGalleryImage(parseInt(this.dataset.index));
            startGalleryAutoplay();
        });
    });

    if (galleryImages.length > 0) {
        setGalleryImage(0);
        startGalleryAutoplay();
    }
})();
</script>
</body>
</html>

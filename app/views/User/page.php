<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= APP_NAME ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
 <link rel="stylesheet" href="<?= BASE_URL ?>css/navbar.css">
 <link rel="stylesheet" href="<?= BASE_URL ?>css/colors.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/footer.css">
   <link rel="stylesheet" href="<?= BASE_URL ?>css/cat-product.css">
   <link href="<?= BASE_URL ?>css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<?php
$blackTextPages = [
    'How to Order from StitchSmart',
    'Terms & Conditions',
    'Shipping & Delivery'
];
$blackTextPage = in_array($page['title'] ?? '', $blackTextPages, true) && ($global_theme ?? 'theme-luxury') === 'theme-luxury';
?>
<style>
 .headcon{
        height: 250px;
        background: linear-gradient(135deg, #1a0f0a 0%, #2d1a12 100%);
        color:#fff;
        display: flex;
        justify-content:center;
        align-items:center;
    }
    .headcon h1{
        font-size:3rem;
        color: #ca9745 !important;
    }
.page2 {
    background-color: var(--page-bg, var(--bg-dark, #000));
    padding: 30px 0;
    color: var(--page-text, #f4e9d3) !important;
}
.page2 * {
    color: var(--page-text, #f4e9d3) !important;
}
.page2.page-black-text,
.page2.page-black-text h1,
.page2.page-black-text h2,
.page2.page-black-text h3,
.page2.page-black-text h4,
.page2.page-black-text h5,
.page2.page-black-text h6,
.page2.page-black-text p,
.page2.page-black-text li,
.page2.page-black-text span,
.page2.page-black-text strong,
.page2.page-black-text em,
.page2.page-black-text small,
.page2.page-black-text td,
.page2.page-black-text th,
.page2.page-black-text a {
    color: #1a0f0a !important;
}
.page2 h1,
.page2 h2,
.page2 h3,
.page2 h4,
.page2 h5,
.page2 h6 {
    color: var(--page-heading, #f4e9d3) !important;
}
.page2 p,
.page2 li,
.page2 span,
.page2 strong,
.page2 em,
.page2 small,
.page2 td,
.page2 th {
    color: var(--page-text, #f4e9d3) !important;
}
.page2 a {
    color: var(--page-link, #ca9745) !important;
}
.page2 a:hover {
    color: #ffffff !important;
}
.page2 .text-muted {
    color: var(--page-muted, #d8c9a2) !important;
}
.page2 .card,
.page2 .faq-card,
.page2 .help-header,
.page2 .contact-section {
    background-color: var(--page-card-bg, var(--bg-card, #0a0a0a)) !important;
    color: var(--page-text, #f4e9d3) !important;
    border-color: var(--page-border, rgba(202, 151, 69,0.2)) !important;
}
.page2 .card h1,
.page2 .card h2,
.page2 .card h3,
.page2 .card h4,
.page2 .card h5,
.page2 .card h6,
.page2 .faq-card h1,
.page2 .faq-card h2,
.page2 .faq-card h3,
.page2 .faq-card h4,
.page2 .faq-card h5,
.page2 .faq-card h6,
.page2 .help-header h1,
.page2 .help-header h2,
.page2 .help-header h3,
.page2 .help-header h4,
.page2 .contact-section h1,
.page2 .contact-section h2,
.page2 .contact-section h3,
.page2 .contact-section h4,
.page2 .contact-section h5,
.page2 .contact-section h6,
.page2 .card p,
.page2 .card li,
.page2 .faq-card p,
.page2 .contact-section p,
.page2 .help-header p {
    color: var(--page-text, #f4e9d3) !important;
}
.help-header { background-color: var(--bg-card, #0a0a0a); padding: 60px 15px 30px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.2); margin-bottom: 40px; } .help-header h1 { font-weight: 600; margin-bottom: 15px; } .faq-card { margin-bottom: 15px; border-radius: 8px; border: 1px solid rgba(202, 151, 69,0.2); transition: transform 0.2s; background: var(--bg-card, #0a0a0a); } .faq-card:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(202, 151, 69,0.1); } .contact-section { background-color: var(--bg-card, #0a0a0a); padding: 40px 20px; border-radius: 8px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.2); margin-top: 40px; border: 1px solid rgba(202, 151, 69,0.2); } .contact-section h4 { margin-bottom: 15px; font-weight: 500; } .contact-section p { font-size: 1.1rem; margin-bottom: 0; } 
</style>
</head>
<body>
 <?php include('header.php'); ?>

<div class="main">
    
 <?php
    $customPages = ['about-us', 'product-advice', 'payment-and-financing', 'our-story', 'ourstory', 'shipping-and-delivery', 'terms-and-condition', 'how-to-order'];
 ?>
 <?php if (isset($slug) && in_array($slug, $customPages)): ?>
    <?php
        $content = $page['content'] ?? '';
        
        // Clean up un-evaluated PHP tags in the database content
        $content = preg_replace_callback('/(<\?=|<\?php echo)\s*(BASE_URL|url\(\'\'\)|url\(\"\"\))\s*\??\s*?>\/index\.php\?page=([a-zA-Z0-9_-]+)/i', function($matches) {
            return url($matches[3]);
        }, $content);

        $content = preg_replace_callback('/(<\?=|<\?php echo)\s*(BASE_URL|url\(\'\'\)|url\(\"\"\))\s*\??\s*?>\/([a-zA-Z0-9_-]+)/i', function($matches) {
            return url($matches[3]);
        }, $content);

        $content = preg_replace_callback('/(<\?=|<\?php echo)\s*(BASE_URL|url\(\'\'\)|url\(\"\"\))\s*\??\s*?>/i', function($matches) {
            return url('');
        }, $content);

        // Fallbacks for specific literal queries
        $content = str_replace(
            ['<?= BASE_URL ?>/index.php?page=contact', '<?php echo BASE_URL; ?>/index.php?page=contact', '<?= url(\'\') ?>contact', '<?= url("") ?>contact'],
            [url('contact'), url('contact'), url('contact'), url('contact')],
            $content
        );
        $content = str_replace(
            ['<?= BASE_URL ?>/index.php?page=allproducts', '<?php echo BASE_URL; ?>/index.php?page=allproducts', '<?= url(\'\') ?>allproducts', '<?= url("") ?>allproducts'],
            [url('allproducts'), url('allproducts'), url('allproducts'), url('allproducts')],
            $content
        );

        echo $content;
    ?>
 <?php else: ?>
  <div class="container-fluid headcon">
<h1 class="text-center mb-4"><?= htmlspecialchars($page['title'] ?? 'Page'); ?></h1>
</div>
    <div class="page2<?= $blackTextPage ? ' page-black-text' : '' ?>">
        <?php
            $content = $page['content'] ?? '';
            // Clean up un-evaluated PHP tags for non-custom pages as well
            $content = preg_replace_callback('/(<\?=|<\?php echo)\s*(BASE_URL|url\(\'\'\)|url\(\"\"\))\s*\??\s*?>\/index\.php\?page=([a-zA-Z0-9_-]+)/i', function($matches) {
                return url($matches[3]);
            }, $content);

            $content = preg_replace_callback('/(<\?=|<\?php echo)\s*(BASE_URL|url\(\'\'\)|url\(\"\"\))\s*\??\s*?>\/([a-zA-Z0-9_-]+)/i', function($matches) {
                return url($matches[3]);
            }, $content);

            $content = preg_replace_callback('/(<\?=|<\?php echo)\s*(BASE_URL|url\(\'\'\)|url\(\"\"\))\s*\??\s*?>/i', function($matches) {
                return url('');
            }, $content);

            $content = str_replace(
                ['<?= BASE_URL ?>/index.php?page=contact', '<?php echo BASE_URL; ?>/index.php?page=contact', '<?= url(\'\') ?>contact', '<?= url("") ?>contact'],
                [url('contact'), url('contact'), url('contact'), url('contact')],
                $content
            );
            $content = str_replace(
                ['<?= BASE_URL ?>/index.php?page=allproducts', '<?php echo BASE_URL; ?>/index.php?page=allproducts', '<?= url(\'\') ?>allproducts', '<?= url("") ?>allproducts'],
                [url('allproducts'), url('allproducts'), url('allproducts'), url('allproducts')],
                $content
            );

            echo $content;
        ?>
    </div>
 <?php endif; ?>
</div>


<?php include('footer.php'); ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

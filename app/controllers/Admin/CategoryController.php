<?php

require_once BASE_PATH . '/app/models/ad_category.php';
require_once BASE_PATH . '/config/database.php';

class CategoryController {

    private $categoryModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();

        $this->categoryModel = new Category($db);
    }

    /*
    ==============================
    SHOW ALL CATEGORIES
    ==============================
    */

    public function index()
    {
        $categories = $this->categoryModel->getCategoriesTree();

        $data = [
    'title' => 'Categories',
    'theme' => $_SESSION['theme'] ?? 'theme-default',
    'view' => 'admin/admin_categories.php',
    'categories' => $categories
];

extract($data);

require BASE_PATH . '/app/views/admin/layout.php';
    }


    /*
    ==============================
    SHOW ADD CATEGORY FORM
    ==============================
    */

    public function create()
    {
        // Only show Men, Women, Kids as selectable parent categories
        $parents = $this->categoryModel->getMainParentCategories();

       $data = [
    'title' => 'Add Category',
    'theme' => $_SESSION['theme'] ?? 'theme-default',
    'view' => 'admin/add_category.php',
    'parents' => $parents
];

extract($data);

require BASE_PATH . '/app/views/admin/layout.php';
    }


    /*
    ==============================
    STORE CATEGORY
    ==============================
    */

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // CSRF Token Validation
            if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? null)) {
                $_SESSION['errors'] = ['csrf' => 'Invalid security token. Please refresh the page and try again.'];
                header("Location: " . url("") . "add_category");
                exit;
            }
            
            // PHP Validation
            $errors = [];
            $name = trim($_POST['cat_name'] ?? '');
            $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : 0;

            if (empty($name)) {
                $errors['cat_name'] = "Fill the Category Name field.";
            }
            $cat_desc = trim($_POST['cat_desc'] ?? '');
            if (empty($cat_desc)) {
                $errors['cat_desc'] = "Fill the Category Description field.";
            }

            // Image Validation
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $maxFileSize = 5 * 1024 * 1024; // 5MB

            if (!empty($_FILES['cimage']['name'])) {
                $ext = strtolower(pathinfo($_FILES['cimage']['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowedExtensions)) {
                    $errors['cimage'] = "Category Image must be JPG, PNG, or WEBP.";
                } elseif ($_FILES['cimage']['size'] > $maxFileSize) {
                    $errors['cimage'] = "Category Image must be under 5MB.";
                }
            }

            if (!empty($_FILES['bimage']['name'])) {
                $ext = strtolower(pathinfo($_FILES['bimage']['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowedExtensions)) {
                    $errors['bimage'] = "Category Banner must be JPG, PNG, or WEBP.";
                } elseif ($_FILES['bimage']['size'] > $maxFileSize) {
                    $errors['bimage'] = "Category Banner must be under 5MB.";
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = [
                    'cat_name' => $name,
                    'parent_id' => $parent_id,
                    'cat_desc' => $_POST['cat_desc'] ?? '',
                    'meta_title' => $_POST['meta_title'] ?? '',
                    'meta_desc' => $_POST['meta_desc'] ?? '',
                    'meta_keywords' => $_POST['meta_keywords'] ?? ''
                ];
                header("Location: " . url("") . "add_category");
                exit;
            }

            $uploadDir = BASE_PATH . '/public/uploads/category/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $banner = '';
            $image = '';

            /*
            =====================
            BANNER IMAGE UPLOAD
            =====================
            */

            if (!empty($_FILES['bimage']['name'])) {
                $ext = strtolower(pathinfo($_FILES['bimage']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $allowedExtensions) && $_FILES['bimage']['size'] <= $maxFileSize) {
                    $bannerName = time().'_banner_'.$_FILES['bimage']['name'];
                    $bannerPath = $uploadDir . $bannerName;
                    move_uploaded_file($_FILES['bimage']['tmp_name'], $bannerPath);
                    $banner = 'uploads/category/' . $bannerName;
                }
            }


            /*
            =====================
            CATEGORY IMAGE UPLOAD
            =====================
            */

            if (!empty($_FILES['cimage']['name'])) {
                $ext = strtolower(pathinfo($_FILES['cimage']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $allowedExtensions) && $_FILES['cimage']['size'] <= $maxFileSize) {
                    $imageName = time().'_cat_'.$_FILES['cimage']['name'];
                    $imagePath = $uploadDir . $imageName;
                    move_uploaded_file($_FILES['cimage']['tmp_name'], $imagePath);
                    $image = 'uploads/category/' . $imageName;
                }
            }


            /*
            =====================
            FORM DATA
            =====================
            */

            $data = [
                'name' => $name,
                'desc' => $_POST['cat_desc'] ?? '',
                'parent' => $parent_id,
                'banner' => $banner,
                'image' => $image,
                'meta_title' => $_POST['meta_title'] ?? '',
                'meta_desc' => $_POST['meta_desc'] ?? '',
                'meta_keywords' => $_POST['meta_keywords'] ?? ''
            ];


            /*
            =====================
            INSERT CATEGORY
            =====================
            */

            $this->categoryModel->createCategory($data);

            $_SESSION['success'] = "Category added successfully!";
            header("Location: " . url("") . "admin_categories");
            exit;
        }
    }

public function edit()
{
    if(!isset($_GET['id'])){
        header("Location: " . url("") . "admin_categories");
        exit;
    }

    $id = $_GET['id'];

    // Get category by ID
    $category = $this->categoryModel->getCategoryById($id);

    // Get only Men, Women, Kids as selectable parents
    $parents = $this->categoryModel->getMainParentCategories();

   $data = [
    'title' => 'Edit Category',
    'theme' => $_SESSION['theme'] ?? 'theme-default',
    'view' => 'admin/edit_category.php',
    'category' => $category,
    'parents' => $parents
];

extract($data);

require BASE_PATH . '/app/views/admin/layout.php';
}


/*
==============================
UPDATE CATEGORY
==============================
*/
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // CSRF Token Validation
            if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? null)) {
                $_SESSION['errors'] = ['csrf' => 'Invalid security token. Please refresh the page and try again.'];
                $_POST['id'] = $_POST['id'] ?? null;
                if ($_POST['id']) {
                    header("Location: " . url("") . "edit_category?id=" . $_POST['id']);
                }
                exit;
            }

            $id = $_POST['id'];
            $name = trim($_POST['cat_name'] ?? '');
            $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : 0;

            // PHP Validation
            $errors = [];
            if (empty($name)) {
                $errors[] = "Category name is required.";
            }
            if ($parent_id == $id) {
                $errors[] = "A category cannot be its own parent.";
            }

            if (!empty($errors)) {
                $_SESSION['error'] = implode("<br>", $errors);
                header("Location: " . url("") . "edit_category?id=" . $id);
                exit;
            }

            $uploadDir = BASE_PATH . '/public/uploads/category/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $banner = $_POST['old_banner'] ?? '';
            $image  = $_POST['old_image'] ?? '';
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $maxFileSize = 5 * 1024 * 1024;

            // Banner image upload
            if (!empty($_FILES['bimage']['name'])) {
                $ext = strtolower(pathinfo($_FILES['bimage']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $allowedExtensions) && $_FILES['bimage']['size'] <= $maxFileSize) {
                    $bannerName = time().'_banner_'.$_FILES['bimage']['name'];
                    $bannerPath = $uploadDir . $bannerName;
                    move_uploaded_file($_FILES['bimage']['tmp_name'], $bannerPath);
                    $banner = 'uploads/category/'.$bannerName;
                }
            }

            // Category image upload
            if (!empty($_FILES['cimage']['name'])) {
                $ext = strtolower(pathinfo($_FILES['cimage']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $allowedExtensions) && $_FILES['cimage']['size'] <= $maxFileSize) {
                    $imageName = time().'_cat_'.$_FILES['cimage']['name'];
                    $imagePath = $uploadDir . $imageName;
                    move_uploaded_file($_FILES['cimage']['tmp_name'], $imagePath);
                    $image = 'uploads/category/'.$imageName;
                }
            }

            $data = [
                'id' => $id,
                'name' => $name,
                'desc' => $_POST['cat_desc'],
                'parent' => $parent_id,
                'banner' => $banner,
                'image' => $image,
                'meta_title' => $_POST['meta_title'],
                'meta_desc' => $_POST['meta_desc'],
                'meta_keywords' => $_POST['meta_keywords']
            ];

            $this->categoryModel->updateCategory($data);

            $_SESSION['success'] = "Category updated successfully!";
            header("Location: ".url("") . "admin_categories");
            exit;
        }
    }
    /*
    ==============================
    DELETE CATEGORY
    ==============================
    */

    public function delete()
    {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            $this->categoryModel->deleteCategory($id);

            header("Location: " . url("") . "admin_categories");
            exit;
        }
    }

}

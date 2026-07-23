<?php
require_once __DIR__ . '/../../models/Warranty.php';

class WarrantyController
{
    private Warranty $warrantyModel;

    public function __construct()
    {
        global $conn;
        $this->warrantyModel = new Warranty($conn);
        
        // Ensure user is logged in
        if (empty($_SESSION['customer_logged_in']) || empty($_SESSION['customer_id'])) {
            header('Location: ' . url('customer_login'));
            exit;
        }
    }

    public function index() {
        $customerId = (int)$_SESSION['customer_id'];
        $warranties = $this->warrantyModel->getUserWarranties($customerId);
        $claims = $this->warrantyModel->getUserClaims($customerId);
        require_once __DIR__ . '/../../views/User/warranties.php';
    }

    public function submitClaim()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $warrantyId = (int)$_POST['warranty_id'];
            $description = htmlspecialchars($_POST['description'] ?? '');
            
            // Image Upload Handling
            $imageUrl = null;
            if (isset($_FILES['claim_image']) && $_FILES['claim_image']['error'] === UPLOAD_ERR_OK) {
                $targetDir = __DIR__ . '/../../../public/pictures/claims/';
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
                
                $fileName = time() . '_' . basename($_FILES['claim_image']['name']);
                $targetFile = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['claim_image']['tmp_name'], $targetFile)) {
                    $imageUrl = 'pictures/claims/' . $fileName;
                }
            }

            try {
                if ($this->warrantyModel->submitClaim($warrantyId, $description, $imageUrl)) {
                    $_SESSION['success_message'] = "Your warranty claim has been submitted successfully.";
                } else {
                    $_SESSION['error_message'] = "Failed to submit warranty claim.";
                }
            } catch (Exception $e) {
                $_SESSION['error_message'] = "An error occurred while submitting your claim: " . $e->getMessage();
            }

            header('Location: ' . url('my_warranties'));
            exit;
        }
    }
}

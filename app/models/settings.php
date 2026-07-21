<?php
require_once __DIR__ . '/../../config/database.php';

class Settings {
    private $conn;

    public function __construct($conn = null) {
        if ($conn !== null) {
            $this->conn = $conn;
        } else {
            $database = new Database();
            $this->conn = $database->connect();
        }
    }

    // Fetch website settings
    public function getWebSettings($id = 1) {
        $stmt = $this->conn->prepare("SELECT * FROM web_settings WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $settings = $result->fetch_assoc();

        $stmt->close();
        return $settings;
    }
}

class Banner {

    private $conn;

    public function __construct($conn = null)
    {
        if ($conn !== null) {
            $this->conn = $conn;
        } else {
            $database = new Database();
            $this->conn = $database->connect();
        }
    }

    public function getAllBanners()
    {
        $stmt = $this->conn->prepare("SELECT * FROM banners");
        $stmt->execute();
        $result = $stmt->get_result();

        $banners = [];
        while($row = $result->fetch_assoc()){
            $banners[] = $row;
        }

        return $banners;
    }
      // Fetch single banner
    public function getBannerById($id){
        $stmt = $this->conn->prepare("SELECT * FROM banners WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function addbanner($alt,$text,$file)
    {
        $targetDir = BASE_PATH."/public/uploads/banners/";

        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $cleanAlt = preg_replace('/[^a-zA-Z0-9_-]/','_',$alt);

        $fileName = $cleanAlt.".".$fileExt;

        $uploadPath = $targetDir.$fileName;
        $dbPath = "uploads/banners/".$fileName;

        move_uploaded_file($file['tmp_name'],$uploadPath);

        $stmt = $this->conn->prepare(
        "INSERT INTO banners (alt,image_url,text) VALUES (?,?,?)"
        );

        $stmt->bind_param("sss",$cleanAlt,$dbPath,$text);
        $stmt->execute();

        return true;
    }
    public function deleteBanner($id)
{
    // Get banner first (to remove image file too)
    $banner = $this->getBannerById($id);

    if ($banner) {
        $filePath = BASE_PATH . "/public/" . $banner['image_url'];

        if (file_exists($filePath)) {
            unlink($filePath); // delete image from folder
        }
    }

    // Delete from database
    $stmt = $this->conn->prepare("DELETE FROM banners WHERE id = ?");
    $stmt->bind_param("i", $id);

    return $stmt->execute();
}
public function updateBanner($id, $alt, $text, $file)
{
    $banner = $this->getBannerById($id);

    $imagePath = $banner['image_url'];

    if (isset($file['name']) && $file['name'] != "") {

        $targetDir = BASE_PATH . "/public/uploads/banners/";

        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $cleanAlt = preg_replace('/[^a-zA-Z0-9_-]/','_',$alt);

        $fileName = $cleanAlt . "." . $fileExt;

        $uploadPath = $targetDir . $fileName;
        $dbPath = "uploads/banners/" . $fileName;

        // delete old image
        if ($banner && file_exists(BASE_PATH . "/public/" . $banner['image_url'])) {
            unlink(BASE_PATH . "/public/" . $banner['image_url']);
        }

        move_uploaded_file($file['tmp_name'], $uploadPath);

        $imagePath = $dbPath;
    }

    $stmt = $this->conn->prepare(
        "UPDATE banners SET alt=?, text=?, image_url=? WHERE id=?"
    );

    $stmt->bind_param("sssi", $alt, $text, $imagePath, $id);

    return $stmt->execute();
}
}


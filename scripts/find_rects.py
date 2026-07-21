import cv2
import numpy as np

def get_black_rect_percentages(image_path):
    img = cv2.imread(image_path)
    if img is None:
        return "Image not found"
    
    h, w = img.shape[:2]
    
    # Convert to grayscale
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    
    # Threshold for black pixels
    _, thresh = cv2.threshold(gray, 10, 255, cv2.THRESH_BINARY_INV)
    
    # Find contours
    contours, _ = cv2.findContours(thresh, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    
    # Find the largest contour that looks like a rectangle (excluding the whole image border if any)
    best_rect = None
    max_area = 0
    for cnt in contours:
        x, y, w_rect, h_rect = cv2.boundingRect(cnt)
        area = w_rect * h_rect
        if area > 100 and area < (w * h * 0.5): # reasonable size, not too small, not the whole image
            # check if it's mostly solid black
            roi = gray[y:y+h_rect, x:x+w_rect]
            if np.mean(roi) < 10: # very dark
                if area > max_area:
                    max_area = area
                    best_rect = (x, y, w_rect, h_rect)
                    
    if best_rect:
        x, y, w_rect, h_rect = best_rect
        return {
            "left": (x / w) * 100,
            "top": (y / h) * 100,
            "width": (w_rect / w) * 100,
            "height": (h_rect / h) * 100
        }
    return "No black rectangle found"

files = [
    "public/pictures/design/Label on the back.png",
    "public/pictures/design/Label on the back p1.png",
    "public/pictures/design/Inseam loop label.png",
    "public/pictures/design/Inseam loop label p1.png"
]

for f in files:
    print(f"{f}: {get_black_rect_percentages(f)}")

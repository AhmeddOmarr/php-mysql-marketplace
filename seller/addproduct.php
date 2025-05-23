<?php include 'check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Product | Seller Portal</title>
  <link rel="icon" href="../favicon.ico">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #213555;
      --dark: #001f3f;  /* Changed to dark navy blue */
      --light: #D8C4B6;
      --gray: #6b7280;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: rgb(138, 168, 207);
      min-height: 100vh;
      padding: 2rem;
    }

    .container {
      max-width: 700px;
      margin: 0 auto;
    }

    .back-btn {
      display: inline-flex;
      align-items: center;
      color: var(--gray);
      text-decoration: none;
      margin-bottom: 1.5rem;
      transition: all 0.3s ease;
    }

    .back-btn:hover {
      color: var(--primary);
      transform: translateX(-3px);
    }

    .back-btn i {
      margin-right: 8px;
    }

    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
    }

    .card-header {
      background: linear-gradient(90deg, var(--primary), var(--dark));
      color: white;
      padding: 1.2rem;
      text-align: center;
    }

    .card-header h4 {
      font-weight: 600;
      font-size: 1.4rem;
    }

    .card-body {
      padding: 1.5rem;
    }

    .form-group {
      margin-bottom: 1.25rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: var(--gray);
    }

    .form-control {
      width: 100%;
      padding: 10px 14px;
      border: 2px solid #e5e7eb;
      border-radius: 6px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(33, 53, 85, 0.1);
      outline: none;
    }

    textarea.form-control {
      min-height: 100px;
      resize: vertical;
    }

    .custom-file {
      position: relative;
      margin-bottom: 1.25rem;
    }

    .custom-file-input {
      position: absolute;
      opacity: 0;
      width: 0.1px;
      height: 0.1px;
    }

    .custom-file-label {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 14px;
      border: 2px dashed #e5e7eb;
      border-radius: 6px;
      background: #f9fafb;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .custom-file-label:hover {
      border-color: var(--primary);
      background: rgba(33, 53, 85, 0.05);
    }

    .custom-file-label i {
      color: var(--primary);
      font-size: 1.2rem;
    }

    .submit-btn {
      background: linear-gradient(90deg, var(--dark), #000c1a); /* Darker navy blue gradient */
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 6px;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      width: 100%;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .submit-btn:hover {
      background: linear-gradient(90deg, #003366, #001f3f);  /* Lighter navy blue gradient on hover*/
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .submit-btn:active {
      transform: translateY(0);
    }

    .price-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
    }

    @media (max-width: 768px) {
      .price-row {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="index.php" class="back-btn">  <i class="fas fa-arrow-left"></i> Back to My Products  </a>

    <div class="card">
      <div class="card-header">
        <h4>List your Product</h4>
      </div>
      <div class="card-body">
        <form action="add_product.php" method="POST" enctype="multipart/form-data" onsubmit="return checkFilesCount()">
          <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required maxlength="30" placeholder="Enter product name">
          </div>

          <div class="form-group">
            <label for="category_id">Product Category</label>
            <select class="form-control" id="category_id" name="category_id" required>
              <?php
              $categories = $query->getCategories();
              foreach ($categories as $id => $category_name) {
                echo "<option value='" . $id . "'>" . $category_name . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="price-row">
            <div class="form-group">
              <label for="price_old">Original Price</label>
              <input type="number" class="form-control" id="price_old" name="price_old" required max="99999999999" placeholder="0.00">
            </div>

            <div class="form-group">
              <label for="price_current">Current Price</label>
              <input type="number" class="form-control" id="price_current" name="price_current" max="99999999999" placeholder="0.00">
            </div>
          </div>

          <div class="form-group">
            <label for="description">Product Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required maxlength="2000" placeholder="Describe your product..."></textarea>
          </div>

          <div class="form-group">
            <label>Product Images (Max 7)</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="image" name="image[]" accept="image/*" multiple>
              <label class="custom-file-label" for="image" id="fileLabel">
                <span><i class="fas fa-cloud-upload-alt"></i> Click to upload images</span>
                <span id="fileCount">0 files selected</span>
              </label>
            </div>
          </div>

          

          <button type="submit" class="submit-btn">
            <i class="fas fa-save"></i> Save Product
          </button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function checkFilesCount() {
      const files = document.getElementById('image').files;
      if (files.length > 7) {
        alert("You can only upload up to 7 images.");
        return false;
      }
      return true;
    }

    document.getElementById('image').addEventListener('change', function() {
      const files = this.files;
      const fileCount = document.getElementById('fileCount');
      
      fileCount.textContent = files.length === 0
        ? '0 files selected'
        : files.length === 1
        ? '1 file selected'
        : `${files.length} files selected`;
    });
  </script>
</body>
</html>

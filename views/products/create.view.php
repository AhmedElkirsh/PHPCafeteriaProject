<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <h1 class="text-center">Add Product</h1>
    <form action="/storePage" method="post" class="w-50 m-auto" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product" class="form-label">product name</label>
            <input type="text" class="form-control" id="product" placeholder="product name" name="product">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">price</label>
            <input type="number" class="form-control" id="price" placeholder="price" name="price">
        </div>

        <div class="mb-3">
            <label for="picture" class="form-label">product image</label>
            <input type="file" class="form-control" id="picture" name="image">
        </div>

        <label for="category">select category</label><br>
        <select class="form-select w-50 d-inline" id="category" name="category">
            <!-- <option selected value="sof drinks">soft drinks</option> -->
            <?php 
                foreach($result as $option)
                {
                    echo "<option value=" . $option["categoryname"] . ">" . $option["categoryname"] . "</option>";
                }   
            ?>
        </select>
        <a href="/createCategory" class="d-inline-block w-25">Add new category</a>

        <div class="mb-3 mt-3">
            <label for="time" class="form-label">product time</label>
            <input type="number" class="form-control" id="time" name="time">
        </div>
        
        <div class="mb-3 mt-3">
            <label for="status" class="form-label">product status</label>
            <input type="text" class="form-control" id="status" name="status">
        </div>
        
        <input type="submit" value="save" name="saveData" class="btn btn-primary w-25">
        <input type="reset" value="reset" class="btn btn-success w-25">
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
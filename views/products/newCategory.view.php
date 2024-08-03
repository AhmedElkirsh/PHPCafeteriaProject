<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <form action="/storePage" method="post" class="w-50 m-auto">
        <div class="mb-3">
            <label for="addedCategory" class="form-label text-center d-block">Enter new category</label>
            <input type="text" class="form-control" id="addedCategory" name="addedCategory">
        </div>

        <input type="submit" value="Add" name="newCategory" class="btn btn-primary">
        <a href="/createProduct" class="btn btn-danger">cancel</a>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
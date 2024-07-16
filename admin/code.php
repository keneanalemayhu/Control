<?php

include('../config/dbcon.php');
include('../functions/myfunction.php');

if (isset($_POST['add_category_btn'])) {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';

    $image = $_FILES['image']['name'];

    $path = "../uploads/category_pics";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . "." . $image_ext;

    $query = "INSERT INTO categories
    (name,slug,description,meta_title,meta_description,meta_keywords,status,popular,image) 
    VALUES('$name','$slug','$description','$meta_title','$meta_description','$meta_keywords','$status','$popular','$filename')";

    $cate_query_run = mysqli_query($con, $query);

    if ($cate_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
        redirect("category.php", "Category Added Successfully.");
    } else {
        redirect("add-category.php", "Something went wrong.");
    }
} else if (isset($_POST['update_category_btn'])) {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';

    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . "." . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    $path = "../uploads/category_pics";

    $update_query = "UPDATE categories SET name='$name', slug='$slug', description='$description', 
    meta_title='$meta_title', meta_description='$meta_description', meta_keywords='$meta_keywords',
    status='$status', popular='$popular', image='$update_filename' WHERE id='$category_id' ";

    $update_query_run = mysqli_query($con, $update_query);

    if ($update_query_run) {
        if ($new_image != "") {
            move_uploaded_file($_FILES["image"]["tmp_name"], $path . '/' . $update_filename);
            if (file_exists($path . '/' . $old_image)) {
                unlink($path . '/' . $old_image);
            }
        }
        redirect("category.php", "Category Updated Successfully!");
    } else {
        redirect("edit-category.php?id=$category_id", "Something went wrong");
    }
} else if (isset($_POST['delete_category_btn'])) {
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);

    $category_query = "SELECT * FROM categories WHERE id='$category_id' ";
    $category_query_run = mysqli_query($con, $category_query);
    $category_data = mysqli_fetch_array($category_query_run);
    $image = $category_data['image'];

    $delete_query = "DELETE FROM categories WHERE id='$category_id' ";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        $path = "../uploads/category_pics";
        if (file_exists($path . '/' . $image)) {
            unlink($path . '/' . $image);
        }
        // redirect("category.php", "Category Deleted Successfully!");
        echo 200;
    } else {
        // redirect("category.php", "Something went wrong");
        echo 500;
    }
} else if (isset($_POST['add_product_btn'])) {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $qty = $_POST['qty'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';

    $image = $_FILES['image']['name'];

    $path = "../uploads/product_pics";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . "." . $image_ext;

    if ($name != "" && $slug != "" && $description != "") {
        $product_query = "INSERT INTO products(category_id, name, slug, small_description, description, original_price, selling_price, qty, meta_title, meta_description, meta_keywords, status, trending, image) 
        VALUES ('$category_id', '$name', '$slug', '$small_description', '$description', '$original_price', '$selling_price', '$qty', '$meta_title', '$meta_description', '$meta_keywords', '$status', '$trending', '$filename')";

        $product_query_run = mysqli_query($con, $product_query);

        if ($product_query_run) {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
            redirect("products.php", "Product Added Successfully.");
        } else {
            redirect("add-product.php", "Something went wrong");
        }
    } else {
        redirect("add-product.php", "All fields are required");
    }
} else if (isset($_POST["update_product_btn"])) {
    $product_id = $_POST['product_id'];
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $small_description = $_POST['small_description'];
    $description = $_POST['description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $qty = $_POST['qty'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';

    $path = "../uploads/product_pics";

    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . "." . $image_ext;
    } else {
        $update_filename = $old_image;
    }

    // Using prepared statements to avoid SQL syntax errors and SQL injection
    $stmt = $con->prepare("UPDATE products SET 
        category_id=?, 
        name=?, 
        slug=?, 
        small_description=?, 
        description=?, 
        original_price=?, 
        selling_price=?, 
        qty=?, 
        meta_title=?, 
        meta_description=?, 
        meta_keywords=?, 
        status=?, 
        trending=?, 
        image=? 
        WHERE id=?");

    $stmt->bind_param(
        "issssdissssissi",
        $category_id,
        $name,
        $slug,
        $small_description,
        $description,
        $original_price,
        $selling_price,
        $qty,
        $meta_title,
        $meta_description,
        $meta_keywords,
        $status,
        $trending,
        $update_filename,
        $product_id
    );

    if ($stmt->execute()) {
        if ($new_image != "") {
            move_uploaded_file($_FILES["image"]["tmp_name"], $path . '/' . $update_filename);
            if (file_exists($path . '/' . $old_image)) {
                unlink($path . '/' . $old_image);
            }
        }
        redirect("products.php", "Product Updated Successfully!");
    } else {
        redirect("edit-product.php?id=$product_id", "Something went wrong");
    }

    $stmt->close();
} else if (isset($_POST['delete_product_btn'])) {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);

    $product_query = "SELECT * FROM products WHERE id='$product_id' ";
    $product_query_run = mysqli_query($con, $product_query);
    $product_data = mysqli_fetch_array($product_query_run);
    $image = $product_data['image'];

    $delete_query = "DELETE FROM products WHERE id='$product_id' ";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        $path = "../uploads/product_pics";
        if (file_exists($path . '/' . $image)) {
            unlink($path . '/' . $image);
        }
        echo 200;
    } else {
        echo 500;
    }
} else {
    header('Location:../index.php');
}

<?php
$action = $_REQUEST['action'];

require_once __DIR__ . '/models/User.php';

if ($action === 'register') {
    $errors = $response = [];

    $name     = addslashes($_POST['name'] ?? '');
    $email    = addslashes(trim($_POST['email'] ?? ''));
    $password = addslashes($_POST['password'] ?? '');
    $profileImageName = null;

    if (!$name || !$email || !$password) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $existingUsers = User::where('email', $email);
        if (!empty($existingUsers)) {
            $errors[] = "Email is already registered.";
        }
    }

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['profile_image']['tmp_name'];
        $originalName = basename($_FILES['profile_image']['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext, $allowedExts)) {
            $errors[] = "Invalid file type.";
        } else {
            $profileImageName = uniqid('img_', true) . '.' . $ext;
            $uploadPath = __DIR__ . "/uploads/";
            $fullPath = $uploadPath . $profileImageName;

            if (!mkdir($uploadPath, 0777, true) && !is_dir($uploadPath)) {
                $errors[] = "Upload folder creation failed.";
            }

            if (empty($errors)) {
                if (!move_uploaded_file($tmpName, $fullPath)) {
                    $errors[] = "Image upload failed.";
                } else {
                    chmod($fullPath, 0777);
                }
            }
        }
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'profile_image' => $profileImageName
        ]);

        echo json_encode(['success' => true, 'image' => $profileImageName], JSON_THROW_ON_ERROR);
        exit;
    }

    echo json_encode(['success' => false, 'errors' => $errors], JSON_THROW_ON_ERROR);
    exit;
}

if ($action === 'login') {
    $errors = $response = [];

    $email = addslashes(trim($_POST['email'] ?? ''));
    $password = addslashes($_POST['password'] ?? '');

    if (!$email || !$password) {
        $errors[] = "Email and password are required.";
    }

    if (empty($errors)) {
        $user = User::where('email', $email)[0] ?? null;
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            echo json_encode(['success' => true], JSON_THROW_ON_ERROR);
            exit;
        }

        $errors[] = "Invalid email or password.";
    }

    echo json_encode(['success' => false, 'errors' => $errors], JSON_THROW_ON_ERROR);
    exit;
}



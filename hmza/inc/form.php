<?php

$errors = [
    'firstNameError' => '',
    'lastNameError'  => '',
    'emailError'     => ''
];


if (isset($_POST['submit'])) {

    // أخذ البيانات من الفورم
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName  = trim($_POST['lastName'] ?? '');
    $email     = trim($_POST['email'] ?? '');


    // التحقق من الاسم الأول
    if (empty($firstName)) {

        $errors['firstNameError'] = 'يرجى إدخال الاسم الأول';

    }


    // التحقق من الاسم الثاني
    if (empty($lastName)) {

        $errors['lastNameError'] = 'يرجى إدخال الاسم الثاني';

    }


    // التحقق من البريد الإلكتروني
    if (empty($email)) {

        $errors['emailError'] = 'يرجى إدخال البريد الإلكتروني';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errors['emailError'] = 'يرجى إدخال بريد إلكتروني صحيح';

    }


    // التأكد من عدم وجود أخطاء
    if (
        empty($errors['firstNameError']) &&
        empty($errors['lastNameError']) &&
        empty($errors['emailError'])
    ) {


        // استخدام Prepared Statement
        $sql = "INSERT INTO users (firstName, lastName, email)
                VALUES (?, ?, ?)";


        $stmt = mysqli_prepare($conn, $sql);


        if ($stmt) {

            mysqli_stmt_bind_param(
                $stmt,
                "sss",
                $firstName,
                $lastName,
                $email
            );


            if (mysqli_stmt_execute($stmt)) {

                // بعد التسجيل يرجع للصفحة
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;

            } else {

                echo 'حدث خطأ أثناء التسجيل: '
                    . htmlspecialchars(mysqli_stmt_error($stmt));

            }


            mysqli_stmt_close($stmt);

        } else {

            echo 'حدث خطأ في تجهيز الاستعلام: '
                . htmlspecialchars(mysqli_error($conn));

        }

    }

}

?>
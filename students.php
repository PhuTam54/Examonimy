<?php
$sv = [
    "full name" => "Tran Thi Thuy",
    "age" => 19,
    "email" => "tranthithuy@gmail.com"
];

$list = [
    [
        "full name" => "Tran Thi Thuy",
        "age" => 19,
        "email" => "tranthithuy@gmail.com"
    ],
    [
        "full name" => "Nguyen Phu Tam",
        "age" => 19,
        "email" => "nguyenphutam@gmail.com"
    ]
];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clifford: '#da373d',
                    }
                }
            }
        }
    </script>
</head>
<body>
<h1 class="text-3xl font-bold text-clifford">Student list</h1>

<h2>Student name: <?php echo $sv["full name"]; ?></h2>
<h2>Student age: <?php echo $sv["age"]; ?></h2>
<?php if ($sv["age"] == 19): ?>
    <h3>Sinh vien vua nhap hoc</h3>
    <h3>Sinh vien vua nhap hoc</h3>
    <h3>Sinh vien vua nhap hoc</h3>
    <h3>Sinh vien vua nhap hoc</h3>
<?php endif;
?>

<ul>
    <?php foreach ($list as $item): ?>
        <li><?php echo $item["full name"]." - ".$item["age"];?></li>
    <?php endforeach; ?>
</ul>

</body>
</html>
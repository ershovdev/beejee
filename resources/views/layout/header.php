<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- Some Font Awesome Icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Tasker!</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/tasks">Tasker</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/tasks/add">Add</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (\App\Models\Auth::isLoggedIn($cookieId, $cookieHash)): ?>
                    <li class="nav-item active">
                        <a class="nav-link">Hi, Admin!</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="/signIn">Sign In</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="container mt-4">
    <?php if ($success): ?>
        <div class="alert-success m-2 p-2">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <?php if (count($errors) > 0): ?>
        <?php foreach ($errors as $error): ?>
            <div class="alert-danger mb-2 p-2"><?php echo $error; ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

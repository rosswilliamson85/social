
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    
    <title>Im social</title>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Im Social</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
            <a class="nav-link" href="/"> home </a>
        </li>
        <?php if(!$session->has('username')): ?>
        <li class="nav-item">
            <a class="nav-link" href="/login"> login </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/register"> Register </a>
        </li>
       <?php endif; ?>
        <?php if($session->has('username')):  ?>
        <li class="nav-item">
            <a class="nav-link" href="/profile/<?php echo $session->get('username')  ?>"> profile </a>
        </li>

        
        <li class="nav-item">
            <a class="nav-link" href="/logout"> sign out </a>
        </li>

        <?php endif; ?>
    
      </ul>
      <form class="search-form" class="d-flex" role="search">
         
        <input class="form-control me-auto" type="search" id="search" placeholder="Search" aria-label="Search">
        
      </form>
   
      <input type="hidden" id="form_token" value="<?php echo $session->get('token') ?>">
   
    </div>
 
  </div>
 
</nav>

<div id="search_results"></div>



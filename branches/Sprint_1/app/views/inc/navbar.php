<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <div class="container">
      <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav ml-auto">

              <?php if(isset($_SESSION['userId'])) : ?>
                  <li class="nav-item">
                      <a class="nav-link active" >Ciao, <?php echo $_SESSION['userFirstName']; ?>!</a>
                  </li>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Profilo</a>
                      <div class="dropdown-menu">
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/users/myProfile">Visualizza Profilo</a>
                          <a class="dropdown-item" href="#">Modifica Profilo</a>
                      </div>
                  </li>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Idee</a>
                      <div class="dropdown-menu">
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/ideas/myIdeas">Mie idee</a>
                          <a class="dropdown-item" href="<?php echo URLROOT; ?>/ideas/newIdea">Nuova Idea</a>
                      </div>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                  </li>
              <?php else : ?>
                  <li class="nav-item">
                      <a class="nav-link" href="<?php echo URLROOT; ?>/users/signUp">Sign Up</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Login</a>
                  </li>
              <?php endif; ?>

          </ul>
      </div>
    </div>
  </nav>
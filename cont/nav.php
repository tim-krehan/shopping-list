<nav class="navbar navbar-expand-sm navbar-dark bg-dark rounded-bottom fixed-top">
  <a class="navbar-brand" href="/">
    <i class="fas fa-check-square w-auto"></i>
    ShoppingList
  </a>

  <button class="navbar-toggler float-right" type="button" data-toggle="collapse" data-target="#navbarToggleResponsive" aria-controls="navbarToggleResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars"></i>
  </button>
  
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php if($site=="list"){print_r("active");} ?>">
        <a class="nav-link" href="/list">Liste</a>
      </li>
      <li class="nav-item <?php if($site=="recipes"){print_r("active");} ?>">
        <a class="nav-link" href="/recipes">Rezepte</a>
      </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item <?php if($site=="settings"){print_r("active");} ?>">
        <a class="nav-link" href="/settings"><i class="fas fa-user-cog"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/php/logout.php"><i class="fas fa-sign-out-alt"></i></a>
      </li>
    </ul>
  </div>


  <div class="collapse w-75 pl-2" id="navbarToggleResponsive">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php if($site=="list"){print_r("active");} ?>">
        <a class="nav-link" href="/list"><i class="fas fa-list"></i> Liste</a>
      </li>
      <li class="nav-item <?php if($site=="recipes"){print_r("active");} ?>">
        <a class="nav-link" href="/recipes"><i class="fas fa-book"></i> Rezepte</a>
      </li>
      <li class="nav-item <?php if($site=="settings"){print_r("active");} ?>">
        <a class="nav-link" href="/settings"><i class="fas fa-user-cog"></i> Einstellungen</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/php/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
    </ul>
  </div>
</nav>
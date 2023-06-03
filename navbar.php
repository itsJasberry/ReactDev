<?php
print("

  <nav>
      <div class='links'>
        <ul id='leftLinks'>
          <li><a href='tabela.php'>Home</a></li>
          <li id='packageHover'>
            <a href='sendPackage.html'>Send Package</a>
            <div id='dropDown'>
              <ul>
                <li><a href='#small'>Small</a></li>
                <li><a href='#medium'>Medium</a></li>
              </ul>
            </div>
          </li>
          <li id='packageHover2'>
            <a href='#prices'>Prices</a>
            <div id='dropDown2'>
              <ul>
                <li><a href='#send'>For sending</a></li>
                <li><a href='#pick'>For picking up</a></li>
              </ul>
            </div>
          </li>
        </ul>
        <ul id='rightLinks'>
          <li><a href='logowanie_formularz.php'>Log in</a></li>
          <li><a href='register.html'>Register</a></li>
        </ul>
      </div>
    </nav>


    <div class='sidebar'>
      <div class='hamburger'>
        <div class='bar1'></div>
        <div class='bar2'></div>
        <div class='bar3'></div>
      </div>
      <div class='user'>
            <div id='img'></div>
            <p class='bold'>Jasberry</p>
            <p>Admin</p>
      </div>
      <ul>
        <li>
          <a href='#'>
            <i class='bx bxs-grid-alt'></i>
            <span class='nav-item'>Dashboard</span>
            <span class='tooltip'>Dashboard</span>
          </a>

        </li>
        <li>
          <a href='#'>
            <i class='bx bxs-shopping-bag'></i>
            <span class='nav-item'>Products</span>
            <span class='tooltip'>Products</span>

          </a>
        </li>
        <li>
          <a href='#'>
            <i class='bx bx-list-check'></i>
            <span class='nav-item'>Categories</span>
            <span class='tooltip'>Categories</span>
          </a>
        </li>
        <li>
          <a href='#'>
            <i class='bx bxs-food-menu'></i>
            <span class='nav-item'>Orders</span>
            <span class='tooltip'>Orders</span>
          </a>
        </li>
        <li>
          <a href='#'>
            <i class='bx bx-body'></i>
            <span class='nav-item'>Customers</span>
            <span class='tooltip'>Customers</span>
          </a>
        </li>
        <li>
          <a href='#'>
            <i class='bx bx-location-plus'></i>
            <span class='nav-item'>Shipping</span>
            <span class='tooltip'>Shipping</span>
          </a>
        </li>
        <li>
          <a href='#'>
            <i class='bx bx-cog'></i>
            <span class='nav-item'>Settings</span>
            <span class='tooltip'>Settings</span>
          </a>
        </li>
      </ul>
    </div>
")
?>
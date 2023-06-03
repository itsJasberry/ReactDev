const hamburger = document.querySelector('.hamburger');
const sidebar = document.querySelector('.sidebar');
const bar1 = document.querySelector(".bar1");
const bar2 = document.querySelector(".bar2");
const bar3 = document.querySelector(".bar3");
const mobileNav = document.querySelector(".mobileNav");

hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    bar1.classList.toggle("animateBar1");
    bar2.classList.toggle("animateBar2");
    bar3.classList.toggle("animateBar3");
    mobileNav.classList.toggle("openDrawer");
});


// ukrywanie formularza
const loginBox = document.querySelector(".login-box");
const toggleFormBtn = document.getElementById("toggleFormBtn");

toggleFormBtn.addEventListener("click", function() {
    if (loginBox.style.display === "none") {
        loginBox.style.display = "block";
        toggleFormBtn.textContent = "Schowaj formularz";
    } else {
        loginBox.style.display = "none";
        toggleFormBtn.textContent = "Dodaj pracownika";
    }
});


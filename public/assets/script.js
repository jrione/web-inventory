document.getElementById('navbarToggle').addEventListener('click', function() {
    var navbarMenu = document.getElementById('navbarLinks');
    if (navbarMenu.classList.contains('active')) {
        navbarMenu.classList.remove('active');
    } else {
        navbarMenu.classList.add('active');
    }
});
<script>

    const toggleBtn = document.getElementById('menu-toggle-button'),
        navMenu = document.getElementById('nav-menu'),
        toggleBtnBurger = document.getElementById('menu-toggle-btn-burger'),
        toggleBtnX = document.getElementById('menu-toggle-btn-x');

    toggleBtn.addEventListener('click', function () {
        navMenu.classList.toggle('hidden');
        toggleBtnBurger.classList.toggle('hidden');
        toggleBtnX.classList.toggle('hidden');
    })

</script>
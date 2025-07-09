import "./bootstrap"; // Livewire v3 sudah include Alpine secara otomatis

// ===========================
// SIDEMENU FUNCTIONALITY
// ===========================
document.addEventListener("DOMContentLoaded", () => {
    const menuBtn = document.getElementById("menu-btn");
    const closeBtn = document.getElementById("close-btn");
    const sideMenu = document.getElementById("side-menu");
    const menuOverlay = document.getElementById("menu-overlay");

    const openMenu = () => {
        sideMenu?.classList.remove("-translate-x-full");
        menuOverlay?.classList.remove("hidden");
        menuBtn?.setAttribute("aria-expanded", "true");
    };

    const closeMenu = () => {
        sideMenu?.classList.add("-translate-x-full");
        menuOverlay?.classList.add("hidden");
        menuBtn?.setAttribute("aria-expanded", "false");
    };

    menuBtn?.addEventListener("click", (e) => {
        e.stopPropagation();
        openMenu();
    });

    closeBtn?.addEventListener("click", (e) => {
        e.stopPropagation();
        closeMenu();
    });

    menuOverlay?.addEventListener("click", closeMenu);

    document.addEventListener("keydown", (e) => {
        if (
            e.key === "Escape" &&
            !sideMenu?.classList.contains("-translate-x-full")
        ) {
            closeMenu();
        }
    });
});

// ===========================
// SCROLL ANIMATION
// ===========================
document.addEventListener("DOMContentLoaded", () => {
    const scrollElements = document.querySelectorAll(".animate-on-scroll");

    const elementInView = (el, dividend = 1) =>
        el.getBoundingClientRect().top <=
        (window.innerHeight || document.documentElement.clientHeight) /
            dividend;

    const displayScrollElement = (el) => el.classList.add("scrolled");

    const handleScrollAnimation = () => {
        scrollElements.forEach((el) => {
            if (elementInView(el, 1.25)) {
                displayScrollElement(el);
            }
        });
    };

    handleScrollAnimation(); // On load
    window.addEventListener("scroll", handleScrollAnimation);
});

// ===========================
// PASSWORD VISIBILITY TOGGLE
// ===========================
document.addEventListener("DOMContentLoaded", () => {
    const passwordInput = document.getElementById("password");
    const passwordToggle = document.getElementById("password-toggle");
    const eyeOpen = document.getElementById("eye-open");
    const eyeClosed = document.getElementById("eye-closed");

    if (passwordInput && passwordToggle && eyeOpen && eyeClosed) {
        passwordToggle.addEventListener("click", () => {
            const isPassword = passwordInput.type === "password";
            passwordInput.type = isPassword ? "text" : "password";
            eyeOpen.classList.toggle("hidden", !isPassword);
            eyeClosed.classList.toggle("hidden", isPassword);
        });
    }
});

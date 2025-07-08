import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Kode untuk fungsionalitas menu samping
document.addEventListener("DOMContentLoaded", () => {
    const menuBtn = document.getElementById("menu-btn");
    const closeBtn = document.getElementById("close-btn");
    const sideMenu = document.getElementById("side-menu");
    const menuOverlay = document.getElementById("menu-overlay");

    const openMenu = () => {
        sideMenu.classList.remove("-translate-x-full");
        menuOverlay.classList.remove("hidden");
        menuBtn.setAttribute("aria-expanded", "true");
    };

    const closeMenu = () => {
        sideMenu.classList.add("-translate-x-full");
        menuOverlay.classList.add("hidden");
        menuBtn.setAttribute("aria-expanded", "false");
    };

    if (menuBtn && sideMenu && closeBtn && menuOverlay) {
        menuBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            openMenu();
        });

        closeBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            closeMenu();
        });

        menuOverlay.addEventListener("click", () => {
            closeMenu();
        });

        // Menutup menu saat menekan tombol Escape
        document.addEventListener("keydown", (e) => {
            if (
                e.key === "Escape" &&
                !sideMenu.classList.contains("-translate-x-full")
            ) {
                closeMenu();
            }
        });
    }
});

// [BARU] Kode untuk animasi saat scroll
document.addEventListener("DOMContentLoaded", () => {
    // ... (kode menu di dalam event listener ini tetap ada) ...

    const scrollElements = document.querySelectorAll(".animate-on-scroll");

    const elementInView = (el, dividend = 1) => {
        const elementTop = el.getBoundingClientRect().top;
        return (
            elementTop <=
            (window.innerHeight || document.documentElement.clientHeight) /
                dividend
        );
    };

    const displayScrollElement = (element) => {
        element.classList.add("scrolled");
    };

    const hideScrollElement = (element) => {
        element.classList.remove("scrolled");
    };

    const handleScrollAnimation = () => {
        scrollElements.forEach((el) => {
            if (elementInView(el, 1.25)) {
                displayScrollElement(el);
            }
            // Opsional: hapus komentar di bawah jika ingin animasi berulang saat scroll ke atas
            // else {
            //     hideScrollElement(el);
            // }
        });
    };

    // Panggil sekali saat load untuk elemen yang sudah terlihat
    handleScrollAnimation();

    window.addEventListener("scroll", () => {
        handleScrollAnimation();
    });

    const passwordInput = document.getElementById("password");
    const passwordToggle = document.getElementById("password-toggle");
    const eyeOpen = document.getElementById("eye-open");
    const eyeClosed = document.getElementById("eye-closed");

    if (passwordInput && passwordToggle && eyeOpen && eyeClosed) {
        passwordToggle.addEventListener("click", () => {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeOpen.classList.add("hidden");
                eyeClosed.classList.remove("hidden");
            } else {
                passwordInput.type = "password";
                eyeOpen.classList.remove("hidden");
                eyeClosed.classList.add("hidden");
            }
        });
    }
});

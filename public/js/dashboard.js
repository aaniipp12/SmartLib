// Dashboard JavaScript
document.addEventListener("DOMContentLoaded", () => {
    // Sidebar toggle functionality
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");

    if (sidebarToggle) {
        sidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("collapsed");
            mainContent.classList.toggle("expanded");
        });
    }

    // Mobile sidebar toggle
    const mobileSidebarToggle = document.getElementById("mobileSidebarToggle");
    if (mobileSidebarToggle) {
        mobileSidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("show");
        });
    }

    // Close sidebar on mobile when clicking outside
    document.addEventListener("click", (e) => {
        if (window.innerWidth <= 768) {
            if (
                !sidebar.contains(e.target) &&
                !mobileSidebarToggle.contains(e.target)
            ) {
                sidebar.classList.remove("show");
            }
        }
    });

    // Active menu highlighting
    const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll(".menu-link");

    menuLinks.forEach((link) => {
        if (link.getAttribute("href") === currentPath) {
            link.classList.add("active");
        }
    });

    // Smooth animations for stats cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            }
        });
    }, observerOptions);

    // Observe all animated elements
    document
        .querySelectorAll(".stats-card, .chart-card, .profile-card")
        .forEach((el) => {
            observer.observe(el);
        });

    // Auto-dismiss alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll(".alert");
        alerts.forEach((alert) => {
            alert.style.opacity = "0";
            alert.style.transform = "translateY(-20px)";
            setTimeout(() => alert.remove(), 300);
        });
    }, 5000);
});

// Utility functions
function formatNumber(num) {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + "M";
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + "K";
    }
    return num.toString();
}

function animateCounter(element, target, duration = 2000) {
    let start = 0;
    const increment = target / (duration / 16);

    const timer = setInterval(() => {
        start += increment;
        element.textContent = Math.floor(start);

        if (start >= target) {
            element.textContent = target;
            clearInterval(timer);
        }
    }, 16);
}

// Initialize counter animations when page loads
window.addEventListener("load", () => {
    const counters = document.querySelectorAll(".stats-number");
    counters.forEach((counter) => {
        const target = Number.parseInt(counter.textContent);
        counter.textContent = "0";
        setTimeout(() => animateCounter(counter, target), 500);
    });
});

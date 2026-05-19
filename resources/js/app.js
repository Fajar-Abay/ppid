import AOS from 'aos';
import 'aos/dist/aos.css';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Dynamic Auto-AOS Injection for ALL Pages
    
    // Page headers & breadcrumbs
    const headers = document.querySelectorAll('.bg-institutional-900, .mb-12.border-b, nav[aria-label="Breadcrumb"]');
    headers.forEach((el, idx) => {
        if (!el.hasAttribute('data-aos') && !el.closest('footer')) {
            el.setAttribute('data-aos', 'fade-up');
            el.setAttribute('data-aos-duration', '800');
        }
    });

    // Left sidebars in details pages
    const sidebars = document.querySelectorAll('.sticky.top-28, .sticky.top-24');
    sidebars.forEach(el => {
        if (!el.hasAttribute('data-aos')) {
            el.setAttribute('data-aos', 'fade-right');
            el.setAttribute('data-aos-duration', '800');
        }
    });

    // Layout sections, article blocks, lists, and main forms
    const contentBlocks = document.querySelectorAll('section, article, .prose, .bg-white.border.p-6, .bg-white.border.p-8, .bg-white.border.p-10, .bg-white.border.p-12');
    contentBlocks.forEach((el, idx) => {
        // Skip elements inside header, footer, or already animated elements
        if (el.closest('header') || el.closest('footer') || el.hasAttribute('data-aos')) {
            return;
        }

        // Apply dynamic fade-up with a elegant cascade delay for adjacent blocks
        el.setAttribute('data-aos', 'fade-up');
        el.setAttribute('data-aos-duration', '800');
        
        // Calculate delay to create a sequential entrance effect
        const delay = (idx % 3) * 100;
        el.setAttribute('data-aos-delay', delay.toString());
    });

    // Dynamic grids (like lists of news/documents)
    const grids = document.querySelectorAll('.grid-cols-1, .grid-cols-2, .grid-cols-3, .grid');
    grids.forEach(el => {
        if (el.closest('header') || el.closest('footer') || el.hasAttribute('data-aos')) {
            return;
        }
        el.setAttribute('data-aos', 'fade-up');
        el.setAttribute('data-aos-duration', '800');
    });

    // 2. Initialize AOS with customized parameters
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 60,
    });
});

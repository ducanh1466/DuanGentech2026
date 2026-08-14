document.addEventListener("DOMContentLoaded", function() {
    // Sticky Header Effect
    const header = document.querySelector('.gentech-header');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Add tooltip initialization if needed later
    // const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    // const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    // --- MAGNETIC BUTTONS ---
    const magneticElements = document.querySelectorAll('.btn-primary, .btn-premium-gradient, .btn-outline-dark, .icon-btn');
    
    magneticElements.forEach(elem => {
        elem.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            
            // Calculate center of the button
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            
            // Calculate distance from mouse to center
            const x = e.clientX - centerX;
            const y = e.clientY - centerY;
            
            // Tweak the divisor (e.g., 3 or 4) to make the magnet effect stronger/weaker
            this.style.transform = `translate(${x/4}px, ${y/4}px)`;
        });
        
        elem.addEventListener('mouseleave', function(e) {
            this.style.transform = 'translate(0px, 0px)';
        });
    });

    // --- PARALLAX EFFECT ---
    const parallaxElements = document.querySelectorAll('.parallax-img');
    
    if (parallaxElements.length > 0) {
        // Use requestAnimationFrame for smoother scrolling performance
        let ticking = false;
        
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    parallaxElements.forEach(el => {
                        const container = el.parentElement;
                        const rect = container.getBoundingClientRect();
                        const windowHeight = window.innerHeight;
                        
                        // Check if element is in viewport
                        if (rect.top < windowHeight && rect.bottom > 0) {
                            // Calculate distance from center of screen
                            const centerOffset = (rect.top + rect.height / 2) - (windowHeight / 2);
                            const speed = parseFloat(el.getAttribute('data-speed')) || 0.15;
                            // Move image opposite to scroll direction
                            const shift = centerOffset * speed;
                            
                            el.style.transform = `translate3d(0, ${shift}px, 0)`;
                        }
                    });
                    ticking = false;
                });
                ticking = true;
            }
        });
    }
});

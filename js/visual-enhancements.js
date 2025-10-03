/**
 * Origin Driving School - Enhanced Visual Effects
 * Advanced JavaScript for beautiful interactions and animations
 */

// ==========================================
// SMOOTH SCROLL REVEAL ANIMATIONS
// ==========================================

const initScrollReveal = () => {
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                // Stagger animation for multiple elements
                setTimeout(() => {
                    entry.target.classList.add('revealed');
                }, index * 100);
                
                // Unobserve after revealing (performance optimization)
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all elements with scroll-reveal class
    document.querySelectorAll('.scroll-reveal').forEach(el => {
        observer.observe(el);
    });
};

// ==========================================
// ANIMATED COUNTER FOR STATS
// ==========================================

const animateCounter = (element, target, duration = 2000) => {
    const start = 0;
    const increment = target / (duration / 16); // 60fps
    let current = start;
    
    const updateCounter = () => {
        current += increment;
        if (current < target) {
            element.textContent = Math.floor(current);
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target;
        }
    };
    
    updateCounter();
};

const initCounters = () => {
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.getAttribute('data-target'));
                animateCounter(entry.target, target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.stat-number[data-target]').forEach(counter => {
        counterObserver.observe(counter);
    });
};

// ==========================================
// PARALLAX EFFECT FOR HERO SECTIONS
// ==========================================

const initParallax = () => {
    const parallaxElements = document.querySelectorAll('.parallax-element');
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        
        parallaxElements.forEach(element => {
            const speed = element.getAttribute('data-speed') || 0.5;
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    });
};

// ==========================================
// DYNAMIC NAVIGATION BACKGROUND
// ==========================================

const initDynamicNav = () => {
    const nav = document.querySelector('.main-nav');
    if (!nav) return;
    
    let lastScroll = 0;
    
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        // Change background opacity based on scroll
        if (currentScroll > 100) {
            nav.style.background = 'rgba(12, 36, 97, 0.98)';
            nav.style.boxShadow = '0 4px 30px rgba(0,0,0,0.3)';
        } else {
            nav.style.background = 'rgba(12, 36, 97, 0.95)';
            nav.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
        }
        
        // Hide/show nav on scroll (optional)
        if (currentScroll > lastScroll && currentScroll > 500) {
            nav.style.transform = 'translateY(-100%)';
        } else {
            nav.style.transform = 'translateY(0)';
        }
        
        lastScroll = currentScroll;
    });
};

// ==========================================
// ENHANCED CARD HOVER EFFECTS
// ==========================================

const initCardEffects = () => {
    document.querySelectorAll('.card-enhanced, .service-package, .instructor-card-enhanced').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 10;
            const rotateY = (centerX - x) / 10;
            
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
        });
    });
};

// ==========================================
// LAZY LOADING FOR IMAGES
// ==========================================

const initLazyLoading = () => {
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                const src = img.getAttribute('data-src');
                
                if (src) {
                    img.src = src;
                    img.classList.add('loaded');
                }
                
                imageObserver.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
};

// ==========================================
// FORM ENHANCEMENTS
// ==========================================

const initFormEnhancements = () => {
    // Floating labels
    document.querySelectorAll('input, textarea, select').forEach(input => {
        if (input.value) {
            input.classList.add('has-value');
        }
        
        input.addEventListener('blur', () => {
            if (input.value) {
                input.classList.add('has-value');
            } else {
                input.classList.remove('has-value');
            }
        });
    });
    
    // Real-time validation
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('blur', () => {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (input.value && !emailPattern.test(input.value)) {
                input.style.borderColor = '#dc3545';
                showValidationMessage(input, 'Please enter a valid email address');
            } else {
                input.style.borderColor = '#28a745';
                hideValidationMessage(input);
            }
        });
    });
};

const showValidationMessage = (input, message) => {
    let msgElement = input.nextElementSibling;
    if (!msgElement || !msgElement.classList.contains('validation-message')) {
        msgElement = document.createElement('div');
        msgElement.className = 'validation-message';
        msgElement.style.color = '#dc3545';
        msgElement.style.fontSize = '0.875rem';
        msgElement.style.marginTop = '0.5rem';
        input.parentNode.insertBefore(msgElement, input.nextSibling);
    }
    msgElement.textContent = message;
};

const hideValidationMessage = (input) => {
    const msgElement = input.nextElementSibling;
    if (msgElement && msgElement.classList.contains('validation-message')) {
        msgElement.remove();
    }
};

// ==========================================
// SMOOTH PAGE TRANSITIONS
// ==========================================

const initPageTransitions = () => {
    // Fade in on page load
    document.body.style.opacity = '0';
    window.addEventListener('load', () => {
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '1';
    });
    
    // Smooth transition on navigation
    document.querySelectorAll('a[href^="/"], a[href^="./"], a[href^="../"]').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href && !href.startsWith('#') && !link.target) {
                e.preventDefault();
                document.body.style.opacity = '0';
                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            }
        });
    });
};

// ==========================================
// TOOLTIP INITIALIZATION
// ==========================================

const initTooltips = () => {
    document.querySelectorAll('[data-tooltip]').forEach(element => {
        element.classList.add('tooltip-enhanced');
    });
};

// ==========================================
// PROGRESS BAR ANIMATION
// ==========================================

const initProgressBars = () => {
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBar = entry.target;
                const targetWidth = progressBar.getAttribute('data-progress');
                progressBar.style.width = targetWidth + '%';
                progressObserver.unobserve(progressBar);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.progress-fill[data-progress]').forEach(bar => {
        bar.style.width = '0%';
        bar.style.transition = 'width 1.5s ease-out';
        progressObserver.observe(bar);
    });
};

// ==========================================
// BACK TO TOP BUTTON
// ==========================================

const initBackToTop = () => {
    const createBackToTopButton = () => {
        const button = document.createElement('button');
        button.innerHTML = '↑';
        button.className = 'back-to-top';
        button.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #0c2461;
            border: none;
            font-size: 24px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 0 5px 20px rgba(255, 215, 0, 0.4);
        `;
        
        button.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        document.body.appendChild(button);
        return button;
    };
    
    const button = createBackToTopButton();
    
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 500) {
            button.style.opacity = '1';
            button.style.visibility = 'visible';
        } else {
            button.style.opacity = '0';
            button.style.visibility = 'hidden';
        }
    });
};

// ==========================================
// TYPING ANIMATION FOR HERO TEXT
// ==========================================

const initTypingAnimation = (element, texts, typingSpeed = 100, deletingSpeed = 50) => {
    if (!element) return;
    
    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    
    const type = () => {
        const currentText = texts[textIndex];
        
        if (isDeleting) {
            element.textContent = currentText.substring(0, charIndex - 1);
            charIndex--;
        } else {
            element.textContent = currentText.substring(0, charIndex + 1);
            charIndex++;
        }
        
        if (!isDeleting && charIndex === currentText.length) {
            setTimeout(() => { isDeleting = true; }, 2000);
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            textIndex = (textIndex + 1) % texts.length;
        }
        
        const speed = isDeleting ? deletingSpeed : typingSpeed;
        setTimeout(type, speed);
    };
    
    type();
};

// ==========================================
// INITIALIZE ALL EFFECTS
// ==========================================

document.addEventListener('DOMContentLoaded', () => {
    // Initialize all enhancements
    initScrollReveal();
    initCounters();
    initParallax();
    initDynamicNav();
    initCardEffects();
    initLazyLoading();
    initFormEnhancements();
    initTooltips();
    initProgressBars();
    initBackToTop();
    
    console.log('🚗 Origin Driving School - All visual enhancements loaded!');
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        initScrollReveal,
        animateCounter,
        initParallax,
        initDynamicNav,
        initCardEffects,
        initTypingAnimation
    };
}

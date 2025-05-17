document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const nav = document.querySelector('nav');
    const scheduleSwitcher = document.querySelector('.schedule-switcher');
    const cvSwitcher = document.querySelector('.cv-switcher');

    function isMobileScreen() {
        return window.innerWidth <= 768;
    }

    function handleMobileMenu() {
        if (isMobileScreen()) {
            nav.classList.toggle('active');
            const navUl = nav.querySelector('ul');
            if (navUl) {
                navUl.style.display = nav.classList.contains('active') ? 'block' : 'none';
            }
        }
    }

    function handleCVDropdown(e) {
        if (e.target === cvSwitcher || e.target === cvSwitcher.querySelector('a')) {
            e.preventDefault();
            cvSwitcher.classList.toggle('active');
            //close the dropdown if clicked outside
            document.addEventListener('click', function closeDropdown(event) {
                if (!cvSwitcher.contains(event.target)) {
                    cvSwitcher.classList.remove('active');
                    document.removeEventListener('click', closeDropdown);
                }
            });
        }
    }

    function handleScheduleDropdown(e) {
        if (e.target === scheduleSwitcher || e.target === scheduleSwitcher.querySelector('a')) {
            e.preventDefault();
            scheduleSwitcher.classList.toggle('active');
            //close if click outside
            document.addEventListener('click', function closeDropdown(event) {
                if (!scheduleSwitcher.contains(event.target)) {
                    scheduleSwitcher.classList.remove('active');
                    document.removeEventListener('click', closeDropdown);
                }
            });
        }
    }

    // Sidebar toggle
    if (sidebarToggle && sidebar) {
        const layout = document.querySelector('.layout');
        sidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('active');
            if (window.innerWidth > 1024) {
                layout.classList.toggle('with-sidebar');
            }
        });
        //close if clicked outside
        document.addEventListener('click', (e) => {
            if (sidebar.classList.contains('active') && 
                !sidebar.contains(e.target) && 
                !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('active');
                if (window.innerWidth > 1024) {
                    layout.classList.remove('with-sidebar');
                }
            }
        });
    }
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            handleMobileMenu();
        });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (nav.classList.contains('active') && !nav.contains(e.target) && e.target !== mobileMenuToggle) {
            nav.classList.remove('active');
            const navUl = nav.querySelector('ul');
            if (navUl) {
                navUl.style.display = 'none';
            }
        }
    });

    // Handle window resize
    window.addEventListener('resize', () => {
        if (!isMobileScreen()) {
            nav.classList.remove('active');
            const navUl = nav.querySelector('ul');
            if (navUl) {
                navUl.style.removeProperty('display');
            }
        }
    });

    if (scheduleSwitcher) {
        scheduleSwitcher.addEventListener('click', handleScheduleDropdown);
    }
    if (cvSwitcher) {
        cvSwitcher.addEventListener('click', handleCVDropdown);
    }

    // Quiz functionality
    function calculate() {
        let result = 0;
        const answers = [2,1,4,2,3,3,3,3,2,2,1,2,2,3,3,3,1,2,3,4];
        
        for(let i = 1; i <= 20; i++) {
            const question = document.getElementById(`qu${i}An${answers[i-1]}`);
            const allRadios = document.getElementsByName(`qu${i}`);
            
            if(question && question.checked) {
                result++;
                const questionContainer = document.getElementById(`question${i}`);
                if(questionContainer) {
                    questionContainer.style.border = "3px solid green";
                }
            } else {
                const questionContainer = document.getElementById(`question${i}`);
                if(questionContainer) {
                    questionContainer.style.border = "3px solid red";
                }
                
                for(let j = 0; j < allRadios.length; j++) {
                    if(allRadios[j].checked) {
                        const label = document.querySelector(`label[for='${allRadios[j].id}']`);
                        if(label) {
                            label.style.color = "red";
                        }
                    }
                }
            }
            
            const correctLabel = document.querySelector(`label[for='qu${i}An${answers[i-1]}']`);
            if(correctLabel) {
                correctLabel.style.color = "green";
            }
            
            for(let j = 0; j < allRadios.length; j++) {
                allRadios[j].disabled = true;
            }
        }
        
        const submitBtn = document.getElementById('submit');
        const resultDiv = document.getElementById('result');
        const resultValue = document.getElementById('resultvalue');
        
        if(submitBtn) submitBtn.style.display = "none";
        if(resultDiv) resultDiv.style.display = "flex";
        if(resultValue) resultValue.innerHTML = result;
        
        window.scrollTo(0, 0);
    }

    function retake() {
        const submitBtn = document.getElementById('submit');
        const resultDiv = document.getElementById('result');
        
        if(submitBtn) submitBtn.style.display = "block";
        if(resultDiv) resultDiv.style.display = "none";
        
        for(let i = 1; i <= 20; i++) {
            const allRadios = document.getElementsByName(`qu${i}`);
            for(let j = 0; j < allRadios.length; j++) {
                allRadios[j].disabled = false;
                allRadios[j].checked = false;
                const label = document.querySelector(`label[for='${allRadios[j].id}']`);
                if(label) {
                    label.style.color = "";
                }
            }
            const questionContainer = document.getElementById(`question${i}`);
            if(questionContainer) {
                questionContainer.style.border = "";
            }
        }
        
        window.scrollTo(0, 0);
    }

    const submitBtn = document.getElementById('submit1-btn');
    const retakeBtn = document.getElementById('retake1-btn');

    if(submitBtn) {
        submitBtn.addEventListener('click', calculate);
    }
    if(retakeBtn) {
        retakeBtn.addEventListener('click', retake);
    }

    // Contact form validation
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;
            
            if (!name || !email || !message) {
                e.preventDefault();
                alert('Please fill in all fields');
                return false;
            }
            
            if (!email.includes('@')) {
                e.preventDefault();
                alert('Please enter a valid email address');
                return false;
            }
            return true;
        });
    }
}); 

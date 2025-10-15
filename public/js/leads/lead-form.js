/**
 * Lead Form - Sidebar Navigation & Form Management
 */

(function() {
    'use strict';
    
    // Current section tracking
    let currentSection = 0;
    const sections = [];
    let completedSections = new Set();
    
    /**
     * Initialize the form
     */
    function initializeForm() {
        // Get all form sections
        const sectionElements = document.querySelectorAll('.form-section[data-section]');
        sectionElements.forEach((section, index) => {
            sections.push({
                id: section.dataset.section,
                element: section,
                index: index
            });
        });
        
        // Show first section
        if (sections.length > 0) {
            showSection(0);
        }
        
        // Setup navigation
        setupSidebarNavigation();
        setupFormNavigation();
        
        // Load saved progress from sessionStorage
        loadProgress();
        
        // Auto-save on input change
        setupAutoSave();
        
        // Update progress
        updateProgress();
    }
    
    /**
     * Setup sidebar navigation clicks
     */
    function setupSidebarNavigation() {
        document.querySelectorAll('.sidebar-nav-link').forEach((link, index) => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                showSection(index);
            });
        });
    }
    
    /**
     * Setup form navigation buttons
     */
    function setupFormNavigation() {
        // Previous button
        document.querySelectorAll('.btn-prev').forEach(btn => {
            btn.addEventListener('click', function() {
                if (currentSection > 0) {
                    showSection(currentSection - 1);
                }
            });
        });
        
        // Next button
        document.querySelectorAll('.btn-next').forEach(btn => {
            btn.addEventListener('click', function() {
                if (validateCurrentSection()) {
                    markSectionComplete(currentSection);
                    if (currentSection < sections.length - 1) {
                        showSection(currentSection + 1);
                    }
                }
            });
        });
    }
    
    /**
     * Show specific section
     */
    function showSection(index) {
        if (index < 0 || index >= sections.length) return;
        
        // Hide all sections
        sections.forEach(section => {
            section.element.classList.remove('active');
        });
        
        // Show target section
        sections[index].element.classList.add('active');
        currentSection = index;
        
        // Update sidebar
        document.querySelectorAll('.sidebar-nav-link').forEach((link, i) => {
            link.classList.remove('active');
            if (i === index) {
                link.classList.add('active');
            }
        });
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Update progress
        updateProgress();
    }
    
    /**
     * Validate current section
     */
    function validateCurrentSection() {
        const currentSectionElement = sections[currentSection].element;
        const requiredFields = currentSectionElement.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('error');
                isValid = false;
                
                // Remove error class on input
                field.addEventListener('input', function() {
                    this.classList.remove('error');
                }, { once: true });
            }
        });
        
        if (!isValid) {
            alert('Please fill in all required fields before proceeding.');
        }
        
        return isValid;
    }
    
    /**
     * Mark section as complete
     */
    function markSectionComplete(index) {
        completedSections.add(index);
        const navLink = document.querySelectorAll('.sidebar-nav-link')[index];
        if (navLink) {
            navLink.classList.add('completed');
        }
        saveProgress();
        updateProgress();
    }
    
    /**
     * Update progress bar
     */
    function updateProgress() {
        const totalSections = sections.length;
        const completed = completedSections.size;
        const percentage = totalSections > 0 ? (completed / totalSections) * 100 : 0;
        
        const progressBar = document.querySelector('.progress-bar-fill');
        const progressText = document.querySelector('.progress-text');
        
        if (progressBar) {
            progressBar.style.width = percentage + '%';
        }
        
        if (progressText) {
            progressText.textContent = `${completed} of ${totalSections} sections completed (${Math.round(percentage)}%)`;
        }
    }
    
    /**
     * Save progress to sessionStorage
     */
    function saveProgress() {
        const progress = {
            completedSections: Array.from(completedSections),
            currentSection: currentSection
        };
        sessionStorage.setItem('leadFormProgress', JSON.stringify(progress));
    }
    
    /**
     * Load progress from sessionStorage
     */
    function loadProgress() {
        const saved = sessionStorage.getItem('leadFormProgress');
        if (saved) {
            try {
                const progress = JSON.parse(saved);
                completedSections = new Set(progress.completedSections);
                
                // Mark completed sections
                completedSections.forEach(index => {
                    const navLink = document.querySelectorAll('.sidebar-nav-link')[index];
                    if (navLink) {
                        navLink.classList.add('completed');
                    }
                });
                
                updateProgress();
            } catch (e) {
                console.error('Failed to load progress:', e);
            }
        }
    }
    
    /**
     * Setup auto-save functionality
     */
    function setupAutoSave() {
        const form = document.getElementById('createLeadForm');
        if (!form) return;
        
        let saveTimeout;
        form.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(saveFormData, 1000);
        });
    }
    
    /**
     * Save form data to sessionStorage
     */
    function saveFormData() {
        const form = document.getElementById('createLeadForm');
        if (!form) return;
        
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        sessionStorage.setItem('leadFormData', JSON.stringify(data));
    }
    
    /**
     * Clear saved progress on form submit
     */
    function clearProgress() {
        sessionStorage.removeItem('leadFormProgress');
        sessionStorage.removeItem('leadFormData');
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeForm);
    } else {
        initializeForm();
    }
    
    // Clear progress on successful form submission
    const form = document.getElementById('createLeadForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // TEMPORARILY DISABLE ALL CLIENT-SIDE VALIDATION
            console.log('Form submitting - validation disabled for debugging');
            
            // Just clear saved data and let form submit
            clearProgress();
            
            // Don't prevent default - let form submit normally
        });
    }
    
    // Expose functions globally for backward compatibility
    window.LeadForm = {
        showSection,
        markComplete: markSectionComplete,
        clearProgress
    };
    
})();

/**
 * Dynamic field management functions using insertAdjacentHTML()
 * This is the proven method that works in client edit and old lead form
 */

// Add Phone Number
window.addPhoneNumber = function() {
    const container = document.getElementById('phoneNumbersContainer');
    if (!container) {
        console.error('Phone numbers container not found');
        return;
    }
    const index = container.children.length;
    container.insertAdjacentHTML('beforeend', `
        <div class="repeatable-section">
            <button type="button" class="remove-item-btn" title="Remove Phone"><i class="fas fa-times-circle"></i></button>
            <div class="content-grid">
                <div class="form-group">
                    <label>Type</label>
                    <select name="contact_type_hidden[${index}]" class="contact-type-selector">
                        <option value="Personal">Personal</option>
                        <option value="Work">Work</option>
                        <option value="Mobile">Mobile</option>
                        <option value="Business">Business</option>
                        <option value="Secondary">Secondary</option>
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Brother">Brother</option>
                        <option value="Sister">Sister</option>
                        <option value="Uncle">Uncle</option>
                        <option value="Aunt">Aunt</option>
                        <option value="Cousin">Cousin</option>
                        <option value="Others">Others</option>
                        <option value="Partner">Partner</option>
                        <option value="Not In Use">Not In Use</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Number</label>
                    <div class="cus_field_input" style="display:flex;">
                        <div class="country_code">
                            <input class="telephone country-code-input" id="telephone" type="tel" name="country_code[${index}]" style="width: 55px;height: 42px;" readonly >
                        </div>
                        <input type="tel" name="phone[${index}]" placeholder="Enter Phone Number" class="phone-number-input" style="width: 230px;" autocomplete="off" required>
                    </div>
                </div>
            </div>
        </div>
    `);
    if (typeof $ !== 'undefined' && typeof $.fn.intlTelInput === 'function') {
        $(".telephone").intlTelInput();
    }
    validatePersonalPhoneNumbers();
};

// Add Email Address
window.addEmailAddress = function() {
    const container = document.getElementById('emailAddressesContainer');
    if (!container) {
        console.error('Email addresses container not found');
        return;
    }
    const index = container.children.length;
    container.insertAdjacentHTML('beforeend', `
        <div class="repeatable-section">
            <button type="button" class="remove-item-btn" title="Remove Email"><i class="fas fa-times-circle"></i></button>
            <div class="content-grid">
                <div class="form-group">
                    <label>Type</label>
                    <select name="email_type_hidden[${index}]" class="email-type-selector">
                        <option value="Personal">Personal</option>
                        <option value="Work">Work</option>
                        <option value="Business">Business</option>
                        <option value="Mobile">Mobile</option>
                        <option value="Secondary">Secondary</option>
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Brother">Brother</option>
                        <option value="Sister">Sister</option>
                        <option value="Uncle">Uncle</option>
                        <option value="Aunt">Aunt</option>
                        <option value="Cousin">Cousin</option>
                        <option value="Others">Others</option>
                        <option value="Partner">Partner</option>
                        <option value="Not In Use">Not In Use</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email[${index}]" placeholder="Enter Email Address" required>
                </div>
            </div>
        </div>
    `);
    validatePersonalEmailTypes();
};

// Validate only one Personal phone number
window.validatePersonalPhoneNumbers = function() {
    const phoneSections = document.querySelectorAll('#phoneNumbersContainer .repeatable-section');
    let personalCount = 0;
    phoneSections.forEach(section => {
        const type = section.querySelector('.contact-type-selector').value;
        if (type === 'Personal') {
            personalCount++;
        }
    });

    const errorMessage = personalCount > 1 ? 'Only one phone number can be marked as Personal.' : '';
    const existingError = document.querySelector('#phoneNumbersContainer ~ .text-danger');
    if (errorMessage) {
        if (!existingError) {
            const errorElement = document.createElement('span');
            errorElement.className = 'text-danger';
            errorElement.textContent = errorMessage;
            document.getElementById('phoneNumbersContainer').insertAdjacentElement('afterend', errorElement);
        } else {
            existingError.textContent = errorMessage;
        }
    } else if (existingError) {
        existingError.remove();
    }

    return personalCount <= 1;
};

// Validate only one Personal email address
window.validatePersonalEmailTypes = function() {
    const emailSections = document.querySelectorAll('#emailAddressesContainer .repeatable-section');
    let personalCount = 0;
    emailSections.forEach(section => {
        const type = section.querySelector('.email-type-selector').value;
        if (type === 'Personal') {
            personalCount++;
        }
    });

    const errorMessage = personalCount > 1 ? 'Only one email address can be marked as Personal.' : '';
    const existingError = document.querySelector('#emailAddressesContainer ~ .text-danger');
    if (errorMessage) {
        if (!existingError) {
            const errorElement = document.createElement('span');
            errorElement.className = 'text-danger';
            errorElement.textContent = errorMessage;
            document.getElementById('emailAddressesContainer').insertAdjacentElement('afterend', errorElement);
        } else {
            existingError.textContent = errorMessage;
        }
    } else if (existingError) {
        existingError.remove();
    }

    return personalCount <= 1;
};

// Add Passport Detail
window.addPassport = async function() {
    const container = document.getElementById('passportsContainer');
    const index = container.children.length;
    
    // Fetch countries
    const countries = await fetchCountries();
    let countryOptionsHtml = '';
    countries.forEach(country => {
        countryOptionsHtml += `<option value="${country}">${country}</option>`;
    });
    
    container.insertAdjacentHTML('beforeend', `
        <div class="repeatable-section">
            <button type="button" class="remove-item-btn" title="Remove Passport"><i class="fas fa-times-circle"></i></button>
            <div class="content-grid">
                <div class="form-group">
                    <label>Passport No</label>
                    <input type="text" name="passports[${index}][number]" placeholder="Enter Passport Number" class="passport-number-field">
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <select name="passports[${index}][country]" class="passport-country-field">
                        ${countryOptionsHtml}
                    </select>
                </div>
                <div class="form-group">
                    <label>Issue Date</label>
                    <input type="text" name="passports[${index}][issue_date]" placeholder="dd/mm/yyyy" class="passport-issue-field date-picker">
                </div>
                <div class="form-group">
                    <label>Expiry Date</label>
                    <input type="text" name="passports[${index}][expiry_date]" placeholder="dd/mm/yyyy" class="passport-expiry-field date-picker">
                </div>
            </div>
        </div>
    `);
    initializeDatepickers();
};

// Add Visa Detail
window.addVisa = function() {
    const container = document.getElementById('visasContainer');
    const index = container.children.length;
    container.insertAdjacentHTML('beforeend', `
        <div class="repeatable-section">
            <button type="button" class="remove-item-btn" title="Remove Visa"><i class="fas fa-times-circle"></i></button>
            <div class="content-grid">
                <div class="form-group">
                    <label>Visa Type</label>
                    <select name="visas[${index}][visa_type_id]" class="visa-type-field">
                        <option value="">Select Visa Type</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Visa Expiry Date</label>
                    <input type="text" name="visas[${index}][expiry_date]" placeholder="dd/mm/yyyy" class="visa-expiry-field date-picker">
                </div>
                <div class="form-group">
                    <label>Visa Grant Date</label>
                    <input type="text" name="visas[${index}][grant_date]" placeholder="dd/mm/yyyy" class="visa-grant-field date-picker">
                </div>
                <div class="form-group">
                    <label>Visa Description</label>
                    <input type="text" name="visas[${index}][description]" class="visa-description-field">
                </div>
            </div>
        </div>
    `);
    initializeDatepickers();
};

// Add Address
window.addAddress = function() {
    const isCurrentAddress = document.getElementById('isCurrentAddress');
    if (!isCurrentAddress) {
        console.error('Checkbox with ID "isCurrentAddress" not found.');
        return;
    }

    if (isCurrentAddress.checked) {
        alert('Please uncheck "Is this your current address?" to add a new address.');
        return;
    }

    const container = document.getElementById('addressesContainer');
    const index = container.children.length;

    container.insertAdjacentHTML('afterbegin', `
        <div class="repeatable-section">
            <button type="button" class="remove-item-btn" title="Remove Address"><i class="fas fa-times-circle"></i></button>
            <div class="content-grid" style="grid-template-columns: 2fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Full Address</label>
                    <textarea name="address[${index}]" rows="1" class="address-input"></textarea>
                    <div class="autocomplete-items"></div>
                </div>
                <div class="form-group">
                    <label>Post Code</label>
                    <input type="text" name="zip[${index}]" class="postcode-input">
                </div>
            </div>
            <div class="content-grid" style="grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Regional Code Info</label>
                    <input type="text" name="regional_code[${index}]" class="regional-code-input" readonly>
                </div>
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="text" name="address_start_date[${index}]" placeholder="dd/mm/yyyy" class="date-picker address-start-date">
                </div>
                <div class="form-group">
                    <label>End Date</label>
                    <input type="text" name="address_end_date[${index}]" placeholder="dd/mm/yyyy" class="date-picker address-end-date">
                </div>
            </div>
        </div>
    `);

    initializeDatepickers();
    if (typeof initGoogleMaps === 'function') {
        initGoogleMaps();
    }
    updateCurrentAddressCheckbox();
};

window.updateCurrentAddressCheckbox = function() {
    const container = document.getElementById('addressesContainer');
    const checkbox = document.getElementById('isCurrentAddress');
    if (checkbox) {
        checkbox.disabled = container.children.length === 0;
        if (container.children.length === 0) {
            checkbox.checked = false;
        }
    }
};

// Add Travel Detail
window.addTravel = async function() {
    const container = document.getElementById('travelContainer');
    const index = container.children.length;

    // Fetch countries
    const countries = await fetchCountries();
    let countryOptionsHtml = '';
    countries.forEach(country => {
        countryOptionsHtml += `<option value="${country}">${country}</option>`;
    });

    container.insertAdjacentHTML('beforeend', `
        <div class="repeatable-section">
            <button type="button" class="remove-item-btn" title="Remove Travel"><i class="fas fa-times-circle"></i></button>
            <div class="content-grid">
                <div class="form-group">
                    <label>Country Visited</label>
                    <select name="travel_country_visited[${index}]">
                        ${countryOptionsHtml}
                    </select>
                </div>
                <div class="form-group">
                    <label>Arrival Date</label>
                    <input type="text" name="travel_arrival_date[${index}]" placeholder="dd/mm/yyyy" class="date-picker">
                </div>
                <div class="form-group">
                    <label>Departure Date</label>
                    <input type="text" name="travel_departure_date[${index}]" placeholder="dd/mm/yyyy" class="date-picker">
                </div>
                <div class="form-group">
                    <label>Travel Purpose</label>
                    <input type="text" name="travel_purpose[${index}]" placeholder="Enter Travel Purpose">
                </div>
            </div>
        </div>
    `);
    initializeDatepickers();
};

// Add Test Score
window.addTestScore = function() {
    const container = document.getElementById('testScoresContainer');
    const index = container.children.length;
    container.insertAdjacentHTML('beforeend', `
        <div class="repeatable-section">
            <button type="button" class="remove-item-btn" title="Remove Test"><i class="fas fa-times-circle"></i></button>
            <div class="content-grid" style="grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 10px;">
                <div class="form-group">
                    <label>Test Type</label>
                    <select name="test_type_hidden[${index}]" class="test-type-selector" onchange="updateTestScoreValidation(this, ${index})">
                        <option value="">Select Test</option>
                        <option value="IELTS">IELTS General</option>
                        <option value="IELTS_A">IELTS Academic</option>
                        <option value="PTE">PTE Academic</option>
                        <option value="TOEFL">TOEFL iBT</option>
                        <option value="CAE">CAE</option>
                        <option value="OET">OET</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Listening</label>
                    <input type="text" name="listening[${index}]" placeholder="Score" class="test-score-input" data-index="${index}">
                </div>
                <div class="form-group">
                    <label>Reading</label>
                    <input type="text" name="reading[${index}]" placeholder="Score" class="test-score-input" data-index="${index}">
                </div>
                <div class="form-group">
                    <label>Writing</label>
                    <input type="text" name="writing[${index}]" placeholder="Score" class="test-score-input" data-index="${index}">
                </div>
                <div class="form-group">
                    <label>Speaking</label>
                    <input type="text" name="speaking[${index}]" placeholder="Score" class="test-score-input" data-index="${index}">
                </div>
                <div class="form-group">
                    <label>Overall</label>
                    <input type="text" name="overall_score[${index}]" placeholder="Score" class="test-score-input" data-index="${index}">
                </div>
                <div class="form-group">
                    <label>Date of Test</label>
                    <input type="text" name="test_date[${index}]" placeholder="dd/mm/yyyy" class="date-picker test-date">
                </div>
                <div class="form-group">
                    <label>Reference No</label>
                    <input type="text" name="test_reference_no[${index}]" placeholder="Reference no">
                </div>
                <div class="form-group" style="align-items: center;">
                    <label>Relevant?</label>
                    <label class="switch">
                        <input type="checkbox" name="relevant_test_hidden[${index}]" value="1">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    `);
    initializeDatepickers();
};

// Add Qualification
window.addQualification = async function() {
    const container = document.getElementById('qualificationsContainer');
    const index = container.children.length;

    const countries = await fetchCountries();
    let countryOptionsHtml = '';
    countries.forEach(country => {
        countryOptionsHtml += `<option value="${country}">${country}</option>`;
    });

    container.insertAdjacentHTML('beforeend', `
        <div class="repeatable-section">
            <button type="button" class="remove-item-btn" title="Remove Qualification"><i class="fas fa-times-circle"></i></button>
            <div class="content-grid" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                <div class="form-group">
                    <label>Level</label>
                    <select name="level_hidden[${index}]">
                        <option value="">Select Level</option>
                        <option value="Certificate I">Certificate I</option>
                        <option value="Certificate II">Certificate II</option>
                        <option value="Certificate III">Certificate III</option>
                        <option value="Certificate IV">Certificate IV</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Advanced Diploma">Advanced Diploma</option>
                        <option value="Associate Degree">Associate Degree</option>
                        <option value="Bachelor Degree">Bachelor Degree</option>
                        <option value="Bachelor Honours Degree">Bachelor Honours Degree</option>
                        <option value="Graduate Certificate">Graduate Certificate</option>
                        <option value="Graduate Diploma">Graduate Diploma</option>
                        <option value="Masters Degree">Masters Degree</option>
                        <option value="Doctoral Degree">Doctoral Degree</option>
                        <option value="12">12</option>
                        <option value="10">10</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name[${index}]" placeholder="e.g., B. Engineering">
                </div>
                <div class="form-group">
                    <label>College Name</label>
                    <input type="text" name="qual_college_name[${index}]" placeholder="Enter college name">
                </div>
                <div class="form-group">
                    <label>Campus</label>
                    <input type="text" name="qual_campus[${index}]" placeholder="Enter campus">
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <select name="country_hidden[${index}]">
                        ${countryOptionsHtml}
                    </select>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="qual_state[${index}]" rows="2" placeholder="Enter address"></textarea>
                </div>
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="text" name="start_date[${index}]" placeholder="dd/mm/yyyy" class="date-picker">
                </div>
                <div class="form-group">
                    <label>Finish Date</label>
                    <input type="text" name="finish_date[${index}]" placeholder="dd/mm/yyyy" class="date-picker">
                </div>
                <div class="form-group" style="align-items: center;">
                    <label>Relevant?</label>
                    <label class="switch">
                        <input type="checkbox" name="relevant_qualification_hidden[${index}]" value="1">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    `);
    initializeDatepickers();
};

// Add Experience
window.addExperience = async function() {
    const container = document.getElementById('experienceContainer');
    const index = container.children.length;

    const countries = await fetchCountries();
    let countryOptionsHtml = '';
    countries.forEach(country => {
        countryOptionsHtml += `<option value="${country}">${country}</option>`;
    });

    container.insertAdjacentHTML('beforeend', `
        <div class="repeatable-section">
            <button type="button" class="remove-item-btn" title="Remove Experience"><i class="fas fa-times-circle"></i></button>
            <div class="content-grid" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                <div class="form-group">
                    <label>Job Title</label>
                    <input type="text" name="job_title[${index}]" placeholder="e.g., Software Engineer">
                </div>
                <div class="form-group">
                    <label>ANZSCO Code</label>
                    <input type="text" name="job_code[${index}]" placeholder="e.g., 261313">
                </div>
                 <div class="form-group">
                    <label>Employer Name</label>
                    <input type="text" name="job_emp_name[${index}]" placeholder="Enter employer name">
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <select name="job_country_hidden[${index}]">
                        ${countryOptionsHtml}
                    </select>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="job_state[${index}]" rows="2" placeholder="Enter address"></textarea>
                </div>
                <div class="form-group">
                    <label>Job Type</label>
                    <select name="job_type[${index}]">
                        <option value="">Select job type</option>
                        <option value="Part Time">Part Time</option>
                        <option value="Full Time">Full Time</option>
                        <option value="Casual">Casual</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="text" name="job_start_date[${index}]" placeholder="dd/mm/yyyy" class="date-picker">
                </div>
                <div class="form-group">
                    <label>Finish Date</label>
                    <input type="text" name="job_finish_date[${index}]" placeholder="dd/mm/yyyy" class="date-picker">
                </div>
                <div class="form-group" style="align-items: center;">
                    <label>Relevant?</label>
                    <label class="switch">
                        <input type="checkbox" name="relevant_experience_hidden[${index}]" value="1">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    `);
    initializeDatepickers();
};

// Add Occupation
window.addOccupation = function() {
    const container = document.getElementById('occupationsContainer');
    const index = container.children.length;
    container.insertAdjacentHTML('beforeend', `
        <div class="repeatable-section">
            <button type="button" class="remove-item-btn" title="Remove Occupation"><i class="fas fa-times-circle"></i></button>
            <div class="content-grid">
                <div class="form-group">
                    <label>Nominated Occupation</label>
                    <input type="text" name="nomi_occupation[${index}]" class="nomi_occupation" placeholder="Enter Occupation">
                    <div class="autocomplete-items"></div>
                </div>
                <div class="form-group">
                    <label>Assessing Authority</label>
                    <input type="text" name="list[${index}]" class="list" placeholder="e.g., ACS, VETASSESS">
                </div>
                <div class="form-group">
                    <label>Occupation Code (ANZSCO)</label>
                    <input type="text" name="occupation_code[${index}]" class="occupation_code" placeholder="Enter Code">
                </div>
                <div class="form-group">
                    <label for="occ_reference_no">Reference No</label>
                    <input type="text" name="occ_reference_no[${index}]" placeholder="Enter Reference No.">
                </div>
                <div class="form-group">
                    <label for="dates">Assessment Date</label>
                    <input type="text" name="dates[${index}]" class="dates date-picker" placeholder="dd/mm/yyyy">
                </div>
                <div class="form-group">
                    <label for="expiry_dates">Expiry Date</label>
                    <input type="text" name="expiry_dates[${index}]" class="expiry_dates date-picker" placeholder="dd/mm/yyyy">
                </div>
            </div>
        </div>
    `);
    initializeDatepickers();
};

// Add Family Member
window.addFamilyMember = function() {
    const container = document.getElementById('familyMembersContainer');
    const index = container.children.length;
    container.insertAdjacentHTML('beforeend', `
        <div class="repeatable-section">
            <button type="button" class="remove-item-btn" title="Remove Family Member"><i class="fas fa-times-circle"></i></button>
            <div class="content-grid">
                <div class="form-group">
                    <label>Relationship</label>
                    <select name="family_relationship[${index}]">
                        <option value="">Select Relationship</option>
                        <option value="Spouse">Spouse</option>
                        <option value="Partner">Partner</option>
                        <option value="Child">Child</option>
                        <option value="Parent">Parent</option>
                        <option value="Sibling">Sibling</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="family_first_name[${index}]" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="family_last_name[${index}]" placeholder="Enter Last Name">
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="text" name="family_dob[${index}]" placeholder="dd/mm/yyyy" class="date-picker">
                </div>
            </div>
        </div>
    `);
    initializeDatepickers();
};

// Cache countries
let countriesCache = null;

async function fetchCountries() {
    if (countriesCache) {
        return countriesCache;
    }

    if (typeof $ === 'undefined') {
        console.error('jQuery not loaded, cannot fetch countries');
        return ['India', 'Australia'];
    }

    try {
        const response = await $.ajax({
            url: '/admin/get-countries',
            method: 'GET',
            dataType: 'json',
        });
        countriesCache = response;
        return response;
    } catch (error) {
        console.error('Error fetching countries:', error);
        return ['India', 'Australia'];
    }
}

// Initialize datepickers helper
function initializeDatepickers() {
    if (typeof $ !== 'undefined' && $.fn.daterangepicker) {
        $('.date-picker').each(function() {
            if (!$(this).data('daterangepicker')) {
                $(this).daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoUpdateInput: false,
                    locale: {
                        format: 'DD/MM/YYYY',
                        applyLabel: 'Apply',
                        cancelLabel: 'Cancel',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                        monthNames: [
                            'January', 'February', 'March', 'April', 'May', 'June',
                            'July', 'August', 'September', 'October', 'November', 'December'
                        ],
                        firstDay: 1
                    },
                    autoApply: true,
                    minDate: '01/01/1000',
                    minYear: 1000,
                    maxYear: parseInt(moment().format('YYYY')) + 50
                }).on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('DD/MM/YYYY'));
                }).on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
            }
        });
    }
}

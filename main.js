/**
 * MediOrbit - Core Frontend State Engine
 * State management, view routers, calorie odometer timers, and localization parsers.
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // ==========================================
    // 1. STATE VARIABLES
    // ==========================================
    let currentActiveDiseaseId = null;
    let currentKcalTarget = 2000;
    let currentDisplayedKcal = 2000;
    let odometerInterval = null;
    let globalLanguageState = 'en'; // 'en' or 'ur'
    const fixedDishKcal = 840;

    // Default Baseline Guidelines (English & Urdu)
    const defaultBaselineData = {
        title_en: "Standard Health Guidelines",
        title_ur: "معیاری صحت کی ہدایات",
        description_en: "To maintain peak metabolic longevity, adult individuals are highly encouraged to monitor glycemic indices, limit excessive sodium matrices, and regulate overall portion volume parameters to minimize stress across vital physiological filtration channels.",
        description_ur: "صحت مند زندگی کو برقرار رکھنے کے لیے، افراد کو مشورہ دیا جاتا ہے کہ وہ نشاستہ دار غذاؤں کی مقدار کو مانیٹر کریں، سوڈیم کا استعمال محدود کریں، اور پیٹ کے دباؤ کو کم کرنے کے لیے پورشن سائز کو کنٹرول کریں۔",
        reason_en: "Eating beyond physiological energy demands floods mitochondria with substrates, elevating reactive oxygen species and inducing systemic stress.",
        reason_ur: "جسمانی ضرورت سے زیادہ کھانا ہاضمے اور توانائی پیدا کرنے والے اعضاء پر بوجھ بڑھاتا ہے جس سے نظامی تناؤ پیدا ہوتا ہے۔",
        avoid_en: ["Refined Sweeteners", "Deep Saturated Trans Fats", "Ultra-Processed Food Packages"],
        avoid_ur: ["مصنوعی میٹھے", "گہرے تلے ہوئے کھانے", "پروسیسڈ ڈبہ بند غذائیں"],
        control_en: ["Establish strict portion sizing rules", "Maintain robust metabolic fasting gaps", "Support cellular hydration routines"],
        control_ur: ["پورشن سائز کے سخت اصول اپنائیں", "کھانے کے درمیان مناسب وقفہ رکھیں", "ہائیڈریشن اور پانی پینے کا خیال رکھیں"],
        portion_en: "Standard Full Plate",
        portion_ur: "معیاری مکمل پلیٹ"
    };

    // ==========================================
    // 2. DOM ELEMENT SELECTORS
    // ==========================================
    // View containers
    const nutriscanView = document.getElementById('nutriscan-view');
    const wellnessView = document.getElementById('wellness-view');
    
    // Nav links
    const navNutriscan = document.getElementById('nav-nutriscan');
    const navWellness = document.getElementById('nav-wellness');
    
    // HUD & Chips
    const diseaseChips = document.querySelectorAll('.disease-chip');
    const hudStatusLabel = document.getElementById('hud-status-label');
    const hudStatusSubtext = document.getElementById('hud-status-subtext');
    const hudKcalCounter = document.querySelector('#hud-kcal-counter span');
    
    // Ledger elements
    const ledgerRatioLabel = document.getElementById('ledger-ratio-label');
    const ledgerProgressBar = document.getElementById('ledger-progress-bar');
    const ledgerTargetVal = document.getElementById('ledger-target-val');
    const ledgerRemainingVal = document.getElementById('ledger-remaining-val');
    
    // AI Advice elements
    const adviceHeading = document.getElementById('advice-heading');
    const adviceReason = document.getElementById('advice-reason');
    const avoidList = document.getElementById('avoid-list');
    const controlList = document.getElementById('control-list');
    const advicePortion = document.getElementById('advice-portion');
    const btnLangToggle = document.getElementById('btn-lang-toggle');
    const labelAvoid = document.getElementById('label-avoid');
    const labelControl = document.getElementById('label-control');

    // Wellness / Pagination
    const btnLoadMore = document.getElementById('btn-load-more');
    const hiddenWellnessCards = document.querySelectorAll('.hidden-card');
    const blogCards = document.querySelectorAll('.blog-card');

    // ==========================================
    // 3. NAVBAR ROUTING CONTROLLER
    // ==========================================
    function switchView(target) {
        if (target === 'nutriscan') {
            nutriscanView.classList.remove('hidden');
            wellnessView.classList.add('hidden');
            
            navNutriscan.className = 'relative py-2 text-mediorbit-green transition-all-custom border-b-2 border-mediorbit-green font-medium';
            navWellness.className = 'relative py-2 text-slate-500 hover:text-mediorbit-green transition-all-custom border-b-2 border-transparent font-medium';
        } else if (target === 'wellness') {
            wellnessView.classList.remove('hidden');
            nutriscanView.classList.add('hidden');
            
            navWellness.className = 'relative py-2 text-mediorbit-green transition-all-custom border-b-2 border-mediorbit-green font-medium';
            navNutriscan.className = 'relative py-2 text-slate-500 hover:text-mediorbit-green transition-all-custom border-b-2 border-transparent font-medium';
        }
    }

    navNutriscan.addEventListener('click', (e) => {
        e.preventDefault();
        switchView('nutriscan');
        window.history.pushState(null, '', '#nutriscan');
    });

    navWellness.addEventListener('click', (e) => {
        e.preventDefault();
        switchView('wellness');
        window.history.pushState(null, '', '#wellness');
    });

    // Handle initial route loading based on hash parameter
    if (window.location.hash === '#wellness') {
        switchView('wellness');
    } else {
        switchView('nutriscan');
    }

    // ==========================================
    // 4. CHIP SELECTION & STATE MACHINE
    // ==========================================
    diseaseChips.forEach(chip => {
        chip.addEventListener('click', () => {
            const targetId = chip.getAttribute('data-id');
            
            if (currentActiveDiseaseId === targetId) {
                // Clicking an already selected chip -> RESET to default standard baseline
                resetToDefaultState();
            } else {
                // Activating a new focus chip
                activateDiseaseChip(chip);
            }
        });
    });

    function resetToDefaultState() {
        currentActiveDiseaseId = null;
        currentKcalTarget = 2000;
        
        // Remove active outline and highlight states on all chips
        diseaseChips.forEach(c => {
            c.className = "disease-chip text-left flex flex-col justify-between p-4 rounded-xl border border-stone-200 bg-white hover:border-mediorbit-green/40 hover:shadow-premium transition-all-custom group cursor-pointer";
        });
        
        // Trigger animations & panels
        triggerCalorieHUDAnimation(2000);
        updateLedgerLedger(2000);
        updateAIPanelContent();
        
        // Update HUD headings
        hudStatusLabel.textContent = "Healthy Adult Standard Baseline";
        hudStatusSubtext.textContent = "No metabolic restrictions selected. Displaying general biological energetic guidelines.";
    }

    function activateDiseaseChip(selectedChip) {
        currentActiveDiseaseId = selectedChip.getAttribute('data-id');
        const targetKcal = parseInt(selectedChip.getAttribute('data-target'));
        currentKcalTarget = targetKcal;
        
        // Highlight active chip exclusively
        diseaseChips.forEach(c => {
            if (c.getAttribute('data-id') === currentActiveDiseaseId) {
                c.className = "disease-chip text-left flex flex-col justify-between p-4 rounded-xl border-2 border-mediorbit-green bg-mediorbit-greenLight/20 shadow-premium transition-all-custom group cursor-pointer scale-[1.02]";
            } else {
                c.className = "disease-chip text-left flex flex-col justify-between p-4 rounded-xl border border-stone-200 bg-white hover:border-mediorbit-green/40 hover:shadow-premium transition-all-custom group cursor-pointer opacity-70";
            }
        });
        
        // Trigger animations & panels
        triggerCalorieHUDAnimation(targetKcal);
        updateLedgerLedger(targetKcal);
        updateAIPanelContent();
        
        // Update HUD text parameters
        const isUrdu = globalLanguageState === 'ur';
        const title = selectedChip.getAttribute(isUrdu ? 'data-title-ur' : 'data-title-en');
        const specialty = selectedChip.getAttribute('data-tag');
        
        hudStatusLabel.textContent = `Calibrating: ${title}`;
        hudStatusSubtext.textContent = `Active clinical protocols engaged for ${specialty}. Targeting specialized caloric reduction.`;
    }

    // ==========================================
    // 5. ODOMETER TICKING CALIBRATION
    // ==========================================
    function triggerCalorieHUDAnimation(targetValue) {
        clearInterval(odometerInterval);
        
        // Faster pacing depending on distance
        const step = (targetValue > currentDisplayedKcal) ? 10 : -10;
        
        odometerInterval = setInterval(() => {
            if (currentDisplayedKcal === targetValue) {
                clearInterval(odometerInterval);
            } else {
                currentDisplayedKcal += step;
                // Safeguard parameters
                if ((step > 0 && currentDisplayedKcal > targetValue) || (step < 0 && currentDisplayedKcal < targetValue)) {
                    currentDisplayedKcal = targetValue;
                }
                hudKcalCounter.textContent = currentDisplayedKcal;
            }
        }, 12);
    }

    // ==========================================
    // 6. REAL-TIME CALCULATION LEDGER
    // ==========================================
    function updateLedgerLedger(targetKcal) {
        const remaining = targetKcal - fixedDishKcal;
        const progressPercentage = Math.min(Math.max((fixedDishKcal / targetKcal) * 100, 0), 100);
        
        // Adjust ratio label text
        ledgerRatioLabel.textContent = `${fixedDishKcal} / ${targetKcal} kcal`;
        ledgerTargetVal.textContent = `${targetKcal} kcal`;
        
        // Adjust remaining value text content
        if (remaining >= 0) {
            ledgerRemainingVal.textContent = `${remaining} kcal`;
            ledgerRemainingVal.className = "font-bold text-slate-800";
        } else {
            // Deficit/Overload styling in alert color scheme
            ledgerRemainingVal.textContent = `${remaining} kcal (Overload)`;
            ledgerRemainingVal.className = "font-bold text-mediorbit-red animate-pulse";
        }

        // Smooth width scaling and adaptive colors
        ledgerProgressBar.style.width = `${progressPercentage}%`;
        if (progressPercentage > 80) {
            ledgerProgressBar.className = "h-full bg-mediorbit-red rounded-full transition-all-custom shadow-[inset_-2px_0_4px_rgba(0,0,0,0.15)]";
        } else if (progressPercentage > 60) {
            ledgerProgressBar.className = "h-full bg-amber-600 rounded-full transition-all-custom shadow-[inset_-2px_0_4px_rgba(0,0,0,0.15)]";
        } else {
            ledgerProgressBar.className = "h-full bg-mediorbit-green rounded-full transition-all-custom shadow-[inset_-2px_0_4px_rgba(0,0,0,0.15)]";
        }
    }

    // ==========================================
    // 7. AI TREATMENT & ADVICE LOCALIZATION
    // ==========================================
    function updateAIPanelContent() {
        const isUrdu = globalLanguageState === 'ur';
        
        // Static translations for static UI elements inside the advice box
        if (isUrdu) {
            labelAvoid.textContent = "پرہیز کریں (Avoid)";
            labelControl.textContent = "اقدامات و کنٹرول (Actionable)";
            btnLangToggle.innerHTML = `
                <svg class="h-4 w-4 text-mediorbit-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.622C13.7 4.242 15.91 3.512 18 3.512M5.05 9a31.252 31.252 0 001.353 5.462m1.082 1.542q.525.683 1.179 1.25m-1.24-9.044c-1.34 2.516-3.66 4.67-6.044 5.62m12.44-5.62c-.462.868-1.042 1.688-1.725 2.447m0-2.447L10.5 18" />
                </svg>
                ترجمہ کریں (English)
            `;
            // Align RTL for Urdu translations
            adviceReason.className = "mt-2 text-sm leading-relaxed text-slate-700 font-sans lang-ur";
            adviceHeading.className = "font-serif text-lg font-bold text-mediorbit-red lang-ur";
        } else {
            labelAvoid.textContent = "Avoid Foods";
            labelControl.textContent = "Actionable Protocols";
            btnLangToggle.innerHTML = `
                <svg class="h-4 w-4 text-mediorbit-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.622C13.7 4.242 15.91 3.512 18 3.512M5.05 9a31.252 31.252 0 001.353 5.462m1.082 1.542q.525.683 1.179 1.25m-1.24-9.044c-1.34 2.516-3.66 4.67-6.044 5.62m12.44-5.62c-.462.868-1.042 1.688-1.725 2.447m0-2.447L10.5 18" />
                </svg>
                Translate (English / Urdu)
            `;
            adviceReason.className = "mt-2 text-sm leading-relaxed text-slate-700 font-sans lang-en";
            adviceHeading.className = "font-serif text-lg font-bold text-mediorbit-red lang-en";
        }

        if (!currentActiveDiseaseId) {
            // Show default base state details
            adviceHeading.textContent = isUrdu ? defaultBaselineData.title_ur : defaultBaselineData.title_en;
            adviceReason.textContent = isUrdu ? defaultBaselineData.description_ur : defaultBaselineData.description_en;
            advicePortion.textContent = isUrdu ? defaultBaselineData.portion_ur : defaultBaselineData.portion_en;
            
            renderBulletList(avoidList, isUrdu ? defaultBaselineData.avoid_ur : defaultBaselineData.avoid_en);
            renderBulletList(controlList, isUrdu ? defaultBaselineData.control_ur : defaultBaselineData.control_en);
        } else {
            // Find active element chip
            const activeChip = document.getElementById(`chip-${currentActiveDiseaseId}`);
            if (activeChip) {
                const title = activeChip.getAttribute(isUrdu ? 'data-title-ur' : 'data-title-en');
                const reason = activeChip.getAttribute(isUrdu ? 'data-reason-ur' : 'data-reason-en');
                const avoidRaw = activeChip.getAttribute(isUrdu ? 'data-avoid-ur' : 'data-avoid-en');
                const controlRaw = activeChip.getAttribute(isUrdu ? 'data-control-ur' : 'data-control-en');
                
                adviceHeading.textContent = `${isUrdu ? 'طبی تجزیہ' : 'Clinical Advice'}: ${title}`;
                adviceReason.textContent = reason;
                
                const avoids = JSON.parse(avoidRaw);
                const controls = JSON.parse(controlRaw);
                
                renderBulletList(avoidList, avoids);
                renderBulletList(controlList, controls);
                
                // Serving limit calculation logic
                if (currentKcalTarget === 1200) {
                    advicePortion.textContent = isUrdu ? "تجویز کردہ: آدھی پلیٹ (1/2 Plate)" : "Suggested Serving: 1/2 Plate";
                } else if (currentKcalTarget === 1300) {
                    advicePortion.textContent = isUrdu ? "تجویز کردہ: دو تہائی پلیٹ (2/3 Plate)" : "Suggested Serving: 2/3 Plate";
                } else {
                    advicePortion.textContent = isUrdu ? "تجویز کردہ: تین چوتھائی پلیٹ (3/4)" : "Suggested Serving: 3/4 Plate";
                }
            }
        }
    }

    function renderBulletList(element, array) {
        element.innerHTML = '';
        array.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item;
            element.appendChild(li);
        });
    }

    // Connect switch trigger pointer listener
    btnLangToggle.addEventListener('click', () => {
        globalLanguageState = (globalLanguageState === 'en') ? 'ur' : 'en';
        updateAIPanelContent();
        
        // Sync active chip title if selected
        if (currentActiveDiseaseId) {
            const activeChip = document.getElementById(`chip-${currentActiveDiseaseId}`);
            if (activeChip) {
                const title = activeChip.getAttribute(globalLanguageState === 'ur' ? 'data-title-ur' : 'data-title-en');
                const specialty = activeChip.getAttribute('data-tag');
                hudStatusLabel.textContent = `Calibrating: ${title}`;
            }
        }
    });

    // Initialize content load
    updateAIPanelContent();

    // ==========================================
    // 8. INDIVIDUAL CARD TRANSLATION & PAGINATION
    // ==========================================
    
    // Pagination: Load Remaining 6 Cards
    btnLoadMore.addEventListener('click', () => {
        hiddenWellnessCards.forEach(card => {
            card.classList.remove('hidden-card');
            card.classList.add('show-card');
        });
        
        // Remove button wrapper to clear UI state
        document.getElementById('pagination-wrapper').remove();
    });

    // Individual Blog Card Language State Switches
    blogCards.forEach(card => {
        const btnTranslate = card.querySelector('.btn-card-translate');
        
        btnTranslate.addEventListener('click', () => {
            const currentLang = card.getAttribute('data-lang');
            const targetLang = (currentLang === 'en') ? 'ur' : 'en';
            card.setAttribute('data-lang', targetLang);
            
            // Fetch localization fields
            const title = card.getAttribute(targetLang === 'ur' ? 'data-title-ur' : 'data-title-en');
            const desc = card.getAttribute(targetLang === 'ur' ? 'data-desc-ur' : 'data-desc-en');
            const reason = card.getAttribute(targetLang === 'ur' ? 'data-reason-ur' : 'data-reason-en');
            const avoidRaw = card.getAttribute(targetLang === 'ur' ? 'data-avoid-ur' : 'data-avoid-en');
            const controlRaw = card.getAttribute(targetLang === 'ur' ? 'data-control-ur' : 'data-control-en');
            
            // Map JSON array formats
            const avoids = JSON.parse(avoidRaw);
            const controls = JSON.parse(controlRaw);
            
            // Target specific card elements
            const cardTitle = card.querySelector('.card-title');
            const cardDesc = card.querySelector('.card-desc');
            const cardReasonTitle = card.querySelector('.card-reason-title');
            const cardReason = card.querySelector('.card-reason');
            const cardAvoidTitle = card.querySelector('.card-avoid-title');
            const cardAvoidList = card.querySelector('.card-avoid-list');
            const cardControlTitle = card.querySelector('.card-control-title');
            const cardControlList = card.querySelector('.card-control-list');
            const btnSpan = btnTranslate.querySelector('span');

            // Apply modifications
            cardTitle.textContent = title;
            cardDesc.textContent = desc;
            cardReason.textContent = reason;
            
            renderBulletList(cardAvoidList, avoids);
            renderBulletList(cardControlList, controls);

            if (targetLang === 'ur') {
                cardTitle.className = "font-serif text-xl font-bold text-slate-800 tracking-tight card-title lang-ur";
                cardDesc.className = "mt-3 text-xs leading-relaxed text-slate-600 font-sans tracking-wide card-desc lang-ur";
                cardReasonTitle.className = "text-xs font-semibold text-mediorbit-green uppercase tracking-wider mb-1 font-sans card-reason-title lang-ur";
                cardReason.className = "text-xs leading-relaxed text-slate-500 card-reason lang-ur";
                cardAvoidTitle.className = "text-[10px] font-bold text-mediorbit-red uppercase tracking-wider mb-1.5 font-sans card-avoid-title lang-ur";
                cardAvoidList.className = "list-disc pr-3 text-[10px] text-slate-500 space-y-1 card-avoid-list lang-ur";
                cardControlTitle.className = "text-[10px] font-bold text-mediorbit-green uppercase tracking-wider mb-1.5 font-sans card-control-title lang-ur";
                cardControlList.className = "list-disc pr-3 text-[10px] text-slate-500 space-y-1 card-control-list lang-ur";
                
                cardReasonTitle.textContent = "یہ کیوں ہوتا ہے (Pathophysiology)";
                cardAvoidTitle.textContent = "پرہیز کریں (Avoid)";
                cardControlTitle.textContent = "حفاظتی اقدامات (Control)";
                
                btnSpan.textContent = "[Translate to English]";
            } else {
                cardTitle.className = "font-serif text-xl font-bold text-slate-800 tracking-tight card-title lang-en";
                cardDesc.className = "mt-3 text-xs leading-relaxed text-slate-600 font-sans tracking-wide card-desc lang-en";
                cardReasonTitle.className = "text-xs font-semibold text-mediorbit-green uppercase tracking-wider mb-1 font-sans card-reason-title lang-en";
                cardReason.className = "text-xs leading-relaxed text-slate-500 card-reason lang-en";
                cardAvoidTitle.className = "text-[10px] font-bold text-mediorbit-red uppercase tracking-wider mb-1.5 font-sans card-avoid-title lang-en";
                cardAvoidList.className = "list-disc pl-3 text-[10px] text-slate-500 space-y-1 card-avoid-list lang-en";
                cardControlTitle.className = "text-[10px] font-bold text-mediorbit-green uppercase tracking-wider mb-1.5 font-sans card-control-title lang-en";
                cardControlList.className = "list-disc pl-3 text-[10px] text-slate-500 space-y-1 card-control-list lang-en";
                
                cardReasonTitle.textContent = "Why it Happens";
                cardAvoidTitle.textContent = "Avoid List";
                cardControlTitle.textContent = "Control Strategies";
                
                btnSpan.textContent = "[Translate to Urdu]";
            }
        });
    });

    // ==========================================
    // 9. VECTOR SEARCH CTA DEMO CLICK ANIMATION
    // ==========================================
    const btnAnalyzeVector = document.getElementById('btn-analyze-vector');
    btnAnalyzeVector.addEventListener('click', () => {
        btnAnalyzeVector.innerHTML = `
            <svg class="animate-spin h-4 w-4 mr-2 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            [CALIBRATING VECTOR PATH...]
        `;
        btnAnalyzeVector.disabled = true;

        setTimeout(() => {
            btnAnalyzeVector.innerHTML = `
                <svg class="h-4 w-4 mr-2 text-mediorbit-gold" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                [VECTOR SCAN COMPLETE]
            `;
            btnAnalyzeVector.className = "w-full mt-5 inline-flex items-center justify-center rounded-xl bg-emerald-700 px-4 py-3.5 text-sm font-semibold text-white shadow-md shadow-emerald-700/10 hover:shadow-lg transition-all-custom tracking-wider font-sans group cursor-pointer";
            
            setTimeout(() => {
                btnAnalyzeVector.innerHTML = `
                    <svg class="h-4 w-4 mr-2 text-mediorbit-gold" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    [ANALYZE MEAL VECTOR]
                `;
                btnAnalyzeVector.className = "w-full mt-5 inline-flex items-center justify-center rounded-xl bg-mediorbit-green px-4 py-3.5 text-sm font-semibold text-white hover:bg-mediorbit-accent shadow-md shadow-mediorbit-green/10 hover:shadow-lg transition-all-custom tracking-wider font-sans group cursor-pointer";
                btnAnalyzeVector.disabled = false;
            }, 2000);
        }, 1500);
    });

});

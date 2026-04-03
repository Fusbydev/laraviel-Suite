document.addEventListener("DOMContentLoaded", function () {

                    const roomHtml = `
                    <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up">
                        <div class="room-card">
                            <div class="room-image-wrapper">
                                <img src="/${room.image_path.replace(/^\//, '')}" alt="${room.room_type}" loading="lazy">
                                <span class="room-badge">${room.room_type.split(' ')[0]}</span>
                            </div>
                            <div class="room-content">
                                <h3 class="room-type">${room.room_type}</h3>
                                <p class="room-description">${room.description.substring(0, 90)}...</p>
                                
                                <div class="room-price-row pt-3 mt-auto border-top border-gold border-opacity-10 d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="price-label">Per Night</span>
                                        <span class="price-value">₱${parseFloat(room.price).toLocaleString()}</span>
                                    </div>
                                    <button class="btn btn-premium-solid btn-sm select-room-btn" 
                                            data-id="${room.id}" 
                                            data-type="${room.room_type}" 
                                            data-price="${room.price}">
                                        Select
                                    </button>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="#" class="small text-gold text-decoration-none aboreto" style="font-size: 0.6rem; letter-spacing: 2px;" data-bs-toggle="modal" data-bs-target="${modalTarget}">
                                        View In-Suite Amenities
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    container.insertAdjacentHTML("beforeend", roomHtml);
                });

                // Attach selection listeners
                document.querySelectorAll(".select-room-btn").forEach(btn => {
                    btn.addEventListener("click", function() {
                        const roomId = this.dataset.id;
                        
                        // Redirect logic if on Accommodation page
                        if (!document.getElementById("stepper")) {
                            window.location.href = `/book-now?room_id=${roomId}`;
                            return;
                        }

                        const roomType = this.dataset.type;
                        const price = parseFloat(this.dataset.price);

                        if (this.innerText === "Selected") {
                            this.innerText = "Select";
                            this.classList.replace("btn-light", "btn-premium-solid");
                            selectedRooms = [];
                        } else {
                            // Deselect all others
                            document.querySelectorAll(".select-room-btn").forEach(b => {
                                b.innerText = "Select";
                                b.classList.replace("btn-light", "btn-premium-solid");
                            });
                            // Select this one
                            this.innerText = "Selected";
                            this.classList.replace("btn-premium-solid", "btn-light");
                            selectedRooms = [{ id: roomId, type: roomType, price: price }];
                        }
                        updateSummary();
                    });
                });

                // Auto-select room from URL
                const urlParams = new URLSearchParams(window.location.search);
                const preselectRoomId = urlParams.get('room_id');
                if (preselectRoomId && document.getElementById("stepper")) {
                    const preselectBtn = document.querySelector(`.select-room-btn[data-id="${preselectRoomId}"]`);
                    if (preselectBtn) {
                        preselectBtn.click();
                        // Jump to Step 2 to show their selection
                        setTimeout(() => switchStep(2), 500); 
                    }
                }
            })
            .catch(err => {
                console.error("Room fetch error:", err);
                const loader = document.getElementById("loader");
                if (loader) {
                    loader.innerHTML = '<p class="text-gold small">An error occurred while curating our collection. Please refresh.</p>';
                }
            });
    };

    const updateSummary = () => {
        const roomListElem = document.querySelector(".booked-rooms");
        if(!roomListElem) return;

    const monthNames = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];

    const currentMonthDropdown = document.getElementById(
        "currentMonthDropdown"
    );
    const nextMonthDropdown = document.getElementById("nextMonthDropdown");

    const currentDate = new Date();
    const currentMonth = currentDate.getMonth(); // Current month index (0-11)
    const currentYear = currentDate.getFullYear();

    // Populate the current month dropdown with months from the current month onward
    for (let i = currentMonth; i < monthNames.length; i++) {
        const option = document.createElement("option");
        option.value = i + 1; // Month value (1-12)
        option.textContent = monthNames[i];
        currentMonthDropdown.appendChild(option);
    }

    // Populate the next month dropdown with months from the current month onward, and wrap around for next year
    for (
        let i = currentMonth + 1;
        i < monthNames.length + currentMonth + 1;
        i++
    ) {
        const monthIndex = i % 12; // Wrap around after December
        const yearOffset = Math.floor(i / 12); // Increment year after December
        const option = document.createElement("option");
        option.value = monthIndex + 1; // Month value (1-12)
        option.textContent = `${monthNames[monthIndex]} ${
            currentYear + yearOffset
        }`;
        nextMonthDropdown.appendChild(option);
    }

        totalPrice = selectedRooms.reduce((acc, r) => acc + (r.price * nights), 0);
        
        document.querySelectorAll(".totalPriceDisplay").forEach(display => {
            display.textContent = `₱${totalPrice.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        });
    };

    // ── Payment Form Toggle ────────────────────
    const paymentMethodSelect = document.getElementById('paymentMethodSelect');
    if (paymentMethodSelect) {
        paymentMethodSelect.addEventListener('change', function(e) {
            document.querySelectorAll('.payment-form').forEach(el => el.classList.add('d-none'));
            if (e.target.value === 'over_the_counter') {
                document.getElementById('counterPaymentForm').classList.remove('d-none');
            }
        });
    }

    // ── Step Navigation ────────────────────────
    const switchStep = (step) => {
        // Validation for step 1
        if (step === 2 && (!checkInDate || !checkOutDate)) {
            alert("Please select your Timeline first.");
            return;
        }

    function isValidDateSelection() {
        if (checkInDate && checkOutDate) {
            const checkInDateObject = new Date(checkInDate),
                checkOutDateObject = new Date(checkOutDate);
            return checkOutDateObject >= checkInDateObject;
        }
        return false;
    }

        // Validation for step 3
        if (step === 4) {
            const reqFields = ["firstname", "lastname", "email", "contactNumber", "address"];
            const isComplete = reqFields.every(id => document.getElementById(id).value.trim() !== "");
            if (!isComplete) {
                alert("Please complete the Resident Profile.");
                return;
            }
        }

        // Processing payment (transition from 4 to 5)
        if (step === 5) {
            // Show processing
            const paymentForms = document.querySelectorAll(".payment-form");
            paymentForms.forEach(el => el.classList.add("d-none"));
            if(document.getElementById("paymentMethodSelect")) document.getElementById("paymentMethodSelect").classList.add("d-none");
            const labels = document.querySelectorAll("#step-4-content label");
            labels.forEach(el => el.classList.add("d-none"));
            
            const processingNode = document.getElementById("paymentProcessing");
            if(processingNode) processingNode.classList.remove("d-none");
            
            const stepNav = document.getElementById("step-navigation");
            if(stepNav) stepNav.classList.add("d-none");
            
            setTimeout(() => {
                submitBooking();
                renderSwitch(5);
            }, 2000);
            return;
        }

        renderSwitch(step);
    };

    const renderSwitch = (step) => {
        currentStep = step;

        for(let i=1; i<=5; i++) {
            const content = document.getElementById(`step-${i}-content`);
            if(content) content.classList.add("d-none");
            
            const indicator = document.getElementById(`step-${i}-indicator`);
            if(indicator) indicator.classList.remove("active");
        }

        const activeContent = document.getElementById(`step-${currentStep}-content`);
        if(activeContent) activeContent.classList.remove("d-none");
        
        const activeIndicator = document.getElementById(`step-${currentStep}-indicator`);
        if(activeIndicator) activeIndicator.classList.add("active");

        window.scrollTo({ top: 0, behavior: 'smooth' });

        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        
        if (prevBtn) {
            if (currentStep === 1 || currentStep === 5) prevBtn.classList.add("d-none");
            else prevBtn.classList.remove("d-none");
        }

        if (nextBtn) {
            if (currentStep === 5) nextBtn.classList.add("d-none");
            else if (currentStep === 4) nextBtn.innerText = "Confirm & Pay";
            else nextBtn.innerText = "Continue Journey";
        }
        
        if(activeContent) {
            anime({
                targets: activeContent,
                opacity: [0, 1],
                translateY: [20, 0],
                duration: 800,
                easing: 'easeOutCubic'
            });
        }
    };

    if (document.getElementById("nextBtn")) {
        document.getElementById("nextBtn").addEventListener("click", () => switchStep(currentStep + 1));
    }
    if (document.getElementById("prevBtn")) {
        document.getElementById("prevBtn").addEventListener("click", () => switchStep(currentStep - 1));
    }

    // ── Calendar Core ──────────────────────────
    function generateCalendar(year, month, calendarId, titleId) {
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDay = new Date(year, month, 1).getDay();



    let currentStep = 1;
    document.querySelector(".nextBtn").addEventListener("click", function () {
        if (isValidDateSelection()) {
            const checkIndate1 = $("#checkIndd").text(),
                checkOutdate1 = $("#checkOutdd").text();
            if (currentStep < document.querySelectorAll(".circle").length) {
                document
                    .querySelectorAll(".circle")
                    [currentStep].classList.add("light");
                if (currentStep === 1) {
                    document
                        .querySelector("#select-accommodation")
                        .classList.remove("d-none");
                    document
                        .querySelector("#date-picker")
                        .classList.add("d-none");
                    currentStep++;
                } else if (currentStep === 2) {
                    document
                        .querySelector("#guest-info")
                        .classList.remove("d-none");
                    document
                        .querySelector("#select-accommodation")
                        .classList.add("d-none");
                    currentStep++;
                } else if (currentStep === 3) {
                    document
                        .querySelector("#guest-info")
                        .classList.add("d-none");
                    finalConfirmation(checkIndate1, checkOutdate1);
                    document
                        .querySelector("#booking-confirmation")
                        .classList.remove("d-none");
                }
            }
        }
    });

    function generateUniqueId() {
        const uniqueId =
            Math.random().toString(36).substr(2, 9) + Date.now().toString(36);
        localStorage.setItem("bookingId", uniqueId);
        return uniqueId;
    }

    function finalConfirmation(cin, cout) {
        // Call generateUniqueId if bookingId doesn't already exist in localStorage
        let bookingId = localStorage.getItem("bookingId");
        if (!bookingId) {
            // If no bookingId, generate and store a new one
            bookingId = generateUniqueId();
        } else {
            // If bookingId exists, remove it from localStorage before generating a new one
            localStorage.removeItem("bookingId");
            bookingId = generateUniqueId(); // Generate a new uniqueId
        }

        const guestData = {
            bookingId: Math.random().toString(36).substr(2, 9) + Date.now().toString(36),
            salutation: document.getElementById("salutation").value,
            firstname: document.getElementById("firstname").value,
            lastname: document.getElementById("lastname").value,
            email: document.getElementById("email").value,
            contactNumber: document.getElementById("contactNumber").value,
            address: document.getElementById("address").value,
            checkIn: checkInDate,
            checkOut: checkOutDate,
            bookedRooms: selectedRooms.map(r => r.type).join(", "),
            priceTotal: totalPrice,
            paymentMethod: 'over_the_counter',
            paymentStatus: 'pending'
        };
        
        $(".greeting").text(
            `Dear ${guestData.salutation} ${guestData.lastname},`
        );
        $(".guest-info1").append(`
            Guest Name: <span>${guestData.lastname}, ${guestData.firstname}</span><br>
            Check-In Date: <span>${cin}</span><br>
            Check-Out Date: <span>${cout}</span><br>
            Room Type and Room Rates: <br><span>${guestData.bookedRooms}</span>
        `);
        $("span.total-price").text(`Php ${guestData.priceTotal}`);
        console.log(guestData);
        fetch("/submit-guest-info", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify(guestData),
        })
        
            .then((response) => response.json())
            .then((data) =>
                data.errors
                    ? console.log("Validation errors:", data.errors)
                    : alert("Check your email for a detailed receipt and tracking information for your stay. We're looking forward to hosting you!")
                )
            .catch(console.error);

    }

    
    // Initialize calendars
    generateCalendar(
        currentYear,
        currentMonth,
        "currentMonthCalendar",
        "currentMonthTitle"
    );
    generateCalendar(
        currentYear,
        currentMonth + 1,
        "nextMonthCalendar",
        "nextMonthTitle"
    );

});

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Book Appointment - Pet Care</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=1920') center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 245, 235, 0.85);
            z-index: -1;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 15px 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .logo {
            width: 50px;
            height: 50px;
            background: #FF8C42;
            border-radius: 50%;
        }

        .nav-links {
            display: flex;
            gap: 40px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 600;
            transition: color 0.3s;
        }

        .nav-links a.active {
            color: #FF8C42;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            padding: 50px;
            max-width: 600px;
            width: 100%;
            margin-top: 80px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .form-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-title h2 {
            font-size: 2em;
            color: #FF8C42;
            margin-bottom: 10px;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 0.95em;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="date"],
        .form-group input[type="time"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #FF8C42;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .radio-option input[type="radio"] {
            width: 20px;
            height: 20px;
            accent-color: #FF8C42;
        }

        .date-time-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .service-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .service-checkbox:hover {
            border-color: #FF8C42;
            background: #FFF5EB;
        }

        .service-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #FF8C42;
            margin-top: 2px;
        }

        .service-info {
            flex: 1;
        }

        .service-info strong {
            display: block;
            color: #333;
            margin-bottom: 5px;
        }

        .service-info span {
            color: #666;
            font-size: 0.9em;
        }

        .link-text {
            color: #FF8C42;
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.9em;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .summary-row:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.1em;
            color: #FF8C42;
        }

        .summary-row label {
            color: #666;
        }

        .summary-row span {
            color: #333;
            font-weight: 600;
        }

        .upload-section {
            margin-top: 20px;
        }

        .upload-btn {
            display: inline-block;
            padding: 12px 30px;
            background: #FF8C42;
            color: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-btn:hover {
            background: #FF6B35;
        }

        .upload-btn input[type="file"] {
            display: none;
        }

        .file-name {
            display: inline-block;
            margin-left: 10px;
            color: #666;
            font-size: 0.9em;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 50px;
            font-size: 1.1em;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel {
            background: #e0e0e0;
            color: #666;
        }

        .btn-cancel:hover {
            background: #d0d0d0;
        }

        .btn-next,
        .btn-submit {
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
        }

        .btn-next:hover,
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 140, 66, 0.4);
        }

        .btn-back {
            background: white;
            color: #FF8C42;
            border: 2px solid #FF8C42;
        }

        .btn-back:hover {
            background: #FFF5EB;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }
            
            .container {
                padding: 30px 20px;
                margin-top: 100px;
            }

            .date-time-row {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo"></div>
        <ul class="nav-links">
            <li><a href="/">Home</a></li>
            <li><a href="/appointment" class="active">Appointment</a></li>
            <li><a href="/products">Products</a></li>
            <li><a href="/contact">Contact Us</a></li>
        </ul>
    </nav>

    <div class="container">
        <form action="/appointment" method="POST" enctype="multipart/form-data" id="appointmentForm">
            @csrf
            
            <!-- Step 1: Pet Information -->
            <div class="form-step active" data-step="1">
                <div class="form-title">
                    <h2>Pet Information</h2>
                </div>

                <div class="form-group">
                    <label for="pet_name">Pet Name</label>
                    <input type="text" id="pet_name" name="pet_name" required>
                </div>

                <div class="form-group">
                    <label>Pet Type</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="dog" name="pet_type" value="dog" required>
                            <label for="dog">Dog</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="cat" name="pet_type" value="cat">
                            <label for="cat">Cat</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="pet_age">Pet Age</label>
                    <div class="date-time-row">
                        <input type="number" id="pet_age_years" name="pet_age_years" placeholder="Years" min="0">
                        <input type="number" id="pet_age_months" name="pet_age_months" placeholder="Months" min="0" max="11">
                    </div>
                </div>

                <div class="form-group">
                    <label for="pet_breed">Pet Breed</label>
                    <input type="text" id="pet_breed" name="pet_breed" required>
                    <small class="link-text">mixed breed dog</small>
                </div>

                <div class="form-group">
                    <label>Pet Gender</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="female" name="pet_gender" value="female" required>
                            <label for="female">Female</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="male" name="pet_gender" value="male">
                            <label for="male">Male</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="pet_weight">Weight</label>
                    <input type="number" id="pet_weight" name="pet_weight" placeholder="kg" step="0.1" required>
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-cancel" onclick="window.location.href='/'">Cancel</button>
                    <button type="button" class="btn btn-next" onclick="nextStep(2)">Next</button>
                </div>
            </div>

            <!-- Step 2: Appointment Details -->
            <div class="form-step" data-step="2">
                <div class="form-title">
                    <h2>Appointment Details</h2>
                </div>

                <div class="form-group">
                    <label for="appointment_date">Appointment Date</label>
                    <input type="date" id="appointment_date" name="appointment_date" required>
                </div>

                <div class="form-group">
                    <label for="appointment_time">Appointment Time</label>
                    <div class="date-time-row">
                        <input type="time" id="appointment_time" name="appointment_time" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Service</label>
                    
                    <div class="service-radio-group">
                    @foreach($services as $srv)
                    <label class="service-checkbox" style="display: flex; gap: 10px; align-items: start; cursor: pointer;">
                        <input type="radio" 
                            name="service_id" 
                            value="{{ $srv->service_id }}" 
                            data-name="{{ $srv->service_name }}"
                            data-price="{{ $srv->price }}"
                            onchange="updateSummary()"
                            {{ (isset($selectedService) && $selectedService->service_id == $srv->service_id) ? 'checked' : (empty($selectedService) && $loop->first ? 'checked' : '') }}
                            required 
                            style="width: 20px; height: 20px; margin-top: 5px;">
                        
                        <div class="service-info">
                            <strong>{{ $srv->service_name }} - Rp {{ number_format($srv->price, 0, ',', '.') }}</strong>
                            <span style="display:block; font-size: 0.9em; color: #666;">{{ $srv->description }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>

                <div class="form-group">
                    <label for="notes">Additional Notes</label>
                    <textarea id="notes" name="notes" placeholder="e.g. dog doesn't like cold water, please use warm water"></textarea>
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-back" onclick="prevStep(1)">Back</button>
                    <button type="button" class="btn btn-next" onclick="nextStep(3)">Next</button>
                </div>
            </div>

            <!-- Step 3: Payment Summary -->
            <div class="form-step" data-step="3">
                <div class="form-title">
                    <h2>Payment Summary</h2>
                </div>

                <div class="form-group">
                    <div class="summary-row">
                        <label>Customer Name:</label>
                        <span id="summary_customer">{{ Auth::user()->name ?? 'Guest' }}</span>
                    </div>
                    <div class="summary-row">
                        <label>Pet Name:</label>
                        <span id="summary_pet">-</span>
                    </div>
                    <div class="summary-row">
                        <label>Appointment Date:</label>
                        <span id="summary_date">-</span>
                    </div>
                    <div class="summary-row">
                        <label>Appointment Time:</label>
                        <span id="summary_time">-</span>
                    </div>
                    <div class="summary-row">
                        <label>Selected Service:</label>
                        <span id="summary_service">-</span>
                    </div>
                    <div class="summary-row">
                        <label>Total Price:</label>
                        <span id="summary_price">Rp 0</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Payment Method</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="cash" name="payment_method" value="cash" required onchange="togglePaymentInfo()">
                            <label for="cash">Cash</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" onchange="togglePaymentInfo()">
                            <label for="bank_transfer">Bank Transfer</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="ewallet" name="payment_method" value="ewallet" onchange="togglePaymentInfo()">
                            <label for="ewallet">E-Wallet (GoPay)</label>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="transfer-info" style="display: none; background: #FFF5EB; padding: 20px; border-radius: 10px; margin-top: 20px;">
                    <label style="font-size: 1.1em; margin-bottom: 15px;">Transfer to:</label>
                    <p id="transfer-details" style="color: #FF8C42; font-weight: 700; font-size: 1.2em; margin-top: 10px;"></p>
                </div>

                <div class="upload-section" id="upload-section" style="display: none;">
                    <label style="display: block; margin-bottom: 10px; font-weight: 600;">Upload Proof of Payment:</label>
                    <small style="color: #666; display: block; margin-bottom: 10px;">Support file types: JPG, JPEG, PNG (max. 2MB)</small>
                    <label class="upload-btn">
                        Choose File
                        <input type="file" name="payment_proof" accept="image/*" id="payment_proof" onchange="showFileName()">
                    </label>
                    <span class="file-name" id="file-name"></span>
                </div>

                <div class="alert-info" id="cash-info" style="display: none; background: #FFF5EB; padding: 15px; border-radius: 10px; margin-top: 20px; color: #FF8C42; font-weight: 600; text-align: center;">
                    Pembayaran cash akan dikonfirmasi saat Anda datang ke toko!
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-back" onclick="prevStep(2)">Back</button>
                    <button type="submit" class="btn btn-submit">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function nextStep(step) {
            // Validasi step sebelum pindah
            const currentStep = document.querySelector('.form-step.active');
            const inputs = currentStep.querySelectorAll('input[required], textarea[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (input.type === 'radio') {
                    const name = input.name;
                    const checked = document.querySelector(`input[name="${name}"]:checked`);
                    if (!checked) {
                        isValid = false;
                        alert('Please fill all required fields');
                    }
                } else if (!input.value) {
                    isValid = false;
                    alert('Please fill all required fields');
                }
            });

            if (!isValid) return;

            document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
            document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');
            
            if(step === 3) {
                updateSummary();
            }

            window.scrollTo(0, 0);
        }

        function prevStep(step) {
            document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
            document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');
            window.scrollTo(0, 0);
        }

        function updateSummary() {
            // Update pet name
            const petName = document.getElementById('pet_name').value;
            document.getElementById('summary_pet').textContent = petName || '-';

            // Update date
            const date = document.getElementById('appointment_date').value;
            document.getElementById('summary_date').textContent = date || '-';

            // Update time
            const time = document.getElementById('appointment_time').value;
            document.getElementById('summary_time').textContent = time || '-';

            // Update selected service and calculate total
            const selectedService = document.querySelector('input[name="service_id"]:checked');

            if (selectedService) {
                const name = selectedService.dataset.name || '-';
                // ensure price is numeric (strip non-digits)
                const rawPrice = selectedService.dataset.price || '0';
                const price = parseInt(String(rawPrice).replace(/\D/g, '')) || 0;

                document.getElementById('summary_service').textContent = name;
                document.getElementById('summary_price').textContent = 'Rp ' + price.toLocaleString('id-ID');
            } else {
                document.getElementById('summary_service').textContent = '-';
                document.getElementById('summary_price').textContent = 'Rp 0';
            }
        }

        function showFileName() {
            const input = document.getElementById('payment_proof');
            const fileName = document.getElementById('file-name');
            if (input.files.length > 0) {
                fileName.textContent = input.files[0].name;
            }
        }

        function togglePaymentInfo() {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            const transferInfo = document.getElementById('transfer-info');
            const transferDetails = document.getElementById('transfer-details');
            const uploadSection = document.getElementById('upload-section');
            const cashInfo = document.getElementById('cash-info');
            
            console.log('Payment method changed:', paymentMethod ? paymentMethod.value : 'none');
            
            if (!paymentMethod) return;
            
            // Hide all sections first
            transferInfo.style.display = 'none';
            uploadSection.style.display = 'none';
            cashInfo.style.display = 'none';
            
            const method = paymentMethod.value;
            
            if (method === 'cash') {
                // Show cash info alert
                cashInfo.style.display = 'block';
                console.log('Showing cash info');
            } else if (method === 'bank_transfer') {
                // Show bank transfer info
                transferInfo.style.display = 'block';
                transferDetails.textContent = 'SeaBank - 901683597161';
                uploadSection.style.display = 'block';
                console.log('Showing bank transfer info');
            } else if (method === 'ewallet') {
                // Show GoPay info
                transferInfo.style.display = 'block';
                transferDetails.textContent = 'GoPay - 081260968298';
                uploadSection.style.display = 'block';
                console.log('Showing ewallet info');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('appointment_date').setAttribute('min', today);
            togglePaymentInfo();
            // ensure summary reflects any pre-selected service on load
            try { updateSummary(); } catch (e) { /* ignore if not present */ }
        });


        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('appointment_date').setAttribute('min', today);
        });
    </script>
</body>
</html>
<?php
// Lab 5: PHP Variables Scope & String Functions

// 1. PHP Variable Scope
$globalPatientCount = 150; // Global Variable

function calculateTotalPatients() {
    global $globalPatientCount;
    $localNewPatients = 12; // Local Variable
    return $globalPatientCount + $localNewPatients;
}
$activePatients = calculateTotalPatients();

// 2. PHP String Functions
$rawUserName = "  dr. john doe  ";
// String format manipulation
$styledUserName = ucwords(strtolower(trim($rawUserName)));

$rawSystemName = "smart_care_advanced_portal";
$styledSystemName = ucwords(str_replace('_', ' ', $rawSystemName));

// 3. Lab 6: File Upload Feature
$uploadMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['lab_report'])) {
    $file = $_FILES['lab_report'];
    if ($file['error'] === 0) {
        $dest = __DIR__ . '/' . time() . '_' . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $dest)) {
            $uploadMsg = "<p style='color:green; padding:10px; background:#e6ffe6; border-radius:5px;'>File Uploaded Successfully: " . htmlspecialchars($file['name']) . "</p>";
        } else {
            $uploadMsg = "<p style='color:red;'>Failed to move file.</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCare Advanced Dashboard - Lab3 (JavaScript Enhanced)</title>
    <link rel="stylesheet" href="smartcare.css">
</head>
<body>

    <!-- Sidebar Navigation with Advanced Design -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="logo-text">Smart<br>Care</h2>
            <p class="tagline">Healthcare Excellence</p>
        </div>
        <nav class="sidebar-nav">
            <a href="#" class="nav-item active" data-section="home">🏠 HOME</a>
            <a href="#" class="nav-item" data-section="patients">👨‍⚕️ PATIENTS</a>
            <a href="#" class="nav-item" data-section="appointments">📅 APPOINTMENTS</a>
            <a href="#" class="nav-item" data-section="reports">📋 REPORTS</a>
            <a href="#" class="nav-item" data-section="settings">⚙️ SETTINGS</a>
        </nav>
    </div>

    <!-- Main Content Area -->
    <div class="main">

        <!-- Advanced Header with Animation -->
        <div class="header">
            <div class="header-top">
                <div class="header-left">
                    <h1 class="fade-in"><?php echo $styledSystemName; ?> - Lab 5</h1>
                    <p class="para slide-in" id="date"></p>
                </div>
                <div class="header-right">
                    <div class="user-widget">
                        <img src="https://via.placeholder.com/50" alt="User" class="user-avatar">
                        <span class="user-name"><?php echo $styledUserName; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content with Flex Layout -->
        <div class="content">

            <!-- Updates Section with Cards -->
            <div class="updates">
                <h3 class="section-heading">📢 Latest Health Updates</h3>
                <div class="update-card animated-card">
                    <div class="update-icon">📌</div>
                    <div>
                        <h4>Appointment Reminder</h4>
                        <p>Your cardiology appointment is scheduled for tomorrow.</p>
                        <small>Today, 2:00 PM</small>
                    </div>
                </div>

                <div class="update-card animated-card">
                    <div class="update-icon">📄</div>
                    <div>
                        <h4>Lab Report Available</h4>
                        <p>Blood test results are now available for download.</p>
                        <small>Yesterday</small>
                    </div>
                </div>

                <div class="update-card animated-card">
                    <div class="update-icon">⚠️</div>
                    <div>
                        <h4>Prescription Refill</h4>
                        <p>Your prescription needs refilling. Contact your pharmacy.</p>
                        <small>Dec 15</small>
                    </div>
                </div>
            </div>

            <!-- Dashboard Cards with Gradients -->
            <div class="cards">
                <div class="card card-gradient-1 hover-lift">
                    <div class="card-header">
                        <h3>👥 Patient Records</h3>
                    </div>
                    <p>View & manage patient details</p>
                    <div class="card-stats" id="patientCount"><?php echo $activePatients; ?> Active Patients</div>
                    <p style="font-size: 0.8rem; margin-top: 5px; color: #fff;">*(Calculated via PHP global/local scope variables)</p>
                    <button class="btn-card" data-section="patients">More Details →</button>
                </div>

                <div class="card card-gradient-2 hover-lift">
                    <div class="card-header">
                        <h3>📅 Appointments</h3>
                    </div>
                    <p>Check upcoming schedules</p>
                    <div class="card-stats" id="appointmentCount">0 Scheduled</div>
                    <button class="btn-card" data-section="appointments">More Details →</button>
                </div>

                <div class="card card-gradient-3 hover-lift">
                    <div class="card-header">
                        <h3>📈 Health Analytics</h3>
                    </div>
                    <p>Monitor health statistics</p>
                    <div class="card-stats">95% Improvement</div>
                    <button class="btn-card" data-section="reports">More Details →</button>
                </div>

                <div class="card card-gradient-4 hover-lift">
                    <div class="card-header">
                        <h3>📋 Medical Reports</h3>
                    </div>
                    <p>Access diagnostic reports</p>
                    <div class="card-stats">156 Available</div>
                    <button class="btn-card" data-section="reports">More Details →</button>
                </div>
            </div>
        </div>

        <!-- Dynamic Content Sections (JavaScript Enhanced) -->
        <div id="dynamicContent">
            <!-- Patient Management Section -->
            <div class="content-section" id="patientsSection" style="display:none;">
                <h3>👥 Patient Management (JavaScript Enhanced)</h3>
                <div class="patient-form">
                    <h4>Add New Patient</h4>
                    <form id="patientForm">
                        <input type="text" placeholder="Patient Name" name="name" required>
                        <input type="number" placeholder="Age" name="age" required>
                        <input type="tel" placeholder="Phone" name="phone" required>
                        <select name="department" required>
                            <option value="">Select Department</option>
                            <option>Cardiology</option>
                            <option>Neurology</option>
                            <option>Dermatology</option>
                        </select>
                        <button type="submit">Add Patient</button>
                    </form>
                </div>
                <div id="patientList"></div>
            </div>

            <!-- Appointments Section -->
            <div class="content-section" id="appointmentsSection" style="display:none;">
                <h3>📅 Appointments Management (JavaScript Enhanced)</h3>
                <div class="appointment-form">
                    <h4>Schedule New Appointment</h4>
                    <form id="appointmentForm">
                        <input type="text" placeholder="Patient Name" name="patientName" required>
                        <input type="datetime-local" name="datetime" required>
                        <select name="doctor" required>
                            <option value="">Select Doctor</option>
                            <option>Dr. Arjun Patel</option>
                            <option>Dr. Neha Saxena</option>
                            <option>Dr. Vikram Gupta</option>
                        </select>
                        <textarea name="notes" placeholder="Notes"></textarea>
                        <button type="submit">Schedule Appointment</button>
                    </form>
                </div>
                <div id="appointmentList"></div>
            </div>

            <!-- Reports Section (Modified for Lab 6) -->
            <div class="content-section" id="reportsSection" style="display:none;">
                <h3>📋 Medical Reports & Files (Lab 6)</h3>
                
                <?php echo $uploadMsg; ?>

                <div class="appointment-form" style="margin-top:20px;">
                    <h4>Upload New Medical Report</h4>
                    <form action="index.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="lab_report" required style="margin-bottom:10px;">
                        <button type="submit" class="btn-card">Upload File</button>
                    </form>
                </div>

                <div class="appointment-form" style="margin-top:20px;">
                    <h4>Reference Data</h4>
                    <p>Dummy data file for reference operations:</p>
                    <a href="download.php" style="display:inline-block; margin-top:10px; padding:10px 15px; background:#3baea0; color:#fff; text-decoration:none; border-radius:5px;">Download dummy-data.txt</a>
                </div>

                <div style="margin-top:30px;">
                    <button id="generateReport">Generate Health Report</button>
                    <div id="reportOutput"></div>
                </div>
            </div>
        </div>

        <!-- Advanced Table Section -->
        <div class="table-section">
            <div class="section-header">
                <h3>👥 Patient Appointments Schedule</h3>
                <span class="badge" id="todayBadge">0 Patients Today</span>
            </div>
            <div class="table-responsive">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Category</th>
                            <th>Phone Number</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Dynamic content will be added here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="stats-section">
            <h3 class="section-heading">📊 Key Performance Metrics</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <h4>Total Patients</h4>
                    <p class="stat-value" id="totalPatients">0</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <h4>Appointments</h4>
                    <p class="stat-value" id="totalAppointments">0</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📈</div>
                    <h4>Reports</h4>
                    <p class="stat-value">156</p>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <h4>Completed</h4>
                    <p class="stat-value">89%</p>
                </div>
            </div>
        </div>

        <!-- Enhanced Footer -->
        <footer class="footer">
            <p>&copy; 2025 SmartCare Healthcare System. All rights reserved | Privacy Policy | Terms of Service</p>
            <p><strong>Lab3 Features:</strong> JavaScript Form Validation, Local Storage, Dynamic Content Updates, Real-time Statistics</p>
        </footer>

    </div>

    <script src="script.js"></script>

</body>
</html>

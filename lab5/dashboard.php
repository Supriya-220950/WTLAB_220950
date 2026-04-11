<?php
// ==================== SMARTCARE LAB4 - PHP BACKEND INTEGRATION ====================
// Initialize session for user management
session_start();

// Include database configuration (simulated)
require_once 'config.php';

// Initialize variables
$name = $age = $department = $status = "";
$patients = [];
$appointments = [];
$reports = [];
$message = "";

// Load existing data from session (simulated database)
if (!isset($_SESSION['patients'])) {
    $_SESSION['patients'] = [
        [
            'id' => 1,
            'name' => 'Raghav Kumar',
            'age' => 21,
            'department' => 'Cardiology',
            'phone' => '+91 4557-6554-374',
            'email' => 'raghav@email.com',
            'status' => 'Confirmed',
            'created' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 2,
            'name' => 'Ram Singh',
            'age' => 28,
            'department' => 'Neurology',
            'phone' => '+91 4553-7456-5456',
            'email' => 'ram@email.com',
            'status' => 'Pending',
            'created' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 3,
            'name' => 'Priya Sharma',
            'age' => 35,
            'department' => 'Dermatology',
            'phone' => '+91 9876-5432-109',
            'email' => 'priya@email.com',
            'status' => 'Confirmed',
            'created' => date('Y-m-d H:i:s')
        ]
    ];
}

if (!isset($_SESSION['appointments'])) {
    $_SESSION['appointments'] = [
        [
            'id' => 101,
            'patient_id' => 1,
            'patient_name' => 'Raghav Kumar',
            'doctor' => 'Dr. Arjun Patel',
            'date' => '2025-12-17',
            'time' => '14:00',
            'status' => 'Confirmed',
            'notes' => 'Routine checkup'
        ],
        [
            'id' => 102,
            'patient_id' => 2,
            'patient_name' => 'Ram Singh',
            'doctor' => 'Dr. Neha Saxena',
            'date' => '2025-12-18',
            'time' => '10:30',
            'status' => 'Pending',
            'notes' => 'Follow-up consultation'
        ]
    ];
}

if (!isset($_SESSION['reports'])) {
    $_SESSION['reports'] = [
        [
            'id' => 1001,
            'patient_id' => 1,
            'patient_name' => 'Raghav Kumar',
            'type' => 'Blood Test',
            'date' => '2025-12-15',
            'status' => 'Available'
        ],
        [
            'id' => 1002,
            'patient_id' => 2,
            'patient_name' => 'Ram Singh',
            'type' => 'X-Ray',
            'date' => '2025-12-14',
            'status' => 'Available'
        ]
    ];
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_patient':
                $newPatient = [
                    'id' => count($_SESSION['patients']) + 1,
                    'name' => sanitizeInput($_POST['name']),
                    'age' => (int)$_POST['age'],
                    'department' => sanitizeInput($_POST['department']),
                    'phone' => sanitizeInput($_POST['phone']),
                    'email' => sanitizeInput($_POST['email']),
                    'status' => sanitizeInput($_POST['status']),
                    'created' => date('Y-m-d H:i:s')
                ];
                $_SESSION['patients'][] = $newPatient;
                $message = "Patient added successfully!";
                break;

            case 'schedule_appointment':
                $newAppointment = [
                    'id' => count($_SESSION['appointments']) + 101,
                    'patient_id' => (int)$_POST['patient_id'],
                    'patient_name' => sanitizeInput($_POST['patient_name']),
                    'doctor' => sanitizeInput($_POST['doctor']),
                    'date' => sanitizeInput($_POST['date']),
                    'time' => sanitizeInput($_POST['time']),
                    'status' => sanitizeInput($_POST['status']),
                    'notes' => sanitizeInput($_POST['notes'])
                ];
                $_SESSION['appointments'][] = $newAppointment;
                $message = "Appointment scheduled successfully!";
                break;

            case 'upload_report':
                if (isset($_FILES['report_file'])) {
                    $file = $_FILES['report_file'];
                    if ($file['error'] == 0) {
                        $uploadDir = 'uploads/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }

                        $fileName = time() . '_' . basename($file['name']);
                        $targetPath = $uploadDir . $fileName;

                        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                            $newReport = [
                                'id' => count($_SESSION['reports']) + 1001,
                                'patient_id' => (int)$_POST['patient_id'],
                                'patient_name' => sanitizeInput($_POST['patient_name']),
                                'type' => sanitizeInput($_POST['report_type']),
                                'file_path' => $targetPath,
                                'file_name' => $fileName,
                                'date' => date('Y-m-d'),
                                'status' => 'Available'
                            ];
                            $_SESSION['reports'][] = $newReport;
                            $message = "Report uploaded successfully!";
                        } else {
                            $message = "Error uploading file.";
                        }
                    }
                }
                break;
        }
    } else {
        // Legacy form handling (backward compatibility)
        $name = sanitizeInput($_POST["name"] ?? "");
        $age = (int)($_POST["age"] ?? 0);
        $department = sanitizeInput($_POST["department"] ?? "");
        $status = sanitizeInput($_POST["status"] ?? "");

        if ($name != "") {
            $newPatient = [
                'id' => count($_SESSION['patients']) + 1,
                'name' => $name,
                'age' => $age,
                'department' => $department,
                'phone' => '',
                'email' => '',
                'status' => $status,
                'created' => date('Y-m-d H:i:s')
            ];
            $_SESSION['patients'][] = $newPatient;
            $message = "Patient added successfully!";
        }
    }
}

// Load data for display
$patients = $_SESSION['patients'];
$appointments = $_SESSION['appointments'];
$reports = $_SESSION['reports'];

// Utility functions
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function getPatientById($id) {
    foreach ($_SESSION['patients'] as $patient) {
        if ($patient['id'] == $id) {
            return $patient;
        }
    }
    return null;
}

function getTodaysAppointments() {
    $today = date('Y-m-d');
    return array_filter($_SESSION['appointments'], function($apt) use ($today) {
        return $apt['date'] == $today;
    });
}

function getTotalStats() {
    return [
        'total_patients' => count($_SESSION['patients']),
        'total_appointments' => count($_SESSION['appointments']),
        'total_reports' => count($_SESSION['reports']),
        'todays_appointments' => count(getTodaysAppointments())
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCare Dashboard - Lab4</title>
    <link rel="stylesheet" href="smartcare.css">
    <style>
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .form-section { background: white; padding: 20px; margin: 20px 0; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0; }
        .stat-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px; text-align: center; }
        .data-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .data-table th, .data-table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .data-table th { background-color: #f8f9fa; font-weight: bold; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin: 2px; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }
        .tab-buttons { margin: 20px 0; }
        .tab-btn { padding: 10px 20px; margin-right: 10px; border: none; background: #f8f9fa; cursor: pointer; border-radius: 5px; }
        .tab-btn.active { background: #007bff; color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
    </style>
</head>
<body>

    <!-- Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="logo-text">Smart<br>Care</h2>
            <p class="tagline">PHP Backend</p>
        </div>
        <nav class="sidebar-nav">
            <a href="#dashboard" class="nav-item active" onclick="showTab('dashboard')">🏠 DASHBOARD</a>
            <a href="#patients" class="nav-item" onclick="showTab('patients')">👨‍⚕️ PATIENTS</a>
            <a href="#appointments" class="nav-item" onclick="showTab('appointments')">📅 APPOINTMENTS</a>
            <a href="#reports" class="nav-item" onclick="showTab('reports')">📋 REPORTS</a>
            <a href="#upload" class="nav-item" onclick="showTab('upload')">⬆️ UPLOAD</a>
        </nav>
    </div>

    <div class="main">
        <div class="header">
            <h1>SmartCare Dashboard - PHP Backend</h1>
            <p>Lab4: Server-side Processing & Data Management</p>
        </div>

        <?php if ($message): ?>
            <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Dashboard Tab -->
        <div id="dashboard" class="tab-content active">
            <div class="stats-grid">
                <?php $stats = getTotalStats(); ?>
                <div class="stat-card">
                    <h3><?php echo $stats['total_patients']; ?></h3>
                    <p>Total Patients</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $stats['total_appointments']; ?></h3>
                    <p>Total Appointments</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $stats['total_reports']; ?></h3>
                    <p>Medical Reports</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $stats['todays_appointments']; ?></h3>
                    <p>Today's Appointments</p>
                </div>
            </div>

            <div class="form-section">
                <h3>Quick Add Patient</h3>
                <form method="post" action="">
                    <input type="hidden" name="action" value="add_patient">
                    <input type="text" name="name" placeholder="Patient Name" required>
                    <input type="number" name="age" placeholder="Age" required>
                    <input type="text" name="department" placeholder="Department" required>
                    <input type="tel" name="phone" placeholder="Phone" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <select name="status">
                        <option value="Confirmed">Confirmed</option>
                        <option value="Pending">Pending</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Add Patient</button>
                </form>
            </div>
        </div>

        <!-- Patients Tab -->
        <div id="patients" class="tab-content">
            <h2>Patient Management</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Department</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?php echo $patient['id']; ?></td>
                        <td><?php echo $patient['name']; ?></td>
                        <td><?php echo $patient['age']; ?></td>
                        <td><?php echo $patient['department']; ?></td>
                        <td><?php echo $patient['phone']; ?></td>
                        <td><?php echo $patient['status']; ?></td>
                        <td>
                            <button class="btn btn-primary">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Appointments Tab -->
        <div id="appointments" class="tab-content">
            <h2>Appointment Management</h2>

            <div class="form-section">
                <h3>Schedule New Appointment</h3>
                <form method="post" action="">
                    <input type="hidden" name="action" value="schedule_appointment">
                    <select name="patient_id" required>
                        <option value="">Select Patient</option>
                        <?php foreach ($patients as $patient): ?>
                        <option value="<?php echo $patient['id']; ?>"><?php echo $patient['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="patient_name" placeholder="Patient Name" required>
                    <select name="doctor" required>
                        <option value="">Select Doctor</option>
                        <option>Dr. Arjun Patel</option>
                        <option>Dr. Neha Saxena</option>
                        <option>Dr. Vikram Gupta</option>
                    </select>
                    <input type="date" name="date" required>
                    <input type="time" name="time" required>
                    <select name="status">
                        <option value="Scheduled">Scheduled</option>
                        <option value="Confirmed">Confirmed</option>
                        <option value="Pending">Pending</option>
                    </select>
                    <textarea name="notes" placeholder="Notes"></textarea>
                    <button type="submit" class="btn btn-success">Schedule Appointment</button>
                </form>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $apt): ?>
                    <tr>
                        <td><?php echo $apt['id']; ?></td>
                        <td><?php echo $apt['patient_name']; ?></td>
                        <td><?php echo $apt['doctor']; ?></td>
                        <td><?php echo $apt['date']; ?></td>
                        <td><?php echo $apt['time']; ?></td>
                        <td><?php echo $apt['status']; ?></td>
                        <td>
                            <button class="btn btn-primary">Edit</button>
                            <button class="btn btn-danger">Cancel</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Reports Tab -->
        <div id="reports" class="tab-content">
            <h2>Medical Reports</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?php echo $report['id']; ?></td>
                        <td><?php echo $report['patient_name']; ?></td>
                        <td><?php echo $report['type']; ?></td>
                        <td><?php echo $report['date']; ?></td>
                        <td><?php echo $report['status']; ?></td>
                        <td>
                            <?php if (isset($report['file_path'])): ?>
                                <a href="<?php echo $report['file_path']; ?>" class="btn btn-success" download>Download</a>
                            <?php else: ?>
                                <button class="btn btn-primary">View</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Upload Tab -->
        <div id="upload" class="tab-content">
            <h2>Upload Medical Reports</h2>
            <div class="form-section">
                <form method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload_report">
                    <select name="patient_id" required>
                        <option value="">Select Patient</option>
                        <?php foreach ($patients as $patient): ?>
                        <option value="<?php echo $patient['id']; ?>"><?php echo $patient['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="patient_name" placeholder="Patient Name" required>
                    <select name="report_type" required>
                        <option value="">Select Report Type</option>
                        <option>Blood Test</option>
                        <option>X-Ray</option>
                        <option>ECG</option>
                        <option>MRI</option>
                        <option>CT Scan</option>
                    </select>
                    <input type="file" name="report_file" accept=".pdf,.jpg,.png,.doc,.docx" required>
                    <button type="submit" class="btn btn-primary">Upload Report</button>
                </form>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; 2025 SmartCare Healthcare System - Lab4 PHP Backend | Session ID: <?php echo session_id(); ?></p>
        </footer>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName).classList.add('active');

            // Update navigation
            document.querySelectorAll('.nav-item').forEach(nav => {
                nav.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // Initialize with dashboard active
        document.addEventListener('DOMContentLoaded', function() {
            console.log('SmartCare Lab4 - PHP Backend Initialized');
        });
    </script>

</body>
</html>


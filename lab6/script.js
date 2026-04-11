// SmartCare Lab3 - JavaScript Features Demonstration
// Builds upon Lab2 with interactive features, form validation, local storage, and dynamic content

// ==================== PATIENT MANAGEMENT ====================
let patients = JSON.parse(localStorage.getItem('patients')) || [];

// ==================== APPOINTMENT MANAGEMENT ====================
let appointments = JSON.parse(localStorage.getItem('appointments')) || [];

// ==================== DOM ELEMENTS ====================
const patientForm = document.getElementById('patientForm');
const appointmentForm = document.getElementById('appointmentForm');
const generateReportBtn = document.getElementById('generateReport');
const patientList = document.getElementById('patientList');
const appointmentList = document.getElementById('appointmentList');
const reportOutput = document.getElementById('reportOutput');
const tableBody = document.getElementById('tableBody');

// ==================== NAVIGATION ====================
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all nav items
        document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
        this.classList.add('active');
        
        // Hide all sections
        document.querySelectorAll('.content-section').forEach(section => {
            section.style.display = 'none';
        });
        
        // Show selected section
        const sectionId = this.getAttribute('data-section') + 'Section';
        const section = document.getElementById(sectionId);
        if (section) {
            section.style.display = 'block';
        }
    });
});

// ==================== PATIENT FORM HANDLING ====================
if (patientForm) {
    patientForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const patient = {
            id: Date.now(),
            name: formData.get('name'),
            age: parseInt(formData.get('age')),
            phone: formData.get('phone'),
            department: formData.get('department'),
            status: 'Active',
            createdAt: new Date().toISOString()
        };
        
        patients.push(patient);
        savePatients();
        displayPatients();
        updateStatistics();
        this.reset();
        
        // Show success message
        showMessage('Patient added successfully!', 'success');
    });
}

// ==================== APPOINTMENT FORM HANDLING ====================
if (appointmentForm) {
    appointmentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const appointment = {
            id: Date.now(),
            patientName: formData.get('patientName'),
            datetime: formData.get('datetime'),
            doctor: formData.get('doctor'),
            notes: formData.get('notes'),
            status: 'Scheduled',
            createdAt: new Date().toISOString()
        };
        
        appointments.push(appointment);
        saveAppointments();
        displayAppointments();
        updateStatistics();
        this.reset();
        
        // Show success message
        showMessage('Appointment scheduled successfully!', 'success');
    });
}

// ==================== REPORT GENERATION ====================
if (generateReportBtn) {
    generateReportBtn.addEventListener('click', function() {
        const report = generateHealthReport();
        reportOutput.innerHTML = `
            <div class="report-card">
                <h4>📊 Health Report Summary</h4>
                <div class="report-stats">
                    <div class="stat-item">
                        <span class="stat-label">Total Patients:</span>
                        <span class="stat-value">${report.totalPatients}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Total Appointments:</span>
                        <span class="stat-value">${report.totalAppointments}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Departments:</span>
                        <span class="stat-value">${Object.keys(report.departments).length}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Average Age:</span>
                        <span class="stat-value">${report.averageAge} years</span>
                    </div>
                </div>
                <div class="department-breakdown">
                    <h5>Patients by Department:</h5>
                    <ul>
                        ${Object.entries(report.departments).map(([dept, count]) => 
                            `<li>${dept}: ${count} patients</li>`
                        ).join('')}
                    </ul>
                </div>
            </div>
        `;
    });
}

// ==================== DISPLAY FUNCTIONS ====================
function displayPatients() {
    if (!patientList) return;
    
    patientList.innerHTML = '<h4>Recent Patients</h4>';
    const recentPatients = patients.slice(-5); // Show last 5 patients
    
    recentPatients.forEach(patient => {
        const div = document.createElement('div');
        div.className = 'patient-item';
        div.innerHTML = `
            <div class="patient-info">
                <strong>${patient.name}</strong> (${patient.age} years) - ${patient.department}
                <br><small>Phone: ${patient.phone} | Status: ${patient.status}</small>
            </div>
            <button onclick="deletePatient(${patient.id})" class="delete-btn">Delete</button>
        `;
        patientList.appendChild(div);
    });
}

function displayAppointments() {
    if (!appointmentList) return;
    
    appointmentList.innerHTML = '<h4>Recent Appointments</h4>';
    const recentAppointments = appointments.slice(-5); // Show last 5 appointments
    
    recentAppointments.forEach(apt => {
        const div = document.createElement('div');
        div.className = 'appointment-item';
        div.innerHTML = `
            <div class="appointment-info">
                <strong>${apt.patientName}</strong> - ${apt.doctor}
                <br><small>${new Date(apt.datetime).toLocaleString()} | Status: ${apt.status}</small>
                ${apt.notes ? `<br><small>Notes: ${apt.notes}</small>` : ''}
            </div>
            <button onclick="deleteAppointment(${apt.id})" class="delete-btn">Cancel</button>
        `;
        appointmentList.appendChild(div);
    });
}

function updateTable() {
    if (!tableBody) return;
    
    tableBody.innerHTML = '';
    
    patients.slice(-3).forEach(patient => {
        const row = document.createElement('tr');
        row.className = 'table-row-hover';
        row.innerHTML = `
            <td><strong>${patient.name}</strong></td>
            <td>${patient.age}</td>
            <td><span class="tag tag-${patient.department.toLowerCase()}">${patient.department}</span></td>
            <td>${patient.phone}</td>
            <td><span class="status confirmed">${patient.status}</span></td>
        `;
        tableBody.appendChild(row);
    });
}

// ==================== UTILITY FUNCTIONS ====================
function savePatients() {
    localStorage.setItem('patients', JSON.stringify(patients));
}

function saveAppointments() {
    localStorage.setItem('appointments', JSON.stringify(appointments));
}

function deletePatient(id) {
    patients = patients.filter(p => p.id !== id);
    savePatients();
    displayPatients();
    updateStatistics();
}

function deleteAppointment(id) {
    appointments = appointments.filter(a => a.id !== id);
    saveAppointments();
    displayAppointments();
    updateStatistics();
}

function generateHealthReport() {
    const departments = {};
    let totalAge = 0;
    
    patients.forEach(patient => {
        departments[patient.department] = (departments[patient.department] || 0) + 1;
        totalAge += patient.age;
    });
    
    return {
        totalPatients: patients.length,
        totalAppointments: appointments.length,
        departments: departments,
        averageAge: patients.length > 0 ? Math.round(totalAge / patients.length) : 0
    };
}

function updateStatistics() {
    const patientCountEl = document.getElementById('patientCount');
    const appointmentCountEl = document.getElementById('appointmentCount');
    const totalPatientsEl = document.getElementById('totalPatients');
    const totalAppointmentsEl = document.getElementById('totalAppointments');
    const todayBadgeEl = document.getElementById('todayBadge');
    
    if (patientCountEl) patientCountEl.textContent = `${patients.length} Active Patients`;
    if (appointmentCountEl) appointmentCountEl.textContent = `${appointments.length} Scheduled`;
    if (totalPatientsEl) totalPatientsEl.textContent = patients.length;
    if (totalAppointmentsEl) totalAppointmentsEl.textContent = appointments.length;
    if (todayBadgeEl) todayBadgeEl.textContent = `${patients.length} Patients Today`;
    
    updateTable();
}

function showMessage(message, type) {
    // Create message element
    const messageEl = document.createElement('div');
    messageEl.className = `message ${type}`;
    messageEl.textContent = message;
    messageEl.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 5px;
        color: white;
        background: ${type === 'success' ? '#28a745' : '#dc3545'};
        z-index: 10000;
        animation: slideIn 0.3s ease-out;
    `;
    
    document.body.appendChild(messageEl);
    
    // Remove after 3 seconds
    setTimeout(() => {
        messageEl.remove();
    }, 3000);
}

// ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', function() {
    // Set current date
    const dateEl = document.getElementById('date');
    if (dateEl) {
        dateEl.textContent = new Date().toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
    
    // Initialize displays
    displayPatients();
    displayAppointments();
    updateStatistics();
    
    // Add CSS for dynamic elements
    const style = document.createElement('style');
    style.textContent = `
        .patient-item, .appointment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            margin: 5px 0;
            background: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #e9ecef;
        }
        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .report-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .report-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .stat-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .department-breakdown ul {
            list-style: none;
            padding: 0;
        }
        .department-breakdown li {
            padding: 5px 0;
            border-bottom: 1px solid #e9ecef;
        }
    `;
    document.head.appendChild(style);
});

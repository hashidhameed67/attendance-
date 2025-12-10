<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Attendance Report</title>
    <link rel="stylesheet" href="styles.css"> <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> 

<style>
* {
    box-sizing: border-box;
}


body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    min-height: 100vh;
    padding: 60px 20px;
    display: flex;
    justify-content: center;
    align-items: flex-start;

    background:
        radial-gradient(circle at top left, #c7d2fe, transparent 40%),
        radial-gradient(circle at bottom right, #e0f2fe, transparent 40%),
        linear-gradient(135deg, #eef2ff, #f8fafc);
}


.report-form-container {
    width: 100%;
    max-width: 640px;
    background: #ffffff;
    border-radius: 18px;
    padding: 36px;
    position: relative;

    box-shadow:
        0 25px 60px rgba(30, 64, 175, 0.15),
        0 5px 15px rgba(0, 0, 0, 0.05);

    border-top: 6px solid #2563eb;
}


.form-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
}

.form-header i {
    font-size: 26px;
    color: #2563eb;
}

.form-header h1 {
    font-size: 25px;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.form-subtitle {
    margin-bottom: 30px;
    color: #64748b;
    font-size: 14px;
}


.form-group-row {
    display: flex;
    gap: 22px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.form-group {
    flex: 1;
    min-width: 240px;
}

.form-group label {
    font-size: 14px;
    font-weight: 500;
    color: #475569;
    margin-bottom: 8px;
    display: block;
}


.input-with-icon {
    position: relative;
}

.input-with-icon input[type="date"] {
    width: 100%;
    padding: 14px 44px 14px 14px;
    border-radius: 12px;
    border: 1px solid #cbd5e1;
    font-size: 15px;
    color: #0f172a;
    background: #f8fafc;

    transition: all 0.25s ease;
}

.input-with-icon input:focus {
    outline: none;
    border-color: #2563eb;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.18);
}

.input-with-icon .fas {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 16px;
    color: #94a3b8;
}


.btn-generate {
    margin-top: 10px;
    width: 100%;
    padding: 15px;

    border-radius: 14px;
    border: none;

    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;

    font-size: 16px;
    font-weight: 600;
    letter-spacing: 0.3px;

    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;

    cursor: pointer;
    transition: all 0.25s ease;

    box-shadow: 0 15px 30px rgba(37, 99, 235, 0.4);
}

.btn-generate:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 40px rgba(37, 99, 235, 0.45);
}

.btn-generate:active {
    transform: translateY(0);
}

/* ====== MOBILE ====== */
@media (max-width: 600px) {
    .report-form-container {
        padding: 26px;
    }
}
</style>


</head>
<body>

    <div class="report-form-container">
        <header class="form-header">
    <i class="fas fa-file-pdf"></i>
    <h1>Attendance Report</h1>
</header>
<p class="form-subtitle">
    Select a date range to generate a professional attendance PDF report.
</p>

        <form class="attendance-form" method="POST" action="{{ route('report.generate') }}">
            @csrf
            <div class="form-group-row">
                
                <div class="form-group">
                    <label for="start-date">Start Date</label>
                    <div class="input-with-icon">
                        <input id="start-date" type="date" name="start_date" value="2025-12-01" required>
                        <i class="fas fa-calendar-alt"></i> 
                    </div>
                </div>

                <div class="form-group">
                    <label for="end-date">End Date (optional)</label>
                    <div class="input-with-icon">
                        <input type="date" id="end-date" name="end_date">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-generate">
    <i class="fas fa-download"></i>
    Generate PDF Report
</button>
        </form>
    </div>

</body>
</html>




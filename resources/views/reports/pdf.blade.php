<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #5B21B6;
        }
        .header h1 {
            color: #5B21B6;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 14px;
        }
        .info-section {
            background-color: #F3F4F6;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .info-label {
            font-weight: bold;
            color: #374151;
        }
        .info-value {
            color: #6B7280;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .stat-card {
            background-color: #F9FAFB;
            padding: 15px;
            border-left: 4px solid #5B21B6;
            border-radius: 5px;
        }
        .stat-label {
            font-size: 10px;
            color: #6B7280;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #5B21B6;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1F2937;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #E5E7EB;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        thead {
            background-color: #5B21B6;
            color: white;
        }
        th {
            padding: 10px 8px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #E5E7EB;
            font-size: 11px;
        }
        tr:hover {
            background-color: #F9FAFB;
        }
        .status-completed {
            background-color: #D1FAE5;
            color: #065F46;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #E5E7EB;
            text-align: center;
            color: #6B7280;
            font-size: 10px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>OJT PROGRESS REPORT</h1>
        <p>Internship Management System</p>
    </div>

    <!-- User Information -->
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Intern Name:</span>
            <span class="info-value">{{ $user->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">School:</span>
            <span class="info-value">{{ $user->school }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value">{{ $user->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Report Period:</span>
            <span class="info-value">{{ $start->format('F d, Y') }} to {{ $end->format('F d, Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Generated On:</span>
            <span class="info-value">{{ now()->format('F d, Y h:i A') }}</span>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Hours</div>
            <div class="stat-value">{{ number_format($totalHours, 2) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Days Completed</div>
            <div class="stat-value">{{ $daysCompleted }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Accomplishments</div>
            <div class="stat-value">{{ $accomplishmentsCount }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Avg Hours/Day</div>
            <div class="stat-value">{{ number_format($avgHoursPerDay, 2) }}</div>
        </div>
    </div>

    <!-- DTR Records Table -->
    <div class="section-title">Daily Time Records</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 20%;">Date</th>
                <th style="width: 15%;">Day</th>
                <th style="width: 15%;">Time In</th>
                <th style="width: 15%;">Time Out</th>
                <th style="width: 15%;">Hours</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dtrRecords as $dtr)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dtr->date->format('M d, Y') }}</td>
                    <td>{{ $dtr->date->format('l') }}</td>
                    <td>{{ $dtr->time_in ? \Carbon\Carbon::parse($dtr->time_in)->format('h:i A') : '-' }}</td>
                    <td>{{ $dtr->time_out ? \Carbon\Carbon::parse($dtr->time_out)->format('h:i A') : '-' }}</td>
                    <td><strong>{{ number_format($dtr->total_hours, 2) }} hrs</strong></td>
                    <td>
                        @if($dtr->status == 'completed')
                            <span class="status-completed">Completed</span>
                        @else
                            <span class="status-pending">Pending</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #9CA3AF;">
                        No DTR records found for this period
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Accomplishments Table -->
    <div class="section-title">Accomplishments</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 20%;">Date</th>
                <th style="width: 45%;">Task Description</th>
                <th style="width: 30%;">Tools/Technologies</th>
            </tr>
        </thead>
        <tbody>
            @forelse($accomplishments as $accomplishment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $accomplishment->date->format('M d, Y') }}</td>
                    <td>{{ $accomplishment->task_description }}</td>
                    <td>{{ $accomplishment->tools_used ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #9CA3AF;">
                        No accomplishments found for this period
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p><strong>OJTracker</strong> - Internship Management System</p>
        <p>This is a computer-generated report. No signature required.</p>
    </div>
</body>
</html>

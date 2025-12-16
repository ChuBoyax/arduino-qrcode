<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Scan Viewer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0f172a;         
            --card: #020617;       
            --accent: #e5e7eb;   
            --text: #e5e7eb;        
            --muted: #94a3b8;      
            --border: #1e293b;    
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        body {
            margin: 0;
            background: #DCE2E8;
            color: var(--text);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 1100px;
            margin: auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .header h1 {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .scanBtn {
            padding: 10px 16px;
            background: #2D9966;
            color: var(--accent);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 5px;
        }
        .table-card {
            background: rgba(2, 6, 23, 0.85);
            backdrop-filter: blur(12px);
            border-radius: 18px;
            border: 1px solid var(--border);
            box-shadow: 0 20px 40px rgba(0,0,0,0.45);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background: rgba(15, 23, 42, 0.9);
        }
        thead th {
            text-align: left;
            padding: 16px 18px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
        }
        tbody tr {
            transition: background 0.25s ease;
        }
        tbody tr:hover {
            background: rgba(34, 197, 94, 0.05);
        }
        tbody td {
            padding: 16px 18px;
            border-top: 1px solid var(--border);
            font-size: 14px;
        }
        .qr-data {
            font-family: monospace;
            color: #a5f3fc;
        }
        .badge {
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-success {
            background: rgba(34,197,94,0.15);
            color: #22c55e;
        }
        .footer {
            text-align: center;
            margin-top: 18px;
            font-size: 12px;
            color: var(--muted);
        }
        @media (max-width: 768px) {
            thead {
                display: none;
            }
            table, tbody, tr, td {
                display: block;
                width: 100%;
            }
            tbody tr {
                margin-bottom: 14px;
                border-radius: 14px;
                overflow: hidden;
                border: 1px solid var(--border);
            }
            tbody td {
                display: flex;
                justify-content: space-between;
                padding: 14px 16px;
                border: none;
                border-bottom: 1px solid var(--border);
            }
            tbody td::before {
                content: attr(data-label);
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: var(--muted);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    @include('_partials.footer')
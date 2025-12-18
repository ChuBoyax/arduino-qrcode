
@extends('_partials._header')

@section('content')
    <div>
        <div class="header">
            <h1 style="color: #000">QR Code Scan Viewer</h1>
            <a href="scan.blade.php" class="scanBtn">Start Scanning</a>
        </div>
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="#">1</td>
                        <td data-label="QR Data" class="qr-data">EMP-QR-928374</td>
                        <td data-label="Scanned By">Arduino Scanner</td>
                        <td data-label="Date">2025-12-15</td>
                        <td data-label="Time">10:45 AM</td>
                        <td data-label="Status"><span class="badge badge-success">Valid</span></td>
                    </tr>
                    <tr>
                        <td data-label="#">2</td>
                        <td data-label="QR Data" class="qr-data">STUDENT-QR-114299</td>
                        <td data-label="Scanned By">Arduino Scanner</td>
                        <td data-label="Date">2025-12-15</td>
                        <td data-label="Time">10:48 AM</td>
                        <td data-label="Status"><span class="badge badge-success">Valid</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="footer">
            View-only interface • Real-time data from Arduino QR Scanner
        </div>
    </div>
@endsection

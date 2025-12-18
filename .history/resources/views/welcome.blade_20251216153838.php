
@extends('_partials._header')

@section('content')
    <div>
        <div class="header">
            <h1 style="color: #000">Scanned Student List</h1>
            <a href=" {{route('scan')}} " class="scanBtn">Start Scanning</a>
        </div>
        <div class="table-card">
            <table id="list-table">
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

                </tbody>
            </table>
        </div>
        <div class="footer">
            View-only interface • Real-time data from Arduino QR Scanner
        </div>
    </div>

    <script>
        $(document).ready(function() {
            setInterval(async () => {
                const res = await fetch('/api/scan-result');
                const data = await res.json();

                if(!data) return;

                if(data.status == 'succes') {
                    console.log('New scan data received:', data.data);
                }

                if(data.status == 'error') {
                    console.error('Error fetching scan data:', data.message);
                }
            }, interval);
        })
    </script>

@endsection

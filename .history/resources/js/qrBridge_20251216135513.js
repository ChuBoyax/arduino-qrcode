import { SerialPort } from 'serialport';
import { ReadlineParser } from '@serialport/parser-readline';
// import axios from 'axios';

const port = new SerialPort({
    path: 'COM10',
    baudRate: 9600,
});

const parser = port.pipe(new ReadlineParser({ delimiter: '\n' }));
port.on('open', () => {
    console.log('Serial Port Opened');
})

parser.on('data', async (data) => {
    const url = data.trim();
    const parts = url.split('/');
    const qrToken = parts[parts.length -1];

    try {
        const res = await fetch('http://arduino-qrcode.test/api/fetch-student-data', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                qr_token: qrToken,
                url: url
            })
        });

        const response = await res.json();

        if(!response.success) {
            console.log('Error fetching student data:', response.message);
        }
    }catch(error) {
        console.error('Error during fetch:', error);
    }
})
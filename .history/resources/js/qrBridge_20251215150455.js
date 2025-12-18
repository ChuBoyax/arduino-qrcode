import { SerialPort } from 'serialport';
import { ReadlineParser } from '@serialport/parser-readline';
// import axios from 'axios';

const port = new SerialPort({
    path: 'COM11',
    baudRate: 9600,
});

const parser = port.pipe(new ReadlineParser({ delimiter: '\n' }));

parser.on('data', async (data) => {
    const url = data.trim();
    const parts = url.split('/');
    const hashed = parts[parts.length -1];
    console.log(`QR Code Scanned: ${hashed}`);

    try {
        const qrData = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });
        const qrJson = await qrData.json();

        console.log('QR code sent to server successfully.', qrJson);
    }catch(error) {
        console.error('Error sending QR code to server:', error);
    }
})
import { SerialPort } from 'serialport';
import { ReadlineParser } from '@serialport/parser-readline';
import axios from 'axios';

const port = new SerialPort({
    path: 'COM3',
    baudRate: 9600,
});

const parser = port.pipe(new ReadlineParser({ delimiter: '\n' }));

parser.on('data', async (data) => {
    const qr = data.trim();
    console.log(`QR Code Scanned: ${qr}`);

    try {
        await axios.post('http://arduino-qrcode.test/api/scan', { qr_code: qr });
        console.log('QR code sent to server successfully.');
    }catch(error) {
        console.error('Error sending QR code to server:', error);
    }
})
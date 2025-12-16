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
    console.log("Scanned URL:", url);

    try {
        const res = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });

        const text = await res.text(); // <- get raw text
        console.log('Raw response:', text);

        // Only parse JSON if it is JSON
        let qrJson;
        try {
            qrJson = JSON.parse(text);
            console.log('Parsed JSON:', qrJson);
        } catch (err) {
            console.error('Response is not valid JSON');
        }

    } catch(error) {
        console.error('Error during fetch:', error);
    }
});
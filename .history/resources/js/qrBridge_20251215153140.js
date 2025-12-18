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
    console.log('QR Code Data:', url);

})
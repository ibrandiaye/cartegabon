let chainParameter;

const MAX_READ_SIZE = 1034; // Transfer in MAX buffer size
const CCID_HDR_LEN = 10; // CCID header length

// listener for webusb device connection state.
navigator.usb.addEventListener('connect', event => {
    // Add 'event.device' to the UI.
    console.log("Webusb reader connected");
    isScardReaderAvailable = true;
    resetConfig();
});

// listener for webusb device disconnection state.
navigator.usb.addEventListener('disconnect', event => {
    // Remove 'event.device' from the UI.
    console.log("Webusb reader disconnected");
    isScardReaderAvailable = false;
    resetConfig();
    close();
    document.getElementById("connect").innerHTML = VALUE.CONNECT;
});

class WebUsbEly {

    constructor() {
        this.ENDPOINT_IN = 1;
        this.ENDPOINT_OUT = 1;
        this.ENDPOINT_INTERRUPT = 2; // Interrupt-IN Endpoint
    }

    wusbDev = null; // webusb device handler
    remainingSize = 0; // transferIn read completed
    actualRespLen = 0; // complete response length from transferIn

    /*
     * Filters the devices based on VID and PID.
     * Pops up whitelisted devices in the pop up window.
     * Selects the configuration of the device and claims the interface.
     */
    async open() {
        const filters = [ //only list below VID and PID device.
            {
                'vendorId': 0x2B_78,
                'productId': 0x3E_52
            } // ID READER WEBUSB Mode
        ];
        try {
            console_ely.log("Opening webusb devices\n");
            // webusb command to request a particular USB VID/PID device and get the corresponding object
            // If there is previously selected webusb device get device object
            let wusbDevices = await navigator.usb.getDevices();
            console_ely.log(wusbDevices);
            console_ely.log(wusbDevices.length);
            if (wusbDevices.length >= 1) {
                wusbDevices.forEach(x => {
                    if ((x.vendorId == 0x2b_78) && (x.productId == 0x3e_52)) {
                        console_ely.log(`device name ${x.productName}`);
                        this.wusbDev = x;
                    }
                });
            } else { // If there is no previously selected webusb device, request user to select device.
                await navigator.usb.requestDevice({
                    'filters': filters
                }).then(x => {
                    this.wusbDev = x;
                })
            }
            if (this.wusbDev) {
                this.wusbDev.open().then(() => {
                    if (this.wusbDev.configuration === null) {
                        console_ely.log("Device opened");
                        return this.wusbDev.selectConfiguration(1);
                    }
                }).then(() => {
                    console_ely.log("Device configuration selected");
                    return this.wusbDev.claimInterface(0); // bInterfaceNumber of ccid
                }).then(() => {
                    console_ely.log("Enumeration completed");
                    readerName = `${this.wusbDev.manufacturerName} CL Reader ${this.wusbDev.serialNumber.substring(24)}`;
                    gui.update(GUI.READER_PRESENT, readerName);
                    gui.update(GUI.RUN);
                    isScardReaderAvailable = true;
                    this.listenData();
                }).catch(error => {
                    console_ely.log(error, 4);
                });
            }
        } catch (error) {
            console_ely.log(error, 4);
        }
    }

    async close() {
        if (this.wusbDev) {
            this.wusbDev.close().then(() => {
                console_ely.log("Device closed");
            }).catch(error => {
                console_ely.log(error);
            });
        }
    }

    async isAvailable() {
        let devices = await navigator.usb.getDevices();
        console_ely.log(`Webusb device count: ${devices.length}`);
        if (devices.length >= 1) {
            isScardReaderAvailable = true;
        }
    }

    send(cmd) {
        if (this.wusbDev) {
            this.start = new Date().getTime();
            console_ely.log(`==> (Webusb) : ${util.toHexString(cmd)}`, 2);
            this.wusbDev.transferOut(this.ENDPOINT_IN, cmd); // send command to the CCID device.
        }
    }

    // Read the response and dispatch the result data.
    listenData() {
        let rxdLen = 0;
        let overallSize = 0;
        // find BULK out endpoint
        // TODO set transferIn length to value from ccid class descriptor
        let receive = () => {
            return this.wusbDev.transferIn(this.ENDPOINT_OUT, MAX_READ_SIZE).then(result => {
                // determine the actual response for the initial read
                if (0 === this.remainingSize) {
                    // Get actual response length
                    let ccidRespLen = result.data.getUint8(1) | result.data.getUint8(2) << 8 | result.data.getUint8(3) << 16 | result.data.getUint8(4) << 24;
                    this.actualRespLen = ccidRespLen + CCID_HDR_LEN;
                    this.u8Data = new Uint8Array(this.actualRespLen); // allocating buffer based on length received
                }
                // copy the response to the buffer
                for (let i = 0; i < result.data.byteLength; i++) {
                    this.u8Data[rxdLen + i] = result.data.getUint8(i);
                }
                chainParameter = this.u8Data[9];
                console_ely.log(`chainParameter value: ${chainParameter}`);
                rxdLen += result.data.byteLength; // calculating the received buffer length
                console_ely.log(`Actual response length: ${this.actualRespLen}, Bytes read: ${rxdLen}`, 1);
                if ((currentEvent != events.EVENT_GET_SLOT_STATUS) && (rxdLen == 10)) currentEvent = events.EVENT_FINAL;
                // Decide if we need to read the remaining bytes, if any
                if (this.actualRespLen == rxdLen) {
                    if (chainParameter == 1)
                        this.chainingData = new Uint8Array();
                    // data read complete
                    this.remainingSize = 0;
                    this.end = new Date().getTime();

                    console_ely.log(`<== (Webusb) ( ${this.u8Data.length}bytes): ${util.toHexString(this.u8Data)}`, 3);

                    if (chainParameter > 0) {
                        this.chainingData = util.appendUint8Arrays(this.chainingData, this.u8Data.slice(10));
                        if (chainParameter == 2) {
                            console_ely.log(`chainParameter: ${chainParameter}`);
                            console_ely.log(`<== (chainingData) ( ${this.chainingData.length}bytes): ${util.toHexString(this.chainingData)}`, 3);
                            // rxdLen = this.chainingData.length;
                            webEvents.responseHandler(this.chainingData, this.chainingData.length);
                        } else {
                            webEvents.responseHandler(this.u8Data, rxdLen);
                        }
                        rxdLen = 0;
                    } else {
                        // Success case - 0x9000
                        if (((this.u8Data[rxdLen - 2] == 0x90) && (this.u8Data[rxdLen - 1] === 0x00)) ||
                            (currentEvent == events.EVENT_SELECT_AID) || (currentEvent == events.EVENT_GET_SLOT_STATUS) ||
                            (currentEvent == events.EVENT_ICC_POWER_ON) || (currentEvent == events.EVENT_GET_ATR)) {                            // Display overall bytes received for the request
                            if (this.u8Data[rxdLen - 2] == 0x90) {
                                if (currentEvent == events.EVENT_READ_DG2) {
                                    if (isLogEnabled) {
                                        console_ely.timeTaken(`${rxdLen} Bytes | ${this.end - this.start} ms`);
                                    }
                                } else {
                                    console_ely.timeTaken(`${rxdLen} Bytes | ${this.end - this.start} ms`);
                                }
                            }
                            webEvents.responseHandler(this.u8Data, rxdLen);
                        }
                        // Error case - other than 0x9000
                        else {
                            console_ely.errorResponse(util.toHexString(this.u8Data).toUpperCase().toString().substring(29, this.u8Data.length * 3));
                            if (currentEvent == events.EVENT_SELECT_BAC || currentEvent == events.EVENT_SELECT_BAP || currentEvent == events.EVENT_SELECT_BAP_EU) {
                                console_ely.errorResponse(util.toHexString(this.u8Data).toUpperCase().toString().substring(20, this.u8Data.length * 3));
                            }
                            switch (currentEvent) {
                                case events.EVENT_SELECT_EF_CARD_ACCESS:
                                    currentEvent = ((pwdTypeSelected == PASSWORD_TYPE.MRZ) ?
                                        events.EVENT_SELECT_AID : events.EVENT_FINAL);
                                    break;
                                case events.EVENT_READ_DG2:
                                    break;
                                case events.EVENT_MUTUAL_AUTHENTICATION:
                                case events.EVENT_READ_DG1:
                                default:
                                    currentEvent = events.EVENT_FINAL;
                                    break;
                            }
                            webEvents.eventHandler();
                            // Display overall bytes received for the request
                        }
                        // Adjust overall byte length for statistics
                        overallSize += rxdLen;
                        rxdLen = 0;
                    }
                } else {
                    // Read remaining bytes
                    this.remainingSize = 1;
                }
                if (currentEvent != events.EVENT_FINAL) return receive();
            }).catch(error => {
                console_ely.log(error);
            });
        };
        if (currentEvent != events.EVENT_FINAL) return receive();
    }

    /*
     * Listen on given Interrupt-IN and debug log to console.
     * @param {UsbDevice} device - UsbDevice object
     * @param {Number} endpoint - desired Interrupt-IN endpoint. No checks done here.
     * @return {Promise} promise after setting up listener.
     */
    listenInterrupt() {
        // find interrupt endpoint
        // TODO set transferIn length to value from ccid class descriptor
        let receive = () => {
            try {
                return this.wusbDev.transferIn(this.ENDPOINT_INTERRUPT, 64).then(inResult => {
                    let txtDecoder = new TextDecoder();
                    let asciiStr = txtDecoder.decode(inResult.data);
                    let u8Data = new Uint8Array(asciiStr.length);
                    let i = 0;
                    for (i = 0; i < asciiStr.length; i++) u8Data[i] = inResult.data.getUint8(i);
                    console_ely.log(`Received interrupt data: ${util.toHexString(u8Data)}`);
                    if (u8Data[1] == 0x03) {
                        isCardPresent = true;
                        if (isAuthStarted) {
                            this.listenData();
                            isAuthStarted = false;
                        }
                    } else {
                        gui.update(GUI.CARD_ABSENT);
                        currentEvent = events.EVENT_FINAL;
                        isCardPresent = false;
                    }
                    return receive();
                }).catch(error => {
                    console_ely.log(error);
                });
            } catch (e) {

                console_ely.log(`ERROR: Exception captured during interrupt transfer: ${e}`, 4);
            }
        };
        return receive();
    }
}
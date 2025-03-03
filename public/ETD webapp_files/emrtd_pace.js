class PaceAuthentication {
    constructor(emrtdObj, deviceObj) {
        this.emrtd = emrtdObj;
        this.device = deviceObj;
    }
    efCardAccessData;
    domainCount = 0;
    isPaceCam = false;
    mappedData;
    aic;

    /*
     * Parse EF.CardAccess data
     */
    parseEfCardAccess(u8Data, length) {
        let position = (urlparams_pcsc == '1') ? 0 : CCID_HDR_LEN;
        let efCardAccessLen = length - position; // ignore CCID header 10 bytes
        this.efCardAccessData = new Uint8Array(efCardAccessLen);
        util.memcpy(this.efCardAccessData, u8Data, this.efCardAccessData.length, 0, position);

        let ret = this.emrtd.efCardAccess(this.efCardAccessData, efCardAccessLen);
        if (ret == -1) {
            console_ely.log("ERROR: openPace.efCardAccess failed", 4);
            return false;
        } else {
            console_ely.log(`EF.CardAccess: ${util.toHexString(this.efCardAccessData)}\nret: ${ret}`);
            return true;
        }
    }

    /*
     * MSE.AT
     */
    mseAt(pwdType) {
        let oid;
        let header;
        oid = this.emrtd.datagroup.webEvents.isCaSupportMseAt() ? this.emrtd.getCaOid() : this.emrtd.getPaceOid();
        if (oid == -1) {
            console_ely.log("ERROR: openPace.getOid() failed", 4);
            return false;
        }
        console_ely.log(`OID ${oid}`);
        let payload;
        switch (oid) {
            case 976: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x03, 0x01, 0x01]; break; }
            case 977: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x03, 0x01, 0x02]; break; }
            case 978: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x03, 0x01, 0x03]; break; }
            case 979: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x03, 0x01, 0x04]; break; }
            case 981: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x03, 0x02, 0x01]; break; }
            case 982: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x03, 0x02, 0x02]; break; }
            case 983: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x03, 0x02, 0x03]; break; }
            case 984: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x03, 0x02, 0x04]; break; }
            case 986: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x01, 0x01]; break; }
            case 987: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x01, 0x02]; break; }
            case 988: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x01, 0x03]; break; }
            case 989: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x01, 0x04]; break; }
            case 991: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x02, 0x01]; break; }
            case 992: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x02, 0x02]; break; }
            case 993: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x02, 0x03]; break; }
            case 994: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x02, 0x04]; break; }
            case 996: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x03, 0x01]; break; }
            case 997: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x03, 0x02]; break; }
            case 998: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x03, 0x03]; break; }
            case 999: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x03, 0x04]; break; }
            case 1001: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x04, 0x01]; break; }
            case 1002: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x04, 0x02]; break; }
            case 1003: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x04, 0x03]; break; }
            case 1004: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x04, 0x04]; break; }
            case 1006: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x06, 0x02]; break; }
            case 1007: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x06, 0x03]; break; }
            case 1008: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x06, 0x04]; break; }
            case 9996: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x06, 0x02]; break; }
            case 9997: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x06, 0x03]; break; }
            case 9998: { payload = [0x80, 0x0A, 0x04, 0x00, 0x7F, 0x00, 0x07, 0x02, 0x02, 0x04, 0x06, 0x04]; break; }
            default: {
                console_ely.log("ERROR: Invalid OID", 4);
                return false;
            }
        }
        // Include Tag83 to specify the selected password type
        if (!this.emrtd.datagroup.webEvents.isCaSupportMseAt()) {
            pwdType = (pwdType == PASSWORD_TYPE.MRZ) ? 0x01 : (pwdType == PASSWORD_TYPE.CAN) ? 0x02 : 0x03;
            payload.push(0x83, 0x01, pwdType);
        }
        // Include Tag84 if multiple domains exist
        if (this.domainCount > 1) { // todo: domainCount is always 0. Fix it.
            this.parameterId = this.emrtd.getPaceParameterId();
            console_ely.log(`this.parameterId is: ${this.parameterId}`);
            payload.push(0x84, 0x01, this.parameterId);
        }
        // Build MSE.AT APDU
        header = [0x00, 0x22, (this.emrtd.datagroup.webEvents.isCaSupportMseAt() ? 0x41 : 0xC1), 0xA4];
        let lc = payload.length;
        let le = -1;
        const CMD_MSE_AT = this.emrtd.createApdu(header, lc, payload, le);
        // Send command
        if (this.emrtd.datagroup.webEvents.isCaSupportMseAt()) {
            this.emrtd.buildSmCmd(CMD_MSE_AT);
            this.device.sendApdu(this.emrtd.getSmCmd());
        }
        else this.device.sendApdu(CMD_MSE_AT);
        return true;
    }

    /*
     * General authenticate encrypt nonce
     */
    generalAuthenticateEncNonce() {
        let header = [0x10, 0x86, 0x00, 0x00];
        let lc = 0x02;
        let payload = [0x7C, 0x00];
        let le = 0x00;
        const CMD_GENERAL_AUTHENTICATE = this.emrtd.createApdu(header, lc, payload, le);
        //const CMD_GENERAL_AUTHENTICATE = new Uint8Array([0x10, 0x86, 0x00, 0x00, 0x02, 0x7C, 0x00, 0x00]);
        this.device.sendApdu(CMD_GENERAL_AUTHENTICATE);
    }

    /*
     * General authenticate map nonce
     */
    generalAuthenticateMapNonce() {
        this.device.sendApdu(this.apduData);
        this.apduData = null;
    }

    /*
     * Perform key agreement
     */
    performKeyAgreement() {
        this.device.sendApdu(this.apduData);
        this.apduData = null;
    }

    /*
     * Mutual authenticate
     */
    mutualAuthenticate() {
        this.device.sendApdu(this.apduData);
        this.apduData = null;
    }

    /*
     * Read GA encrypt nonce from PICC
     */
    performGaEncryptNonce(u8Data, length, secret) {
        console_ely.logFuncName(this.performGaEncryptNonce.name);

        // Validate pwdTypeSelected
        if (!Object.values(PASSWORD_TYPE).includes(pwdTypeSelected)) {
            console.error("ERROR: Unknown password type");
            return false;
        }
        console.log(`Password type : ${pwdTypeSelected}`);
        console.log(`Password : ${secret}`);

        // Retrieve encrypted nonce
        let position = (urlparams_pcsc == '1') ? 0 : CCID_HDR_LEN; // ignore [CCID header]
        let tagList = [{ skip: position }, [0x7C], [0x80]];
        let encNonce = this.emrtd.unwrapTlvs(tagList, u8Data);
        if (encNonce == null) { console_ely.log("ERROR: Tag not found", 4); return false; }
        console_ely.logByArray("Encrypted Nonce", encNonce);

        let pwdType = (pwdTypeSelected == PASSWORD_TYPE.MRZ) ? 0x01 : (pwdTypeSelected == PASSWORD_TYPE.CAN) ? 0x02 : 0x03;
        let mappingDataLen = this.emrtd.initPace(util.strToByteArray(secret), secret.length, pwdType, encNonce, encNonce.length);
        if (mappingDataLen == -1) {
            console_ely.log("ERROR: openPace.initPace failed", 4);
            return false;
        }
        this.mappedData = this.emrtd.getPaceMapData(mappingDataLen);
        if (this.mappedData == -1) {
            console_ely.log("ERROR: openPace.getPaceMapData failed", 4);
            return false;
        }
        console_ely.logByArray("mapped data", this.mappedData, mappingDataLen);

        this.buildGa(0x10, 0x81, this.mappedData);
        return true;
    }

    /*
     * Read map nonce value from openpace
     */
    performGaMapNonce(u8Data, length) {
        console_ely.logFuncName(this.performGaMapNonce.name);
        console_ely.logByArray("u8Data", u8Data, length);

        let position = 0;
        let mappingData = null;
        let mapID = this.emrtd.getPaceMappingId();
        if (mapID == -1) {
            console_ely.log("ERROR: openPace.getPaceMappingId failed", 4);
            return false;
        }
        console_ely.log(`mapID : ${mapID}`);

        position = (urlparams_pcsc == '1') ? 0 : CCID_HDR_LEN;
        if (mapID == 1) {
            /*
             * deriving the mapping data's starting position based on the response length
             */
            if (length < 127) { // response length < 127
                position += 4;
            } else if (length < 255) { // response length < 255
                position += 6;
            } else { // response length > 255
                position += 8;
            }

            // copy the mapping data
            mappingData = new Uint8Array(length - position - 2); //  2 is for status word
            util.memcpy(mappingData, u8Data, mappingData.length, 0, position);

        } else {
            mappingData = new Uint8Array(this.mappedData.length);
            mappingData.set(this.mappedData);
        }

        console_ely.logByArray("mappingData", mappingData);

        let size = this.emrtd.getPaceMapGenerator(mappingData, mappingData.length);
        if (size == -1) {
            console_ely.log("ERROR: openPace.getPaceMapGenerator failed", 4);
            return false;
        }
        let ephemeralPubKeyPcdData = this.emrtd.getPaceEphemeralPubKeyPcdData(size);
        if (ephemeralPubKeyPcdData == -1) {
            console_ely.log("ERROR: openPace.getPaceEphemeralPubKeyPcdData failed", 4);
            return false;
        }
        console_ely.logByArray("Ephemeral pubkey from openpace", ephemeralPubKeyPcdData);

        this.buildGa(0x10, 0x83, ephemeralPubKeyPcdData);
        return true;
    }

    /*
     * Perform GA key agreement
     */
    performGaKeyAgreement(u8Data, length) {
        console_ely.logFuncName(this.performGaKeyAgreement.name);
        console_ely.logByArray("u8Data", u8Data, length);
        let position = 0;

        position = (urlparams_pcsc == '1') ? 0 : CCID_HDR_LEN;
        if (length < 127) { // response length < 127
            position += 4;
        } else if (length < 255) { // response length < 255
            position += 6;
        } else { // response length > 255
            position += 8;
        }

        if (length > (position - 2)) {
            // Ignore APDU header and SW
            let sharedSecret = new Uint8Array(length - position - 2);
            util.memcpy(sharedSecret, u8Data, sharedSecret.length, 0, position);
            console_ely.logByArray("Key agreement data", sharedSecret);

            let size = this.emrtd.computeSharedSecret(sharedSecret, sharedSecret.length);
            if (size == -1) {
                console_ely.log("Error: computeSharedSecret failed", 4);
                return false;
            }

            let token = this.emrtd.getPaceAuthenticateToken(size);
            if (token == -1) {
                console_ely.log("Error: getPaceAuthenticateToken failed", 4);
                return false;
            }

            console_ely.logByArray("Shared secret", token, size);
            this.buildGa(0x00, 0x85, token);
            return true;
        } else {
            return false;
        }
    }

    /*
     * Build General Authenticate
     */
    buildGa(cla, tag, cmdData) {
        console_ely.logFuncName(this.buildGa.name);
        const TAG_7C = 0x7C;
        this.apduData = [];
        if (cmdData == null) {
            console_ely("ERROR: invalid argument.", 4);
            return -1;
        }
        let tagData = this.emrtd.wrapTlv(tag, cmdData);
        let tag7cData = this.emrtd.wrapTlv(TAG_7C, tagData);
        this.apduData.push(cla);
        this.apduData.push(0x86);
        this.apduData.push(0x00);
        this.apduData.push(0x00);
        if (tag7cData.length < 256) {
            // short apdu
            this.apduData.push(tag7cData.length); // lc
            this.apduData.push(...tag7cData); // data
            this.apduData.push(0x00); // le
        } else {
            // extended apdu
            this.apduData.push(0x00); // lc
            this.apduData.push((tag7cData.length >> 8) & 0xFF); // lc
            this.apduData.push(tag7cData.length & 0xFF); // lc
            this.apduData.push(...tag7cData); // data
            this.apduData.push(0x00); // le
            this.apduData.push(0x00); // le
        }
        console_ely.logByArray("apduData", this.apduData);
        return this.apduData.length;
    }

    /*
     * External authenticate
     */
    externalAuthenticate(u8Data, length) {
        console_ely.log(`ExternalAuthenticate data from openpace: ${util.toHexString(u8Data)}`);
        this.device.sendApdu(u8Data);
    }

    parseMutualAuthenticate(u8Data, length) {
        console_ely.logByArray("MutualAuth data", u8Data);
        // remove the CCID header for WebUSB case.
        if (urlparams_pcsc == '0')
            u8Data = u8Data.slice(CCID_HDR_LEN);

        this.isPaceCam = false;
        // check if the card supports PACE-CAM, based on the R-APDU length and "0x8A" tag
        if (u8Data.length > 14) {
            let j = 0;
            let aicData = [];
            for (let i = 2; i < u8Data.length; i++) {
                aicData[j++] = u8Data[i];
            }
            console_ely.log(`AIC wrapped data: ${util.toHexString(aicData)}`);
            this.aic = this.emrtd.unwrapTlv([0x8A], aicData, aicData.length);
            console_ely.log(`AIC: ${util.toHexString(this.aic)}`);
            this.isPaceCam = true; // PACE-CAM to be performed.
        }
    }

    getAicData() {
        return this.aic;
    }

    doPaceCam(efCardSecurity) {
        console_ely.log("Perform PACE-CAM\n")
        console_ely.log(`AIC:\n${util.toHexString(this.aic)}\n`);
        console_ely.log(`EF.CardSecurity:\n${util.toHexString(efCardSecurity)}\n`);
        return this.emrtd.doPaceCam(this.aic, efCardSecurity);
    }
}

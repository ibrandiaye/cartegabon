class OpenPace {

    check(val, ref) {
        if (val === ref) {
            console.log(`Error: ${val} is ${ref}`);
            return -1;
        }
        return 0;
    }

    init() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module["_Eac_init"]();
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    ConfigureDetailedLogging(value) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module["_ConfigureDetailedLogging"](value);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    /**
     * send EF.card access data and length.
     * openpace will parse the data and fetch OID and
     * parameterID to initialize PICC EAC context.
     */
    efCardAccess(data, length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const buffer = Module._malloc(length);
            if (this.check(buffer, null) === -1)
                return -1;
            Module.HEAPU8.set(data, buffer);
            let ret = Module["_ef_cardaccess_parsing"](buffer, length);
            Module._free(buffer);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    getPaceParameterId() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module._Pace_get_parameter_id(1);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Collect generated mapping data from openpace.
    getCaEphemeralPubKey(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let ca_ephemeral_pubKey = Module.cwrap('Ca_get_ephemeral_pubkey', 'number', [])
            let ptr_from_wasm = ca_ephemeral_pubKey(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }


    // Get CA algorithm.
    getCaAlgorithmId() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module._Ca_get_alg_id(1);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Get CA OID.
    getCaOid() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module._Ca_get_oid(1);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Set SSC for CA.
    setCaSsc() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module["_Ca_init_secure_channel"](1);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }


    /**
     * Send secret CAN or PIN value, size, secret type, encrypt nonce and length.
     * openpace will generate secret key from given Secret value and initialize the EAC context.
     * openpace will decrypt the given encrypted nonce.
     * generate mapping data and send to the card.
     */
    initPace(secret, size, type, encnonce, length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const bufferSecret = Module._malloc(size);
            if (this.check(bufferSecret, null) === -1)
                return -1;
            Module.HEAPU8.set(secret, bufferSecret);
            const bufferEncNonce = Module._malloc(length);
            if (this.check(bufferEncNonce, null) === -1)
                return -1;
            Module.HEAPU8.set(encnonce, bufferEncNonce);
            let ret = Module["_Pace_init"](bufferSecret, size, type, bufferEncNonce, length);
            Module._free(bufferSecret);
            Module._free(bufferEncNonce);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Collect generated mapping data from openpace.
    getPaceMapData(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferMappingData = Module.cwrap('Pace_get_mapping_data', 'number', [])
            let ptr_from_wasm = bufferMappingData(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Collect mapping generator value.
    getPaceMapGenerator(mapPiccData, length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const bufferMapGeneratorData = Module._malloc(length);
            if (this.check(bufferMapGeneratorData, null) === -1)
                return -1;
            Module.HEAPU8.set(mapPiccData, bufferMapGeneratorData);
            let ret = Module._Pace_generate_ephemeral_key(bufferMapGeneratorData, length);
            Module._free(bufferMapGeneratorData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Collect ephemeral pubKey from openpace.
    getPaceEphemeralPubKeyPcdData(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferEphemeralPubKey = Module.cwrap('Pace_get_ephemeral_key', 'number', [])
            let ptr_from_wasm = bufferEphemeralPubKey(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Compute shared secret.
    computeSharedSecret(sharedSecret, length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const bufferSharedSecretData = Module._malloc(length);
            if (this.check(bufferSharedSecretData, null) === -1)
                return -1;
            Module.HEAPU8.set(sharedSecret, bufferSharedSecretData);
            let ret = Module._Pace_compute_authentication_token(bufferSharedSecretData, length);
            Module._free(bufferSharedSecretData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    doPaceCam(aic, efCardSecurity) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const bufferAicData = Module._malloc(aic.length);
            if (this.check(bufferAicData, null) === -1)
                return -1;
            Module.HEAPU8.set(aic, bufferAicData);
            const bufferEfCardSecurityData = Module._malloc(efCardSecurity.length);
            if (this.check(bufferEfCardSecurityData, null) === -1)
                return -1;
            Module.HEAPU8.set(efCardSecurity, bufferEfCardSecurityData);
            let ret = Module["_Pace_perform_paceCam"](bufferAicData, aic.length, bufferEfCardSecurityData, efCardSecurity.length)
            Module._free(bufferAicData);
            Module._free(bufferEfCardSecurityData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    doPassiveAuthentication(efSodBuffer, cscaCertBuffer, dsCertBuffer) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferEfSodData;
            let bufferCscaCertData;
            let bufferDsCertData;
            let bufferEfSodLength = 0;
            let bufferCscaCertLength = 0;
            let bufferDsCertLength = 0;

            if (efSodBuffer != null) {
                bufferEfSodLength = efSodBuffer.length;
                bufferEfSodData = Module._malloc(bufferEfSodLength);
                if (this.check(bufferEfSodData, null) === -1)
                    return -1;
                Module.HEAPU8.set(efSodBuffer, bufferEfSodData);
            }
            if (cscaCertBuffer != null) {
                bufferCscaCertLength = cscaCertBuffer.length;
                bufferCscaCertData = Module._malloc(bufferCscaCertLength);
                if (this.check(bufferCscaCertData, null) === -1)
                    return -1;
                Module.HEAPU8.set(cscaCertBuffer, bufferCscaCertData);
            }
            if (dsCertBuffer != null) {
                bufferDsCertLength = dsCertBuffer.length;
                bufferDsCertData = Module._malloc(bufferDsCertLength);
                if (this.check(bufferDsCertData, null) === -1)
                    return -1;
                Module.HEAPU8.set(dsCertBuffer, bufferDsCertData);
            }
            let ret = Module["_Pa_perform_passive_auth"](bufferEfSodData, bufferEfSodLength,
                bufferCscaCertData, bufferCscaCertLength,
                bufferDsCertData, bufferDsCertLength);
            Module._free(bufferEfSodData);
            Module._free(bufferCscaCertData);
            Module._free(bufferDsCertData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    doHashVerification(dsData, dgNum) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const bufferDgData = Module._malloc(dsData.length);
            if (this.check(bufferDgData, null) === -1)
                return -1;
            Module.HEAPU8.set(dsData, bufferDgData);
            let ret = Module["_Pa_verify_hash"](bufferDgData, dsData.length, dgNum);
            Module._free(bufferDgData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    /*
     * Perform chip authentication data
     */
    doChipAuthentication(data, length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const buffer = Module._malloc(length);
            if (this.check(buffer, null) === -1)
                return -1;
            Module.HEAPU8.set(data, buffer);
            let ret = Module["_Perform_Chip_Auth"](buffer, length);
            Module._free(buffer);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    doPsoVerifyCertificate(certBuffer, certId) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferCertData;
            let bufferCertLength;
            if (certBuffer != null) {
                bufferCertLength = certBuffer.length;
                bufferCertData = Module._malloc(bufferCertLength);
                if (this.check(bufferCertData, null) === -1)
                    return -1;
                Module.HEAPU8.set(certBuffer, bufferCertData);
            }
            let ret = Module["_Ta_perform_pso_verify_certificate"](bufferCertData, bufferCertLength, certId);
            Module._free(bufferCertData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    getCvcBodyLength() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module._Ta_get_cvc_body_length(1);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    getCvcSignatureLength() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module._Ta_get_cvc_signature_length(1);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    getCvcChrLength() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module._Ta_get_cvc_chr_length(1);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    getTaSignedDataLength() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let signedDataLength = Module._Ta_get_signed_data_Length(1);
            console.log("signedDataLength ", signedDataLength);
            return signedDataLength;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    getCvcBody(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferCvcBodyData = Module.cwrap('Ta_get_cvc_body', 'number', []);
            let ptr_from_wasm = bufferCvcBodyData(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    getCvcSignature(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferCvcSignatureData = Module.cwrap('Ta_get_cvc_signature', 'number', []);
            let ptr_from_wasm = bufferCvcSignatureData(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    getCvcChr(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferCvcChrData = Module.cwrap('Ta_get_cvc_chr', 'number', []);
            let ptr_from_wasm = bufferCvcChrData(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    taSignData(pksc_cert, nonceBuffer, is_cert) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferPkscData;
            let bufferPkscLength;
            let bufferNonceData;
            let bufferNonceLength;
            let bufferIsData;
            let bufferIsLength;
            if (pksc_cert != null) {
                bufferPkscLength = pksc_cert.length;
                bufferPkscData = Module._malloc(bufferPkscLength);
                if (this.check(bufferPkscData, null) === -1)
                    return -1;
                Module.HEAPU8.set(pksc_cert, bufferPkscData);
            }
            if (nonceBuffer != null) {
                bufferNonceLength = nonceBuffer.length;
                bufferNonceData = Module._malloc(bufferNonceLength);
                if (this.check(bufferNonceData, null) === -1)
                    return -1;
                Module.HEAPU8.set(nonceBuffer, bufferNonceData);
            }
            if (is_cert != null) {
                bufferIsLength = is_cert.length;
                bufferIsData = Module._malloc(bufferIsLength);
                if (this.check(bufferIsData, null) === -1)
                    return -1;
                Module.HEAPU8.set(is_cert, bufferIsData);
            }
            let ret = Module._Ta_sign_data(bufferPkscData, bufferPkscLength,
                bufferNonceData, bufferNonceLength,
                bufferIsData, bufferIsLength);
            Module._free(bufferPkscData);
            Module._free(bufferNonceData);
            Module._free(bufferIsData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    getTaSignedData(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferSignedData = Module.cwrap('Ta_get_signed_data', 'number', []);
            let ptr_from_wasm = bufferSignedData(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Generate random from IFD
    getIfdRnd() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let length = 8;
            let bufferIfdRndData = Module.cwrap('Get_ifd_rnd', 'number', []);
            let ptr_from_wasm = bufferIfdRndData(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Check if AA-ECDSA is required
    getAaKeyType(publicKeyData) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferPublicKeyData;
            let bufferPublicKeyDataLength;
            if (publicKeyData != null) {
                bufferPublicKeyDataLength = publicKeyData.length;
                bufferPublicKeyData = Module._malloc(bufferPublicKeyDataLength);
                if (this.check(bufferPublicKeyData, null) === -1)
                    return -1;
                Module.HEAPU8.set(publicKeyData, bufferPublicKeyData);
            }
            let ret = Module._Aa_get_ecdsa_status(bufferPublicKeyData, bufferPublicKeyDataLength);
            Module._free(bufferPublicKeyData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Perform ActiveAuth.
    performActiveAuth(publicKeyData, signedData, dg14Data) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferDg14Data;
            let bufferPublicKeyData;
            let bufferSignedData;
            let bufferDg14Length = 0;
            let bufferPublicKeyDataLength;
            let bufferSignedLength;
            if (dg14Data != null) {
                bufferDg14Length = dg14Data.length;
                bufferDg14Data = Module._malloc(bufferDg14Length);
                if (this.check(bufferDg14Data, null) === -1)
                    return -1;
                Module.HEAPU8.set(dg14Data, bufferDg14Data);
            }
            if (publicKeyData != null) {
                bufferPublicKeyDataLength = publicKeyData.length;
                bufferPublicKeyData = Module._malloc(bufferPublicKeyDataLength);
                if (this.check(bufferPublicKeyData, null) === -1)
                    return -1;
                Module.HEAPU8.set(publicKeyData, bufferPublicKeyData);
            }
            if (signedData != null) {
                bufferSignedLength = signedData.length;
                bufferSignedData = Module._malloc(bufferSignedLength);
                if (this.check(bufferSignedData, null) === -1)
                    return -1;
                Module.HEAPU8.set(signedData, bufferSignedData);
            }
            let ret = Module["_Perform_Active_auth"](bufferDg14Data, bufferDg14Length,
                bufferPublicKeyData, bufferPublicKeyDataLength,
                bufferSignedData, bufferSignedLength);
            Module._free(bufferDg14Data);
            Module._free(bufferPublicKeyData);
            Module._free(bufferSignedData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Collect mutual authenticate token.
    getPaceAuthenticateToken(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let token = Module.cwrap('Pace_get_authenticate_token', 'number', [])
            let ptr_from_wasm = token(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Openpace will encrypt the given buffer and length.
    encrypt(plainData, length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const bufferPlainData = Module._malloc(length);
            if (this.check(bufferPlainData, null) === -1)
                return -1;
            Module.HEAPU8.set(plainData, bufferPlainData);
            let ret = Module._Eac_encrypt(bufferPlainData, length);
            Module._free(bufferPlainData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Collect encrypted data.
    getPaceEncryptedData(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferEncBuffer = Module.cwrap('Eac_get_encrypted_data', 'number', [])
            let ptr_from_wasm = bufferEncBuffer(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Authenticate the given buffer.
    authenticate(plainData, length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const bufferPlainData = Module._malloc(length);
            if (this.check(bufferPlainData, null) === -1)
                return -1;
            Module.HEAPU8.set(plainData, bufferPlainData);
            let ret = Module._Eac_authenticate(bufferPlainData, length);
            Module._free(bufferPlainData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Collect authenticated data.
    getAuthenticatedData(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let authenticatedBuffer = Module.cwrap('Eac_get_mac_data', 'number', [])
            let ptr_from_wasm = authenticatedBuffer(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Add padding to given buffer
    addPadding(plainData, length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const bufferPlainData = Module._malloc(length);
            if (this.check(bufferPlainData, null) === -1)
                return -1;
            Module.HEAPU8.set(plainData, bufferPlainData);
            let ret = Module._Eac_addpad(bufferPlainData, length);
            Module._free(bufferPlainData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Collect padded buffer from openpace.
    getPaddedData(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferPaddedData = Module.cwrap('Eac_padded_data', 'number', [])
            let ptr_from_wasm = bufferPaddedData(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Decrypt the given buffer.
    decrypt(encryptedData, length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const bufferEncryptedData = Module._malloc(length);
            if (this.check(bufferEncryptedData, null) === -1)
                return -1;
            Module.HEAPU8.set(encryptedData, bufferEncryptedData);
            let ret = Module._Eac_decrypt(bufferEncryptedData, length);
            Module._free(bufferEncryptedData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Collect decrypted buffer.
    getDecryptedData(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferDecryptedData = Module.cwrap('Eac_get_decrypted_data', 'number', []);
            let ptr_from_wasm = bufferDecryptedData(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Input values are no longer used,
    // It is automatically incremented by openpace.
    incrementSsc() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module["_Eac_increment_ssc"]();
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Initialize BAC 
    initBac() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module["_Bac_init"](1);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Get challenge for the given buffer.
    getBacChallenge(encryptedData, length, secret, size, auth) {
        try {
            const AUTH_BAC_ID = 1;
            const AUTH_BAP_ID = 2;
            let authId = (auth == AuthType.BAP) ? AUTH_BAP_ID : AUTH_BAC_ID;
            if (this.check(Module, undefined) === -1)
                return -1;
            const bufferData = Module._malloc(length);
            if (this.check(bufferData, null) === -1)
                return -1;
            Module.HEAPU8.set(encryptedData, bufferData);
            const mrzData = Module._malloc(size);
            if (this.check(mrzData, null) === -1)
                return -1;
            Module.HEAPU8.set(secret, mrzData);
            let ret = Module._Bac_get_challenge(bufferData, length, mrzData, size, authId);
            Module._free(bufferData);
            Module._free(mrzData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Collect external authenticate buffer.
    getExternalAuthenticateData(length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            let bufferExternalAuthenticateData = Module.cwrap('Bac_get_ext_auth_command_data', 'number', []);
            let ptr_from_wasm = bufferExternalAuthenticateData(length);
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + length);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Decrypt cryptogram in the given buffer.
    decryptCryptogram(encryptedData, length) {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const bufferEncryptedData = Module._malloc(length);
            if (this.check(bufferEncryptedData, null) === -1)
                return -1;
            Module.HEAPU8.set(encryptedData, bufferEncryptedData);
            let ret = Module["_Bac_verify_and_decrypt_cryptogram"](bufferEncryptedData, length);
            Module._free(bufferEncryptedData);
            return ret;
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Get PACE OID.
    getPaceOid() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module._Pace_get_oid(1);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Get PACE algorithm.
    getPaceMappingId() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module["_Pace_get_mapping_id"](1);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Get OpenPACE version.
    getOpenpaceVersion() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            const ptr_from_wasm = Module.cwrap('Eac_openPACE_version', 'number', [])();
            let i = 0;
            while (Module.HEAPU8[ptr_from_wasm + i] != 0) {
                i++;
            }
            return Module.HEAPU8.subarray(ptr_from_wasm, ptr_from_wasm + i);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }

    // Cleanup memory of openpace library.
    cleanup() {
        try {
            if (this.check(Module, undefined) === -1)
                return -1;
            return Module["_Eac_deinit"](1);
        } catch (e) {
            console.log(e);
            return -1;
        }
    }
}

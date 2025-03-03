class BioMini {
    deviceInfos =  null;
    deviceIndex = 0;
    gPreviewFailCount = 0;
    pageID;
    gIsCaptureEnd;
    gIsFingerOn = false;
    urlStr = "http://localhost:8084";
    bioScannerHandle;
    bioScannerType = null;
    bioScannerName = null;
    decodedWsqData = null;
    listOfIndices = [];

    // Init BioMini Scanner
    initBioScanner() {
        console_ely.logFuncName(this.initBioScanner.name);
        this.pageID = Math.random();
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                type : "GET",
                url : `${this.urlStr}/api/initDevice?dummy=${Math.random()}`,
                dataType : "json",
                success : (msg) => {
                    console_ely.log(`Init: ${msg.retString}`);
                    if(msg.retValue == 0) {
                        this.deviceInfos = msg.ScannerInfos;
                        this.bioScannerType = this.deviceInfos[this.deviceIndex].DeviceType;
                        this.bioScannerName = this.deviceInfos[this.deviceIndex].ScannerName;
                        this.bioScannerHandle = this.deviceInfos[this.deviceIndex].DeviceHandle;
                        console_ely.log("DeviceInfos:");
                        console_ely.log("   DeviceHandle: ", this.bioScannerHandle);
                        console_ely.log("   DeviceType: ", this.bioScannerType);
                        console_ely.log("   ScannerName: ", this.bioScannerName);
                        resolve("success");
                    } else {
                        console_ely.log("Error: initBioScanner failed");
                        resolve("error");
                    }
                },
                error : function(request, status, error) {
                    console.log("Error: request ", request);
                    console.log("Error: status ", status);
                    console.log("Error: error ", error);
                    reject("error");
                }
            });
        });
    }

    // Get scanner details
    getScannerDetails() {
        console_ely.logFuncName(this.getScannerDetails.name);
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                type : "GET",
                url : `${this.urlStr}/api/getScannerStatus?dummy=${Math.random()}`,
                dataType : "json",
                data : {
                    sHandle: this.bioScannerHandle,
                    sIndex: this.deviceInfos[this.deviceIndex].DeviceIndex
                },
                success : (msg) => {
                    console_ely.log(`getScannerStatus: ${msg.retString}`);
                    if(msg.retValue == 0) {
                        console_ely.log("   SensorValid: ", msg.SensorValid);
                        console_ely.log("   SensorOn: ", msg.SensorOn);
                        console_ely.log("   IsCapturing: ", msg.IsCapturing);
                        console_ely.log("   IsFingerOn: ", msg.IsFingerOn);
                        resolve("success");
                    } else {
                        console_ely.log("Error: getScannerDetails failed");
                        resolve("error");
                    }
                },
                error : function(request, status, error) {
                    console.log("Error: request ", request);
                    console.log("Error: status ", status);
                    console.log("Error: error ", error);
                    reject("error");
                }
            });
        });
    }

    // Deinit BioMini scanner
    deinitBioScanner() {
        console_ely.logFuncName(this.deinitBioScanner.name);
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                type : "GET",
                url : `${this.urlStr}/api/uninitDevice?dummy=${Math.random()}`,
                dataType : "json",
                success : (msg) => {
                    this.deviceInfos = null;
                    resolve("success");
                },
                error : function(request, status, error) {
                    console.log("Error: request ", request);
                    console.log("Error: status ", status);
                    console.log("Error: error ", error);
                    reject("error");
                }
            });
        });
    }

    // Auto capture
    autoCapture() {
        console_ely.logFuncName(this.autoCapture.name);
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                type : "GET",
                url : `${this.urlStr}/api/autoCapture?dummy=${Math.random()}`,
                data : {
                    sHandle: this.bioScannerHandle,
                    id: this.pageID
                },
                success : (msg) => {
                    console_ely.log(`Auto capture:${msg.retString}`);
                    resolve("success");
                },
                error : function(request, status, error) {
                    console.log("Error: request ", request);
                    console.log("Error: status ", status);
                    console.log("Error: error ", error);
                    reject("error");
                }
            });
        });
    }

    // Auto capture loop
    async autoCaptureLoop() {
        console_ely.logFuncName(this.autoCaptureLoop.name);
        let loopFlag;
        return new Promise((resolve, reject) => {
            const checkFinger = () => {
                this.getCaptureEnd();
                if (this.gIsFingerOn) {
                    console_ely.log("Auto Capture detected a finger.");
                    this.gIsFingerOn = false;
                    this.gPreviewFailCount = 0;
                    resolve("success");
                } else if (this.gPreviewFailCount < 30) {
                    loopFlag = setTimeout(checkFinger, 1000);
                    this.gPreviewFailCount++;
                } else {
                    this.gPreviewFailCount = 0;
                    console_ely.log("Error: 30s timeout. End autoCaptureLoop()");
                    resolve("timeout");
                }
            };
            checkFinger();
        });
    }


    // Get capture end
    async getCaptureEnd() {
        console_ely.logFuncName(this.getCaptureEnd.name);
        let gLfdScore;
        jQuery.ajax({
            type : "GET",
            url : `${this.urlStr}/api/getCaptureEnd?dummy=${Math.random()}`,
            dataType : "json",
            async: false,
            data : {
                sHandle: this.bioScannerHandle,
                id: this.pageID
            },
            success : (msg) => {
                this.gIsFingerOn = msg.IsFingerOn;
                this.gIsCaptureEnd = msg.captureEnd;
                gLfdScore = msg.lfdScore;
            },
            error : function(request, status, error) {
                console.log("Error: request ", request);
                console.log("Error: status ", status);
                console.log("Error: error ", error);
            }
        });
    }

    // Abort capture
    abortCapture() {
        console_ely.logFuncName(this.abortCapture.name);
        let delayVal = 30000;
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                type : "GET",
                url : `${this.urlStr}/api/abortCapture?dummy=${Math.random()}`,
                dataType : "json",
                data : {
                    sHandle: this.bioScannerHandle,
                    resetTimer: delayVal
                }, 
                success : (msg) => {
                    resolve("success");
                },
                error : function(request, status, error) {
                    console.log("Error: request ", request);
                    console.log("Error: status ", status);
                    console.log("Error: error ", error);
                    reject("error");
                }
            });
        });
    }

    /**
     * Perform verification with an image file.
     * 
     * @param {ArrayBuffer} data - The binary data of the image file to be verified.
     * @returns {Promise<string>} A Promise that resolves with a string indicating the verification result ('success' or 'error').
     */
    verifyWithImageFile(data) {
        console_ely.logFuncName(this.verifyWithImageFile.name);

        // Convert array to Uint8Array
        let uint8Array = new Uint8Array(data);
        // Create a Blob from Uint8Array
        let blob = new Blob([uint8Array]);
        // Return a Promise for asynchronous handling
        return new Promise((resolve, reject) => {
            let jsonData = {
                'dummy': Math.random(),
                'HND': this.bioScannerHandle,
                'ID': this.pageID,
                'IMG_TYP' : 2
            };
            // Create a FormData object and append the image blob and JSON data to it.
            let formData = new FormData();
            formData.append('file', blob);
            formData.append('param', JSON.stringify(jsonData));
            jQuery.ajax({
                type : "POST",
                url: `${this.urlStr}/api/VerifyWithImageFile`,
                data : formData,
                processData:false,
                contentType:false,
                success : (msg) => {
                    console_ely.log(`Verify result : ${msg.verifySucceed}`);
                    console_ely.log(`Verify score : ${msg.score}`);
                     if(msg.retValue == 0) {
                        resolve((msg.verifySucceed == 1) ? "success" : "error");
                    } else {
                        console.log("Error: verifyWithImageFile failed");
                        resolve("error");
                    }
                },
                error : function(request, status, error) {
                    console.log("Error: request ", request);
                    console.log("Error: status ", status);
                    console.log("Error: error ", error);
                    reject("error");
                }
            });
        });
    }

    /**
     * Convert WSQ data to an image buffer.
     * 
     * @param {ArrayBuffer} wsqData - The binary data of the WSQ file to be converted.
     * @returns {Promise<string>} A Promise that resolves with a string indicating the conversion result ('success' or 'error').
     */
    wsqToImageBuffer(wsqData) {
        console_ely.logFuncName(this.wsqToImageBuffer.name);
        this.decodedWsqData = null;    
        // Convert array to Uint8Array
        let uint8Array = new Uint8Array(wsqData);
        // Create a Blob from Uint8Array
        let wsqBlobData = new Blob([uint8Array]);
        // Return a Promise for asynchronous handling
        return new Promise((resolve,reject)=>{
            // Prepare JSON data to be sent along with the WSQ blob
            let jsonData = {
                'dummy': Math.random(),
                'HND': this.bioScannerHandle,
                'ID': this.pageID,
                'IMG_TYP': 3 //jpg
            };
            let formData = new FormData();
            formData.append('file', wsqBlobData);
            formData.append('param', JSON.stringify(jsonData));
    
            jQuery.ajax({
                type: "POST",
                url: `${this.urlStr}/api/wsqFileToImageBufferByType`,
                data: formData,
                processData: false,
                contentType: false,
                success: (msg) => {
                    console_ely.log(`WSQ to image buffer result ${msg.retValue}`);
                    console_ely.log(`WSQ to image buffer message ${msg.retString}`);
                    if (msg.retValue == 0) {
                        this.decodedWsqData = msg.B64_IMG;
                        console_ely.log(`decodedWsqData : ${this.decodedWsqData}`);
                        // Resolve the Promise with 'success'
                        resolve("success");
                    } else {
                        console.log("Error: wsqToImageBuffer failed");
                        resolve("error");
                    }
                },
                error: function(request, status, error) {
                    console.log("Error: request ", request);
                    console.log("Error: status ", status);
                    console.log("Error: error ", error);
                    // Resolve the Promise with 'error'
                    reject("error");
                }
            });
        });
    }

    /*
     * Function to find the starting index of a subarray in the given array
     * Parameters:
     *   - subarray: The subarray to search for
     *   - start   : Optional parameter specifying the starting index for the search
     */
    findIndices(dataArray, subarray, start = 0) {
        // Iterate through the array, considering possible starting indices
        for (let i = start; i < dataArray.length - subarray.length + 1; i++) {
            let isMatchFound = true;

            // Check if the subarray matches at the current position
            for (let j = 0; j < subarray.length; j++) {
                if (dataArray[i + j] !== subarray[j]) {
                    // Break the loop if there is a mismatch
                    isMatchFound = false;
                    break;
                }
            }

            // If a match is found, return the starting index
            if (isMatchFound) {
                return i;
            }
        }

        // Return -1 if the subarray is not found in the array
        return -1;
    }

    /**
     * Function to get the count of WSQ images in the given data array.
     * @param {Uint8Array} dataArray - The array containing WSQ image information.
     * @returns {number} - The count of WSQ images.
     */
    getWsqImageCount(dataArray) {
        let index = [];
        let imageCount = 0;

        // Variables to keep track of the image count and list of start and end indices
        this.listOfIndices = [];

        // Check if the data array is not null
        if (dataArray === null) {
            return;
        }
        const wsqTagSoi = [0xFF, 0xA0]; // WSQ tag for Start of Image
        const wsqTagEoi = [0xFF, 0xA1]; // WSQ tag for End of Image
    
        let position = this.findIndices(dataArray, wsqTagSoi);
    
        // Loop through the array to find WSQ image start and end tags
        while (position !== -1) {
            index.push(position);
            position = this.findIndices(dataArray, wsqTagEoi, position);
    
            // If the end tag is found, update indices and increment image count
            if (position !== -1) {
                position = position + 1;
                index.push(position);
                this.listOfIndices.push(index);
                index = [];
                imageCount++;
            }
    
            // Find the next WSQ image start tag
            position = this.findIndices(dataArray, wsqTagSoi, position);
        }
    
        // Return the count of WSQ images
        console.log("Num WSQ images: ", imageCount);
        return imageCount;
    }

    /**
     * Retrieves data from the specified indices in the given dataArray.
     *
     * @param {Uint8Array} dataArray - The array containing the data.
     * @param {Array} indexList - List of pairs [startIndex, endIndex] specifying the range of indices to retrieve.
     * @returns {Array} An array containing the data slices corresponding to the specified indices.
     */
    retrieveDataFromIndices(dataArray, indexList) {
        const resultArray = [];

        // Iterate through each pair of indices in the indexList
        for (const indices of indexList) {
            const [startIndex, endIndex] = indices;

            // Check if the indices are valid
            if (startIndex >= 0 && endIndex < dataArray.length && startIndex <= endIndex) {
                // Slice the dataArray to get the data corresponding to the indices
                const subArray = dataArray.slice(startIndex, endIndex + 1);
                resultArray.push(subArray);
            } else {
                // Log an error for invalid indices
                console.error('Invalid indices: ', indices);
            }
        }

        console.log("List of WSQ data: ", resultArray);
        return resultArray;
    }

    /**
     * Function to retrieve WSQ data from a given array.
     * If the WSQ image count is not already calculated, it calculates it.
     * @param {Uint8Array} data - The array containing WSQ image information.
     */
    retrieveWsqData(data) {
        console_ely.logFuncName(this.retrieveWsqData.name);
        let wsqImageCount = 0;

        // Get WSQ image count and list of indices
        wsqImageCount = this.getWsqImageCount(data);
        if (wsqImageCount > 0 && this.listOfIndices.length > 0) {
            // Retrieve and log WSQ data from the specified indices
            let wsqData = this.retrieveDataFromIndices(data, this.listOfIndices);
            return wsqData;
        }

        return null;
    }
}
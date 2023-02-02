// General elements
const main_container_right = document.querySelector(".main_container_right");
// Upload elements
const upload_container = document.querySelector(".upload_container");
const upload_file_field = document.querySelector("#upload-input");
const upload_start_button = document.querySelector(".upload_start-button");
const upload_button_icon = document.querySelector(".upload-button_icon > i");
const upload_input = document.querySelector("#upload-input");
// Download elements
const download_container = document.querySelector(".download_container");
const download_id_field = document.querySelector("#download_id");
const download_passcode_field = document.querySelector("#download_passcode");
const download_start_button = document.querySelector(".download_start-button");

// 
// Download
// 

function openDownloadSettings() {
    main_container_right.style.gridTemplateRows = "3fr 9fr";
    download_container.style.display = "block";
    window.setTimeout(() => download_container.style.opacity = 1, 1000);
    download_id_field.addEventListener("input", checkDownloadSettingsInput);
}

function checkDownloadSettingsInput() {
    if (download_id_field.value.length != 4) {
        download_start_button.style.visibility = "hidden";
        download_passcode_field.style.visibility = "hidden";
        return;
    }
    // Check passcode
    $.ajax({
        url: "/res/php/checkPasscode.php",
        type: "POST",
        data: {
            file_passcode: download_passcode_field.value,
            file_id: download_id_field.value
        },
        success: function(data) {
            if (data == "NOPASS") {
                download_start_button.style.visibility = "visible";
                download_passcode_field.closest("p").style.visibility = "hidden";
                return;
            }
            download_passcode_field.addEventListener("input", checkDownloadSettingsInput);
            if (data == "FALSEPASS") {
                download_start_button.style.visibility = "hidden";
                download_passcode_field.style.visibility = "visible";
                return;
            }
            if (data == "TRUEPASS") {
                download_start_button.style.visibility = "visible";
                download_passcode_field.style.visibility = "visible";
                return;
            }
        }
    });
}

function download() {
    $.ajax({
        url: "/res/php/getDownloadToken.php",
        type: "POST",
        data: {
            file_id: download_id_field.value,
            file_passcode: download_passcode_field.value
        },
        success: function(data) {
            if (!data.startsWith("?DT=")) {
                download_start_button.style.color = "#f00";
                return;
            }
            window.location.assign("/download/" + data);
        }
    });
}

// 
// Upload
//
upload_file_field.addEventListener("change", openUploadSettings);

function openUploadSettings() {
    main_container_right.style.gridTemplateRows = "3fr 9fr";
    upload_container.style.display = "block";
    window.setTimeout(() => upload_container.style.opacity = 1, 1000);
}

function upload() {
    let form_data = new FormData();
    form_data.append("upload", upload_input.files[0]);
    form_data.append("use_passcode", "0");
    form_data.append("autodelete", "1");
    $.ajax({
        url: "./res/php/upload.php",
        method: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            console.log("Uploading file...");
        },
        success: function(data) {
            console.log(data);
            data = JSON.parse(data);
            console.log(data);
            if (!data.success) {
                console.log("ERROR");
                return;
            }
            if (data.file_id == null) {
                console.log("No file id");
                return;
            }
            console.log("File uploaded");
            console.log("File id: " + data.file_id);
            console.log("File passcode: " + data.file_passcode);
        },
        error: function(e) {
            console.log("Error");
            console.log(e);
        }
    });
}
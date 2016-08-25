function getPdf()
{
    var ax = getXMLHttpRequest();
    ax.open('POST', "[your servlet url]",true);
    ax.onreadystatechange=function() {
        if (ax.readyState == 4 && ax.status == 200) {
            var dataFormContainer = document.getElementById("dataFormContainer");
            var response = eval("(" + ax.responseText + ")");
            if (response.successful) {
                var url = "data:application/pdf;base64," + response.pdf;
                var _iFrame = document.createElement('iframe');
                _iFrame.setAttribute('src', url);
                dataFormContainer.appendChild(_iFrame);
            }
        }
    };
    ax.send();


    function toDataUrl(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.responseType = 'blob';
        xhr.onload = function () {
            var reader = new FileReader();
            reader.onloadend = function () {
                callback(reader.result);
            };
            reader.readAsDataURL(xhr.response);
        };
        xhr.open('GET', url);
        xhr.send();
    }

}
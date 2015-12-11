//xmlhttp.js

// HTTP通信用関数
function createXMLHttpRequest( cbFunc ) {
  var XMLhttpObject = null;
  try{
    XMLhttpObject = new XMLHttpRequest();
  }catch(e){
    try{
      XMLhttpObject = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
      try{
        XMLhttpObject = new ActiveXObject("Microsoft.XMLHTTP");
      }catch(e){
        return null;
      }
    }
  }
  if (XMLhttpObject) XMLhttpObject.onreadystatechange = cbFunc;
  return XMLhttpObject;
}

function loadHTMLFile( fName ) {
  httpObj = createXMLHttpRequest( displayData );
  if (httpObj) {
    httpObj.open( "GET", fName, true );
    httpObj.send( null );
  }
}

function displayData() {
  if ( (httpObj.readyState == 4) && (httpObj.status == 200) ) {
    document.getElementById("mycaljp").innerHTML = unescape( httpObj.responseText );
  }
}

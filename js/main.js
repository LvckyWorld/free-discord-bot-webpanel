
for (let i = 0; i < document.getElementsByClassName('card').length; i++) {
    document.getElementsByClassName('card')[i].addEventListener('click', function() {
        this.classList.toggle('flip');
    });
}

function sendData( data ) {
  
    const XHR = new XMLHttpRequest();
  
    let urlEncodedData = "",
        urlEncodedDataPairs = [],
        name;
  
    for( name in data ) {
      urlEncodedDataPairs.push( encodeURIComponent( name ) + '=' + encodeURIComponent( data[name] ) );
    }
  
    urlEncodedData = urlEncodedDataPairs.join( '&' ).replace( /%20/g, '+' );
  
    XHR.addEventListener( 'load', function(event) {
    } );
  
    XHR.addEventListener( 'error', function(event) {
    } );
  
    XHR.open( 'POST', './ban.php' );
  
    XHR.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
  
    XHR.send( urlEncodedData );
  }
function printpage(id) {
//alert(ctrl);
var DocumentContainer = document.getElementById(id);
//alert(DocumentContainer);
var WindowObject = window.open('', "TrackHistoryData", "width=250,height=500,top=10,left=0,toolbars=no,scrollbars=no,status=no,resizable=no");
//alert(ctrl);
//alert(DocumentContainer);
WindowObject.document.write("<html><head><body style='margin:0px; padding:0px; white-space:nowrap !important; margin-left:0px; padding-left:0px; '>");

WindowObject.document.write(DocumentContainer.innerHTML);
WindowObject.document.write('</body></html>');
//alert(ctrl);
WindowObject.document.close();
WindowObject.focus();
WindowObject.print();
//WindowObject.close(); 
} ;
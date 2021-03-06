	function print_today() {
  // ***********************************************
  // URL: ABHISHEK KUMAR MISHRA
  // URL: http://www.infinitewebsoft.com
  // Use the script, just leave this message intact.

  // ***********************************************
  var now = new Date();
  var months = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
  var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
  function fourdigits(number) {
    return (number < 1000) ? number + 1900 : number;
  }
  var today =  months[now.getMonth()] + " " + date + ", " + (fourdigits(now.getYear()));
  return today;
}

// from http://www.mediacollege.com/internet/javascript/number/round.html
function roundNumber(number,decimals) {
  var newString;// The new rounded number
  decimals = Number(decimals);
  if (decimals < 1) {
    newString = (Math.round(number)).toString();
  } else {
    var numString = number.toString();
    if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
      numString += ".";// give it one at the end
    }
    var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
    var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
    var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
    if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
      if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
        while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
          if (d1 != ".") {
            cutoff -= 1;
            d1 = Number(numString.substring(cutoff,cutoff+1));
          } else {
            cutoff -= 1;
          }
        }
      }
      d1 += 1;
    } 
    if (d1 == 10) {
      numString = numString.substring(0, numString.lastIndexOf("."));
      var roundedNum = Number(numString) + 1;
      newString = roundedNum.toString() + '.';
    } else {
      newString = numString.substring(0,cutoff) + d1.toString();
    }
  }
  if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
    newString += ".";
  }
  var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
  for(var i=0;i<decimals-decs;i++) newString += "0";
  //var newNumber = Number(newString);// make it a number if you like
  return newString; // Output the result to the form field (change for your purposes)
}

function update_total() {
  var total = 0;
  $('.price').each(function(i){
    price = $(this).html().replace("Rs ","");
    if (!isNaN(price)) total += Number(price);
  });

  total = roundNumber(total,2);

  $('#subtotal').html("Rs "+total);
  $('#total').html("Rs "+total);
  document.getElementById('overallamount').value=total;
  update_balance();
}

function update_balance() {
  var due = $("#total").html().replace("Rs ","") - $("#paid").val().replace("Rs ","");
  due = roundNumber(due,2);
  $('.due').html("Rs "+due);
  document.getElementById('dueamount').value=due;
}

function update_price() {
  var row = $(this).parents('.item-row');
  var price = row.find('.cost').val().replace("Rs ","") * row.find('.qty').val();
  price = roundNumber(price,2);
  isNaN(price) ? row.find('.price').html("N/A") : row.find('.price').html("Rs "+price);
  isNaN(price) ? row.find('.price_cost').html("N/A") : row.find('.price_cost').html("<input type='hidden' name='priceval[]' value='"+price+"'/>");
  update_total();
}

function bind() {
  $(".cost").blur(update_price);
  $(".qty").blur(update_price);
}

$(document).ready(function() {

  $('input').click(function(){
    $(this).select();
  });

  $("#paid").blur(update_balance);
   
 /* $("#addrow").click(function(){
    $(".item-row:last").after('<tr class="item-row"><td class="item-name"><div class="delete-wpr"><select name="product_headers" class="form-control"><option value="1">-- Headers --</option></select><a class="delete" href="javascript:;" title="Remove row">X</a></div></td><td class="description"><select name="product_type" class="form-control"><option value="1">-- Product Type --</option></select></td><td><input type="text" name="cost" class="cost form-control" /></td><td><input type="text" name="qty" class="qty form-control" /></td><td><span class="price">Rs 0.00</span> <input type="hidden" name="price[]" class="amtprice" value="" /></td></tr>');
    if ($(".delete").length > 0) $(".delete").show();
    bind();
  });*/
  
  bind();
  
  $(".delete").live('click',function(){
    $(this).parents('.item-row').remove();
    update_total();
    if ($(".delete").length < 2) $(".delete").hide();
  });
  

  
  $("#date").val(print_today());
  
});
		
function CommaFormatted(amount) {

var newDecimalVal = amount.split('.');
    if (amount == '-')
        return amount;
    amount = amount.replace(new RegExp('[,]', 'g'), '');
    //alert(amount);
    var i = parseInt(amount);
	
    if(isNaN(i)) 
    { 
        
        return ''; 
    }
	
    var minus = '';
    var minusWord = '';
    if (i<0)
        {
        i = -1 * i;
        minus = '-';
        minusWord = 'Minus ';
        }
		
    var n = new String(i);
    var newVal = '';
    var newValWords = '';
    if (i <= 1000)
    {
       
       return minus+n;
    }
	
    newVal = n.substring(n.length -3);
	
  
	
    newVal = ','+newVal;
    var whatsLeft = n.substring(0, n.length -3);
    i = parseInt(whatsLeft);
    var cnt = 1;
    var croreAmount = '';
    while (i > 99)
{
    var last2 = whatsLeft.substring(whatsLeft.length -2);
    whatsLeft = whatsLeft.substring(0, whatsLeft.length -2);
    newVal = ','+last2 +newVal;
  
    i = parseInt(whatsLeft);
 }

    newVal = whatsLeft + newVal;
  if(newDecimalVal[1]>0)
  {
    return minus+newVal+'.'+newDecimalVal[1];
  }
  else
  {
	  return minus+newVal;
  }
}


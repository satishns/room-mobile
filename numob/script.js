<script type="text/javascript">

function removeOptionSelected()
{
  var elSel = document.getElementById('suid_id');
  var i;
  for (i = elSel.length - 1; i>=0; i--) {
    if (elSel.options[i].selected) {
      elSel.remove(i);
    }
  }
}

function addExtUser()
{
	  //alert('Res. received');
 srch_uid=document.getElementById('suid_id').value

    //alert('Res :'+xmlhttp.responseText);
   var table = document.getElementById("exttbl_id");

	 sruid_s=srch_uid;
	 sruname_s=srch_uid;
	 
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var cell2 = row.insertCell(0);
    cell2.innerHTML = sruname_s;

     var cell21 = row.insertCell(1);
cell21.width="10";
    
    var cell3 = row.insertCell(2);
    var element2 = document.createElement("input");
    element2.type = "number";
    element2.size="10";
    element2.readOnly=true;
    element2.name='share_'+sruid_s;
    element2.id='share_'+sruid_s;
    cell3.appendChild(element2);
    cell3.innerHTML+="<img onclick='reSort(\""+sruid_s+"\");' id='img_"+sruid_s+"' width='15' height='15' src='../images/delete_icon.png' />";

       document.getElementById('frnds_cnt').value=parseInt(document.getElementById('frnds_cnt').value)+1;
if(isNumber(document.getElementById('tamnt').value))
       splitAmnt();
removeOptionSelected();
//End of addExtUser
}

function divtypechange() {
alert('in divtypechange');
	if(document.getElementById("divtype_id").checked)
		{
		for(i=0; i<document.transform.elements.length; i++)
		{ 
			elename=document.transform.elements[i].name;
			if( elename.indexOf('share_')==0)
		{
				id_name=elename.substr(6);
			//	alert('>'+id_name);
				document.getElementById('img_'+id_name).style.visibility="visible";
				document.transform.elements[i].readOnly=true;
			
		}
		}
		splitAmnt();
	}
	else {
		for(i=0; i<document.transform.elements.length; i++)
		{ 
			elename=document.transform.elements[i].name;
			if( elename.indexOf('share_')==0)
		{
				document.transform.elements[i].value="";
				id_name=elename.substr(6);
			//	alert('>'+id_name);
				document.getElementById('img_'+id_name).style.visibility="hidden";
				document.transform.elements[i].readOnly=false;
				}
		}
	}
	}
	function lookup(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("rpc.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	} // lookup
	
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
	}
</script>
<script>
function reSort(id_t){
img_src=document.getElementById('img_'+id_t).src;
if(img_src.indexOf('delete_icon')>=0)
{
	document.getElementById('frnds_cnt').value=parseInt(document.getElementById('frnds_cnt').value)-1;
	document.getElementById('img_'+id_t).src="../images/add.png";
	splitAmnt();
}
else
{
	document.getElementById('frnds_cnt').value=parseInt(document.getElementById('frnds_cnt').value)+1;
	document.getElementById('img_'+id_t).src="../images/delete_icon.png";
	splitAmnt();
}
}


function onstart()
{
dt=new Date();
dt_f=dt.getDate()+"-"+(dt.getMonth()+1)+"-"+dt.getFullYear();
document.getElementById('tdate').value=dt_f;
}

function toSubmit()
{
	tot_t=0;
	if(!isNumber(document.getElementById('tamnt').value))
	{
alert('Amount should be Numeric');return false;
		}
	
		for(i=0; i<document.transform.elements.length; i++)
		{ 
			elename=document.transform.elements[i].name;
		eleval=document.transform.elements[i].value;
		
			if( elename.indexOf('share_')==0)
				{
				if(eleval=='')
				{
					document.transform.elements[i].value=0;
					eleval=document.transform.elements[i].value;
				}
				if(!isNumber(eleval))
					{
						alert('User Shares should be Numeric'); return false;
						}
				tot_t+=parseInt(document.transform.elements[i].value);
				}

			
		}
		document.getElementById("totrat_id").value=tot_t;
		
	//alert('totrat :'+document.getElementById("totrat_id").value);
	//alert('about to submit');
	document.getElementById('action').value='store';
//alert('Value Set');
	return true;
}

function isNumber(n) {
	  return !isNaN(parseFloat(n)) && isFinite(n);
	}
function splitAmnt()
{
	js_amnt=document.getElementById('tamnt').value;
	js_frnds=document.getElementById('frnds_cnt').value;
	//alert('js_frnds :'+js_frnds);
if( document.getElementById("divtype_id").checked)
{	if(isNumber(js_amnt)) {
	//alert(js_amnt+'<>'+js_frnds);
	//alert('Split:'+js_amnt/js_frnds);
	for(i=0; i<document.transform.elements.length; i++)
	{ 
		elename=document.transform.elements[i].name;
//alert('elename >'+elename+'<');
		if( elename.indexOf('share_')==0)
	{
			id_name=elename.substr(6);
		//	alert('>'+id_name);
			img_src=document.getElementById('img_'+id_name).src;
			if(img_src.indexOf('delete_icon')>=0)
			{
				splt=js_amnt/js_frnds;
				 document.transform.elements[i].value = Math.round(splt*100)/100;
			}
			else
			{
				document.transform.elements[i].value=0;
			}
		
	}
	}
} else {
	alert('Amount should be numeric');
	document.getElementById('tamnt').focus();
}
	
}

}
</script>
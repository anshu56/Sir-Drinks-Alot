<script type="text/javascript">
//--- Begin Customizations ---------
var pctTop = "0%";
var pctLeft = "0%"; 
var imageIs = "Sir DrinksALot2.png"; // put path and file name here
var nLeft = 0;
var nTop = 0;
//--- End Customizations -----------

var absStr = "Position:Absolute;Top:"+pctTop+";Left:"+pctLeft+"";

function stayHome(){	

iL = document.body.scrollLeft;	
iV = document.body.scrollTop;	
isFloat.style.left = nLeft;	
isFloat.style.top = iV+nTop;
}

//window.onscroll = stayHome;
function goHome(){
window.location="http://rustagi1.projects.cs.illinois.edu/DrinksAlot/home.php";
}
function insertFloatIMG(){

styleStr = "<Style>.imgFloat {"+absStr+";Margin-Left:0px;Margin-Right:0px;Margin-Top:0px;Margin-Bottom:0px;}</Style>";

divStr = "<DIV class=imgFloat id=isFloat><input type=image src=null onClick=\"goHome()\" id=fIMG alt='Describe the Image'></DIV>"

document.write(styleStr);
document.write(divStr);
fIMG.src = imageIs;
nLeft = isFloat.offsetLeft;
nTop = isFloat.offsetTop; 

}

</script>

<p>
<script type="text/javascript">
	insertFloatIMG();
</script>
</p>

<h2 style="text-align: right;">
Sir Drinks-A-Lot
</h2>
<h3>
Drink Responsibly...
</h3> 
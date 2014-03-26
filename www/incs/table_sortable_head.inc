	<style type="text/css">
	body{
		font-size:0.8em;
		font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;
	}
	table thead td{
		font-weight:bold;
		cursor:pointer;
	}
	/* If you wish to highlight current sortable column, add layout effects below */
	.highlightedColumn{

		}}
	</style>

	<script type="text/javascript">

	var tableWidget_okToSort = true;
	var tableWidget_arraySort = new Array();
	tableWidget_tableCounter = 1;
	var activeColumn = new Array();
	var currentColumn = false;

	function sortNumeric(a,b){

		a = a.replace(/,/,'.');
		b = b.replace(/,/,'.');
		a = a.replace(/[^\d\.\/]/g,'');
		b = b.replace(/[^\d\.\/]/g,'');
		if(a.indexOf('/')>=0)a = eval(a);
		if(b.indexOf('/')>=0)b = eval(b);
		return a/1 - b/1;
	}


	function sortString(a, b) {

	  if ( a.toUpperCase() < b.toUpperCase() ) return -1;
	  if ( a.toUpperCase() > b.toUpperCase() ) return 1;
	  return 0;
	}

	function sortTable()
	{
		if(!tableWidget_okToSort)return;
		tableWidget_okToSort = false;
		/* Getting index of current column */
		var obj = this;
		var indexThis = 0;
		while(obj.previousSibling){
			obj = obj.previousSibling;
			if(obj.tagName=='TD')indexThis++;
		}

		if(this.getAttribute('direction') || this.direction){
			direction = this.getAttribute('direction');
			if(navigator.userAgent.indexOf('Opera')>=0)direction = this.direction;
			if(direction=='ascending'){
				direction = 'descending';
				this.setAttribute('direction','descending');
				this.direction = 'descending';
			}else{
				direction = 'ascending';
				this.setAttribute('direction','ascending');
				this.direction = 'ascending';
			}
		}else{
			direction = 'ascending';
			this.setAttribute('direction','ascending');
			this.direction = 'ascending';
		}

		var tableObj = this.parentNode.parentNode.parentNode;
		var tBody = tableObj.getElementsByTagName('TBODY')[0];

		var widgetIndex = tableObj.getAttribute('tableIndex');
		if(!widgetIndex)widgetIndex = tableObj.tableIndex;

		if(currentColumn)currentColumn.className='';
		document.getElementById('col' + widgetIndex + '_' + (indexThis+1)).className='highlightedColumn';
		currentColumn = document.getElementById('col' + widgetIndex + '_' + (indexThis+1));


		var sortMethod = tableWidget_arraySort[widgetIndex][indexThis]; // N = numeric, S = String
		if(activeColumn[widgetIndex] && activeColumn[widgetIndex]!=this){
			if(activeColumn[widgetIndex])activeColumn[widgetIndex].removeAttribute('direction');
		}

		activeColumn[widgetIndex] = this;

		var cellArray = new Array();
		var cellObjArray = new Array();
		for(var no=1;no<tableObj.rows.length;no++){
			var content= tableObj.rows[no].cells[indexThis].innerHTML+'';
			cellArray.push(content);
			cellObjArray.push(tableObj.rows[no].cells[indexThis]);
		}

		if(sortMethod=='N'){
			cellArray = cellArray.sort(sortNumeric);
		}else{
			cellArray = cellArray.sort(sortString);
		}

		if(direction=='descending'){
			for(var no=cellArray.length;no>=0;no--){
				for(var no2=0;no2<cellObjArray.length;no2++){
					if(cellObjArray[no2].innerHTML == cellArray[no] && !cellObjArray[no2].getAttribute('allreadySorted')){
						cellObjArray[no2].setAttribute('allreadySorted','1');
						tBody.appendChild(cellObjArray[no2].parentNode);
					}
				}
			}
		}else{
			for(var no=0;no<cellArray.length;no++){
				for(var no2=0;no2<cellObjArray.length;no2++){
					if(cellObjArray[no2].innerHTML == cellArray[no] && !cellObjArray[no2].getAttribute('allreadySorted')){
						cellObjArray[no2].setAttribute('allreadySorted','1');
						tBody.appendChild(cellObjArray[no2].parentNode);
					}
				}
			}
		}

		for(var no2=0;no2<cellObjArray.length;no2++){
			cellObjArray[no2].removeAttribute('allreadySorted');
		}

		tableWidget_okToSort = true;


	}
	function initSortTable(objId,sortArray)
	{
		var obj = document.getElementById(objId);
		obj.setAttribute('tableIndex',tableWidget_tableCounter);
		obj.tableIndex = tableWidget_tableCounter;
		tableWidget_arraySort[tableWidget_tableCounter] = sortArray;
		var tHead = obj.getElementsByTagName('THEAD')[0];
		var cells = tHead.getElementsByTagName('TD');
		for(var no=0;no<cells.length;no++){
			if(sortArray[no]){
				cells[no].onclick = sortTable;
			}else{
				cells[no].style.cursor = 'default';
			}
		}
		for(var no2=0;no2<sortArray.length;no2++){	/* Right align numeric cells */
			if(sortArray[no2] && sortArray[no2]=='N')obj.rows[0].cells[no2].style.textAlign='left';
		}

		tableWidget_tableCounter++;
	}

//THIS SECTION IS THE ROW ADD & DELETE SECTION

	        function addRow(tableID, formID) {
 
            var table = document.getElementById(tableID);
 		    var form = document.getElementById(formID);  

            var rowCount = table.rows.length;
            var row = table.insertRow(1);
            var uniqueID = Date.now();
 			
 			var cell_delete_box =row.insertCell(0);
 			var chkbx_delete = document.createElement("input");
 			chkbx_delete.type="checkbox";
 			chkbx_delete.name="chkbx_dl"+uniqueID;
 			cell_delete_box.appendChild(chkbx_delete);

            
            var cell_pn = row.insertCell(1);
            var txtbx_pn = document.createElement("input");
            txtbx_pn.type="text";
            txtbx_pn.style.width = '100px';
            txtbx_pn.name = "txtbx_pn"+uniqueID;
            cell_pn.appendChild(txtbx_pn);

            var cell_desc = row.insertCell(2);
            cell_desc.innerHTML = '(description)';
  
  	 	    var cell_itemnum = row.insertCell(3);
            var txtbx_itemnum = document.createElement("input");
            txtbx_itemnum.type = "text";
            txtbx_itemnum.style.width = '25px';
            txtbx_itemnum.name = "txtbx_itemnum"+uniqueID;
            cell_itemnum.appendChild(txtbx_itemnum);

			var cell_qty = row.insertCell(4);
            var txtbx_qty = document.createElement("input");
            txtbx_qty.type = "text";
           	txtbx_qty.name = "txtbx_qty"+uniqueID;
            txtbx_qty.style.width = '25px';
            cell_qty.appendChild(txtbx_qty);

            var cell_desc = row.insertCell(5);
            cell_desc.innerHTML = '(UoM)';

 			form.appendChild(chkbx_delete,
	 						txtbx_pn,
	 						txtbx_itemnum,
	 						txtbx_qty);
        }
	        
 
        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
 
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                } 
            }
            }catch(e) {
                alert(e);
            }
        }

 		//THIS IS THE ORIGINAL DELETEROW FUNCTION
        function deleteRow1(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
 
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                } 
            }
            }catch(e) {
                alert(e);
            }
        } 

	</script>
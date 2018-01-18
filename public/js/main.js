// Balance
function clearform(link){
    $("#mutationform")[0].reset();
    $('#description').val('');
    $("#Mid").text('');
    $("#add").text("add");
    $('#mutationform').prop('action', link);
    $("#PP").text('');
  return false; 
};

// Balance
function setprice(){
    
    var size = parseInt($("#size").val());
    console.log(size);
    if(isNaN(size)){var size=0;}
    var sum = checksum();
    if(sum !== 0){
    $("#PP").text('\u20AC'+ Math.round((size/sum)*100)/100);
    }
}

// Balance
function contentEdit(mutid,link,mutcount){
   
    var countTD=$("#mutationtable > tbody > tr:eq(1) > td").length;
    
    var date = $('#mut'+mutid+' td:nth-child(3)').text(); 
    var size = parseFloat($('#mut'+mutid+' td:nth-child(4)').text().substring(1));
    var description = $('#mut'+mutid+' td:nth-child(5)').text();
    var user = $('#mut'+mutid+' td:nth-child(6)').text();
    var PP = $('#mut'+mutid+' td:nth-child(7)').text();
    var newdate = date.split("-").reverse().join("-");
    var userid = $('option:contains("'+user+'")').attr('id');
    
    var users = [];
    for (var i=8; i <= countTD-2; i++){
       
        var weight = parseInt($('#mut'+mutid+' td:nth-child('+i+')').text());

        if(isNaN(weight)){ var weight=0; }
        
        users.push(weight);
    }
   
        function getSum(total, num) {
            return total + num;
        }
    
    var sum = users.reduce(getSum);

    var expectedtotal = sum*parseFloat(PP.substring(1));
    
    if(!$('#overviewtable tr > td:contains("'+user+'")').length || (expectedtotal < 0.98*size || expectedtotal > 1.02*size)){    
        alert('You are trying to edit a mutation that is connected to a removed user. This is not possible!');
        return false; 
    }
    
    $('#mutationform').prop('action', link+'/edit/'+mutcount);
    $("#Mid").text(mutid);
    $("#date").val(newdate);
    $("#size").val(size);
    $("#PP").text(PP);
    $("#description").text(description);
    $("#user").val(userid);
    
    for (var i=1; i <= countTD-9; i++){
    $("#u"+i).val(users[i-1]);
    }
    
    $("#add").text("edit");
    
    var $form = $('form');
    editformstate = setform(); 
    return editformstate;
}    

// Balance
function contentDelete(mutid, url){
       
    var size = parseFloat($('#mut'+mutid+' td:nth-child(4)').text().substring(1));
    var user = $('#mut'+mutid+' td:nth-child(6)').text();
    var PP = $('#mut'+mutid+' td:nth-child(7)').text();
    var countTD=$("#mutationtable > tbody > tr:eq(1) > td").length;
    
    var users = [];
    for (var i=8; i <= countTD-2; i++){
    var weight = parseInt($('#mut'+mutid+' td:nth-child('+i+')').text());
    
    if(isNaN(weight)){var weight=0;}
    users.push(weight);
    }
    
    function getSum(total, num) {
    return total + num;
    }
    var sum = users.reduce(getSum);
    
    var expectedtotal = sum*parseFloat(PP.substring(1));
     
    if(!$('#overviewtable tr > td:contains("'+user+'")').length || (expectedtotal < 0.98*size || expectedtotal > 1.02*size)){
        alert('You are trying to delete a mutation that is connected to a removed user. This is not possible!');
        return false; 
    } else{
        var check = confirm('Are you sure to delete this item?');
        if(check){
            window.location.href = url; 
        }
        return false;
    }
   
};

// Balance 
function checksum(){
        
    var countTD=$("#mutationtable > tbody > tr:eq(1) > td").length;
    var users = [];
    for (var i=1; i < countTD-8; i++){
    var weight = parseInt($("#u"+i).val());

    if(isNaN(weight)){var weight=0;}
    users.push(weight);
    }
    
    function getSum(total, num) {
    return total + num;
    }
    
    var sum = users.reduce(getSum);
    return sum; 
    }

var lastid = 1;

// Balance form     
function appendform(old_email, old_member) {
    
    var lastinputid = $('#usercontainer > div:last > :nth-child(2) > input').attr('id');
    if(lastinputid){
    var lastid = parseInt(lastinputid.substring(5))+1;
    } else {
        var lastid = 2;
    }
   
    var container = document.getElementById("usercontainer");
    var block = document.createElement("div");
    block.className = "form-group row";
    container.appendChild(block);
    
    // email input
    var column = document.createElement("div");
    column.className = "col-sm-1";
    block.appendChild(column);
    var label = document.createElement("label");
    var t = document.createTextNode("Email");  
    label.appendChild(t);  
    column.appendChild(label);
    
    var column = document.createElement("div");
    column.className = "col-md-5";
    block.appendChild(column);
    var input = document.createElement("input");
    input.type = "text";
    input.className= "form-control"
    input.id = 'email' + lastid;
    input.name = 'email' + lastid;
    input.value = old_email;
    input.required = true;
    column.appendChild(input);
    
    // name input
    var column = document.createElement("div");
    column.className = "col-sm-1";
    block.appendChild(column);
    var label = document.createElement("label");
    var t = document.createTextNode("Name");  
    label.appendChild(t);  
    column.appendChild(label);
    
    var column = document.createElement("div");
    column.className = "col-md-5";
    block.appendChild(column);
    var input = document.createElement("input");
    input.type = "text";
    input.className= "form-control"
    input.id = 'member' + lastid;
    input.name = 'member' + lastid;
    input.value = old_member;
    input.required = true;
    column.appendChild(input);
   
}

function cutform() {
    var emailinput = $('#usercontainer > div:last > :nth-child(2) > input');
    console.log(emailinput.val());
    var nameinput = $('#usercontainer > div:last > div:last > input');
    var lastrow = $('#usercontainer > div:last');
    if(emailinput && emailinput.val() || nameinput && nameinput.val()){
     if(window.confirm("Are you sure? You are removing a line with a name and/or email!")){
        lastrow.remove();
     }
    } else {
    lastrow.remove();
    }
}
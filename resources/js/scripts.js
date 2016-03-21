$(document).ready(function(){
    
    
    //some vars needed soon
    var counter1 = 0;
    var counter2 = 0;
    var ingred = [];
    var newIngred = [];
    var ddl = $('#ingredients');
    var newingredient = $('#newingredient');
    var typeNew = $('#typeNew');
    var type = $('#type');
    var ingrQuantity = $('#ingrQuantity');
    var newIngrQuantity = $('#newIngrQuantity');
    var getJsn;
    var title = $('#title');
    var procedure = $('#procedure');
    var justNames = [];
    
    $('#selectIngredientButton').prop('disabled',true);
    $('#newIngredientButton').prop('disabled',true);
    
    //populate drop down list from JSON storing JSON in var getJsn
    //minus already selected ingredients if we are editing the recipe
    $.getJSON("api/ingredients", function(result) {
        for (var i = 0; i < result.length; i++) {
            justNames.push(result[i].name);
        }
        //console.log(justNames);
        $('#selected li').each(function() {
            var name = $(this).attr('id');
            var quantity = $(this).attr('quantity');
            var type = $(this).attr('type');
            
            var pos = $.inArray(name,justNames);
            
            //TOFINISH
            console.log(name+" "+quantity+" "+type);
            //ingred.push(name);
            
            if (pos > -1){
                console.log("rimuovo "+name+" pos->"+pos);
                justNames.splice(pos,1);
            }
        });
        //console.log(justNames);
        $.each(justNames,function(i,v){
            ddl.append('<option value="' + v + '">' + v + '</option>');
        });
        getJsn  = justNames;
    });
    
    //buttons will be clickable only if we have something selected/in the input textbox
    $('#newingredient').keyup(function(){
        if ($('#newingredient').val() != ""){
            $('#newIngredientButton').prop('disabled',false);
        } else {
            $('#newIngredientButton').prop('disabled',true);
        }
    });
    
    //activate selection button if something is selected!
    ddl.change(function(){
        if (ddl.val() != ""){
            $('#selectIngredientButton').prop('disabled',false);
        } else {
            $('#selectIngredientButton').prop('disabled',true);
        }
    });

    //handle select ingredient button click
    $('#selectIngredientButton').click(function(){
        var selected = ddl.val();
        var cancelButtonHtml = ' <a id="cancelButton" data-val="'+selected+'" class="fa fa-times cancelButton"></a>';
        $('#already').text('');
        $('#already2').text('');
        
        if (selected != null && type.val() != null && ingrQuantity.val() != "" && !isNaN(ingrQuantity.val()))
        {
            //let the user see what he has selected
            $('#selected').append('<li id="'+selected+'" quantity="'+ingrQuantity.val()+'" type="'+type.val()+'">'+selected+' '+ingrQuantity.val()+' '+type.val()+cancelButtonHtml+'</li>');
            
            //remove the selected ingredient from the ddl 
            $('#ingredients :selected').remove();

            //add values to array
            ingred[counter1] = {
                'name':selected,
                'quantity':ingrQuantity.val(),
                'type':type.val()
            };
            counter1++;
            //clear the selection and input and disable the buttons
            ddl.val('');
            ingrQuantity.val('');
            $('#selectIngredientButton').prop('disabled',true);
            $('#newIngredientButton').prop('disabled',true);
        }
        else if (type.val() == null)
        {
            $('#already').text('');
            $('#already').text('Selezione errata!');
        }
        else if (ingrQuantity.val() == "" || isNaN(ingrQuantity.val()))
        {
            $('#already').text('');
            $('#already').text('Quantità errata!');
        }
    });
    
    //handles new ingredient button click event. checks if the ingredient is already present in database or already selected.
    $('#newIngredientButton').click(function(){
        
        $('#already2').text('');
        $('#already').text('');
        
        if(newingredient.val() != '' && newIngrQuantity.val() != '' && !isNaN(newIngrQuantity.val()) && typeNew.val() != null)
        {
            var newIngr = newingredient.val().toLowerCase();
            var cancelButtonHtml = ' <a id="cancelButton" data-val="'+newIngr+'" class="fa fa-times cancelButton"></a>';
            
            //presence check
            for (var i = 0; i < getJsn.length; i++)
            {
                if (getJsn[i].name == newIngr)
                {
                //ingredient already present
                $('#already2').append('Ingrediente già presente!');
                //reset newingredient field and disable buttons
                newingredient.val('');
                newIngrQuantity.val('');
                $('#selectIngredientButton').prop('disabled',true);
                $('#newIngredientButton').prop('disabled',true);            
                return false;
                }
            }
            
            //add the ingredient into newIngredientsInserted and check if the ingredient is already inserted.
            for (var i = 0; i < newIngred.length; i++)
            {
                if (newIngred[i]['name'] == newIngr)
                {
                //ingredient already present
                $('#already2').append('Ingrediente già presente!');
                //reset newingredient field and disable buttons
                newingredient.val('');
                newIngrQuantity.val('');
                $('#selectIngredientButton').prop('disabled',true);
                $('#newIngredientButton').prop('disabled',true);            
                return false;
                }
            }
            
            //let the user see what he has selected
            $('#selected').append('<li id="'+newIngr+'" quantity="'+newIngrQuantity.val()+'" type="'+typeNew.val()+'">'+newIngr+' '+newIngrQuantity.val()+' '+typeNew.val()+cancelButtonHtml+'</li>');
            
            //add values to array
            newIngred[counter2] = {
                'name':newIngr,
                'quantity':newIngrQuantity.val(),
                'type':typeNew.val()
            };

            //reset newingredient field and disable buttons
            newingredient.val('');
            newIngrQuantity.val('');
            $('#selectIngredientButton').prop('disabled',true);
            $('#newIngredientButton').prop('disabled',true);
            
            //POST the new ingredient via AJAX call
            $.ajax({
                type: "POST",
                data : {'newingr':newIngred[counter2], '_token': $('input[name=_token]').val()},
                url: "newingredientinsert"
            });
            
            counter2++;
            return true;
            
        }
        else if(typeNew.val() == null)
        {
            $('#already2').text('');
            $('#already2').text('Selezione errata!');    
        }
        else if(newIngrQuantity.val() == '' || isNaN(newIngrQuantity.val()))
        {
            $('#already2').text('');
            $('#already2').text('Quantità errata!');
        }
    });
    
    //handles cancel button click event. removes element from list and array
    $('body').on('click', 'a.cancelButton', function(){
        var ingredToRemove =  $(this).data('val');

        //removes that specific ingredient from the list.
        $('#'+ingredToRemove).remove();
        
        //add the ingredient back in the ddl
        ddl.append('<option value="' + ingredToRemove + '">' + ingredToRemove + '</option>');
        
        //removes the ingredient from the arrays (and lowers the counters)
        for(var i=0;i<ingred.length;i++)
        {
            if(ingred[i].name == ingredToRemove)
            {
                ingred.splice(ingred[i],1);
                counter1--;
            }
        }
        for(var z=0;z<newIngred.length;z++)
        {
            if(newIngred[z].name == ingredToRemove)
            {
                newIngred.splice(newIngred[z],1);
                counter2--;
            }
        }
    });
    
    // POSTing with AJAX recipe and ingredients!
    $('#inviaButton').click(function(){    
        var data = {
            'title':title.val(),
            'procedure':procedure.val(),
            'ingred':ingred.concat(newIngred)
        };
        
        var errList = $('#validatorErrorList');
        $.ajax({
            
            type: "POST",
            data : {'data':data, '_token': $('input[name=_token]').val()},
            url: "recipes",
            
            //on success redirect to recipes home page
            success:function(){
                window.location.href = 'recipes';
            },
            
            //on validator error, show the error list
            error: function(xhr,status, response) {
                errList.text("");
                var error = jQuery.parseJSON(xhr.responseText);
                
                for(var e in error.message){
                    if(error.message.hasOwnProperty(e)){
                        error.message[e].forEach(function(val){
                            errList.append('<li>'+val+'</li>');
                        });
                    }
                }
            },
            
            //the sending process may take a while, show that we are processing data!
            beforeSend: function () {
                errList.text("");
                errList.text("Inserimento ricetta...attendere!");
            }
        });
    });
});
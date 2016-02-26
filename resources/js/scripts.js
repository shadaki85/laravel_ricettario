$(document).ready(function(){
    
    
    //some vars needed soon
    var counter1 = 0;
    var counter2 = 0;
    //var newIngred = "newingr";
    //var ingred = "ingr";
    var ingred = [];
    var newIngred = [];
    var ddl = $('#ingredients');
    var getJsn;
    var data = [ingred,newIngred];
    var newIngredientsInserted = new Array();
    $('#selectIngredient').prop('disabled',true);
    $('#newIngredientButton').prop('disabled',true);
    
    
    //buttons will be clickable only if we have something selected/in the input textbox
    $('#newingredient').keyup(function(){
        if ($('#newingredient').val() != ""){
            $('#newIngredientButton').prop('disabled',false);
        } else {
            $('#newIngredientButton').prop('disabled',true);
        }
    });
    
    ddl.change(function(){
        if (ddl.val() != ""){
            $('#selectIngredient').prop('disabled',false);
        } else {
            $('#selectIngredient').prop('disabled',true);
        }
    });
    
    
    //populate drop down list from JSON storing JSON in var getJsn
    $.getJSON("../api/ingredients", function(result) {
        for (var i = 0; i < result.length; i++) {
        	ddl.append('<option value="' + result[i].name + '">' + result[i].name + '</option>');
        }
        getJsn  = result;

    });
    
    
    //on select ingredient button click, do something:
    $('#selectIngredient').click(function(){
        var selected = ddl.val();
        if (selected != null)
        {
            //let the user see what he has selected
            $('#selected').append(selected+' ');
            
            //remove the selected ingredient from the ddl 
            $('#ingredients :selected').remove();
            
            //append an hidden field to use with Request
//////////////$('#form').append('<input type="hidden" name="'+ingred+counter1.toString()+'" value="'+selected+'">');
            ingred[counter1] = selected;
            console.log(ingred[0]);
            counter1++;
            //clear the selection and disable the buttons
            ddl.val('');
            $('#selectIngredient').prop('disabled',true);
            $('#newIngredientButton').prop('disabled',true);
        }
    });
    
    
    
    //handles new ingredient button click event. checks if the ingredient is already present in JSON or already inserted.
    $('#newIngredientButton').click(function(){
        $('#already').text('');
        var newIngr = $('#newingredient').val().toLowerCase();
        for (var i = 0; i < getJsn.length; i++)
        {
            if (getJsn[i].name == newIngr)
            {
            //ingredient already present
            $('#already').append('Ingrediente già presente!');
            //reset newingredient field and disable buttons
            $('#newingredient').val('');
            $('#selectIngredient').prop('disabled',true);
            $('#newIngredientButton').prop('disabled',true);            
            return false;
            }
        }
        
        //add the ingredient into newIngredientsInserted and check if the ingredients is already present in the user inserted.
        for (var i = 0; i < newIngredientsInserted.length; i++)
        {
            if (newIngredientsInserted[i] == newIngr)
            {
            //ingredient already present
            $('#already').append('Ingrediente già presente!');
            //reset newingredient field and disable buttons
            $('#newingredient').val('');
            $('#selectIngredient').prop('disabled',true);
            $('#newIngredientButton').prop('disabled',true);            
            return false;
            }
        }
        
        //let the user see what he has selected
        $('#selected').append(newIngr+' ');
        
        //add the ingredient inserted into our array to use it for further checks
        newIngredientsInserted.push(newIngr);
        
        //append an hidden field to use with Request
//////////$('#form').append('<input type="hidden" name="'+newIngred+counter2.toString()+'" value="'+newIngr+'">');
        newIngred[counter2] = newIngr;
        counter2++;
        //reset newingredient field and disable buttons
        $('#newingredient').val('');
        $('#selectIngredient').prop('disabled',true);
        $('#newIngredientButton').prop('disabled',true);
        return true;
    });
    
    $('#form').submit(function(){
        $.ajax({
            type: "POST",
            data : {'data':'test',  '_token': $('input[name=_token]').val()},
            //data: {data:{ingred,newIngred}},
            url: "../recipes",
            success: function(data){
             console.log(data);
            },
            error: function(){
             console.log("error");
            }
        });
    });
});
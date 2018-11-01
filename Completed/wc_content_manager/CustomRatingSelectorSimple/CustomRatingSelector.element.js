( function() {
    var updateLevelValues = function(value){
        var setMapName = function(name){
            $("#{{element_id}}_level").text(name)
        }

        if (value == "1"){setMapName("Bronze")}else if(value == "2"){setMapName("Silver")}else if(value == "3"){setMapName("Gold")}else if(value == "4"){setMapName("Diamond")}   
        
    }

    $( "#{{ element_id }}_edit_view" ).each(function(){
        var value = $(this).children("div").text()

        
        //set the hidden input value. This input value is what is sent back when a post occurs
        $("#{{element_id}}_value").val(value)
        updateLevelValues(value)

        // Initialize the slider
        $(this).slider({
            min: 1,
            max: 4,
            value: value,
            slide: function( event, ui ) {
                $("#{{element_id}}_value").val(ui.value)
                $(this).children("div").text( ui.value );
                updateLevelValues(ui.value)
               
            }
        });

        

    })

    

    $( "#{{ element_id }}_read_view" ).each(function(){
        var value = $(this).children("div").text()
        updateLevelValues(value)

        $(this).slider({
            min: 1,
            max: 4,
            value: value,
            disabled: true
        });

    })
})();


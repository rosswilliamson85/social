$(document).ready(function(){




$('#search').on('input',function(){
   
    form_token = $('#form_token').val();
    search = $('#search').val();

    $.post('/search',{form_token:form_token,search:search},function(data){

        if(search === ""){
            $('#search_results').html("");
        }else{

            $('#search_results').html(data);
        }

   

    });

});


$('.search-form').on('submit', function(e) {
    e.preventDefault();
});


});
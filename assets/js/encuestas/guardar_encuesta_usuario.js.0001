$(document).ready(function ()
{
    $('.only_one_answer_text').click(function(){
       console.log('click'); 
       var tmp_id = this.id.replace("_text", "") + "_radio";
       console.log(tmp_id);
       document.getElementById(tmp_id).checked = false;
    });
    $('.only_one_answer_radio').click(function(){
       console.log('click'); 
       var tmp_id = this.id.replace("_radio", "") + "_text";
       console.log(tmp_id);
       document.getElementById(tmp_id).disabled = true;
       $('#'+tmp_id.replace("_text", "_link")).css('display', 'block');
    });
});

function activar_campo_texto(campo){
    document.getElementById(campo).disabled = false;
    var tmp_id = campo.replace("_text", "") + "_radio";
    console.log(tmp_id);
    document.getElementById(tmp_id).checked = false;
    $('#'+tmp_id.replace("_radio", "_link")).css('display', 'none');
}
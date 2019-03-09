$(document).ready(function ()
{
    display_en_bloque();
});


function display_en_bloque()
{
    data_ajax(site_url+'/curso/get_data_ajax', '#form_curso', '#listado_resultado');
    var item = $('#tutorizado')[0].value;
    if (item == 1)
    {
        $('#div_en_bloques').css('display', 'block');
    } else {
        $('#div_en_bloques').css('display', 'none');
    }
    $('#en_bloque').val('');
}
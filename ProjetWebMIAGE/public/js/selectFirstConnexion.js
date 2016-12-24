$(document).ready(function () {

    var seriesSelectionne = [];

    $('.imgSeriesFirstConnexion').mouseover(function () {
        if(seriesSelectionne.indexOf($(this).attr('idseries')) == -1){
            $(this).css('filter','brightness(1.3)');
            $(this).css('border','2px green solid');
            $(this).css('transform','scale(1.25)');
        }
    });

    $('.imgSeriesFirstConnexion').mouseleave(function () {
        if(seriesSelectionne.indexOf($(this).attr('idseries')) == -1){
            $(this).css('filter','opacity(1)');
            $(this).css('border','2px white solid');
            $(this).css('transform','scale(1.0)');
        }
    });

    $('.imgSeriesFirstConnexion').click(function () {
        var idSerie= $(this).attr('idseries');
        if(seriesSelectionne.indexOf(idSerie) != -1){
            removeA(seriesSelectionne,idSerie);
            $(this).css('filter','opacity(1)');
            $(this).css('border','2px white solid');
            $(this).css('transform','scale(1.0)');
        }else{
            seriesSelectionne.push(idSerie);
            $(this).css('filter','brightness(1.3)');
            $(this).css('border','2px green solid');
            $(this).css('transform','scale(1.25)');
        }

        if(seriesSelectionne.length >= 3){
            $('#boutonFirstConnexion').empty();
            var button = "<form role='form' action='' method='post' name='firstSelectionForm'>";
            seriesSelectionne.forEach(function (e) {
               button += "<input type='hidden' name='series[]' value='" + e + "'>"
            });
            button += "<button class='btn btn-success btn-block btn-lg'>Suivant</button></form>";

            $('#boutonFirstConnexion').append(button)
        }
    })
    
});

function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}
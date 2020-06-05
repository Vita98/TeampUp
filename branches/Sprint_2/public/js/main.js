function updatePopup(a) {
    document.getElementById('ModificationSaveButton').href = a;
}

/* STAR RATING*/

var firstStarRating=['ratingInnovativity1','ratingInnovativity2','ratingInnovativity3','ratingInnovativity4','ratingInnovativity5','ratingInnovativity6','ratingInnovativity7','ratingInnovativity8','ratingInnovativity9','ratingInnovativity10'];
var secondStarRating=['ratingCreativity1','ratingCreativity2','ratingCreativity3','ratingCreativity4','ratingCreativity5','ratingCreativity6','ratingCreativity7','ratingCreativity8','ratingCreativity9','ratingCreativity10'];

firstStarRating.forEach(function(element) {
    clickAnimationStar(element,firstStarRating);
});

secondStarRating.forEach(function(element) {
    clickAnimationStar(element,secondStarRating);
});

function clickAnimationStar(element,array){

    if(document.getElementById(element) != null){
        document.getElementById(element).addEventListener("click", function(){

            var found = false;
            var unchecking = false;
            array.forEach(function(element1){
                if (element == element1){

                    //controllo se quello che ho premuto era gia stato premuto
                    if(document.getElementById(element1+"Input").checked == true){

                        array.forEach(function(element2){
                            document.getElementById(element2).style["color"] = "black";
                            document.getElementById(element2+"Input").checked = false;
                        });
                        unchecking = true;

                    }else{
                        document.getElementById(element1).style["color"] = "orange";
                        document.getElementById(element1+"Input").checked = true;
                        found = true;
                    }
                }else if(found==false && unchecking==false){
                    document.getElementById(element1).style["color"] = "orange";
                    document.getElementById(element1+"Input").checked = false;
                }else{
                    document.getElementById(element1).style["color"] = "black";
                    document.getElementById(element1+"Input").checked = false;
                }
            });

        });
    }
}

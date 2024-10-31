/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


//pop-up

    
function triggerPopup() {
    $ = jQuery;
    //check if screen is long enough to scroll
    var yPos = $(document).scrollTop();
    var pageHeight = $(document).height();
    var viewportHeight = $(window).height();
    var scrollPercent = .30;
    var popupHeight = $(".ui-popup").height();
    var popupHeightOffset = "-" + popupHeight + "px";

    if (pageHeight <= (viewportHeight * (1 + scrollPercent))) {
        // trigger timer popup
        $(".ui-popup").delay(10000).animate({ bottom: '0px' }, 150);
        $(".ui-popup").delay(25000).animate({ bottom: popupHeightOffset }, 150);
    }
    else {
        $(window).scroll(function () {
            yPos = $(document).scrollTop();
            if ($(".ui-popup").is(':animated')) {
                //keep animating
            } else {
                if (yPos / (pageHeight - viewportHeight) >= scrollPercent) {
                    $(".ui-popup").animate({ bottom: '0px' }, 150);
                } else {
                    $(".ui-popup").animate({ bottom: popupHeightOffset }, 150);
                }
            }
        });
    }
    
    
    
    // add analytics
    $(".CTA").click(function(){

        // check for google analytics
        if (typeof _gaq === 'undefined') return;    

        try {        
            _gaq.push(['_trackEvent', 'CTA', $(this).text(), $(this).attr("href")]);
            }
        catch(e) {

        }
    
    });
    

}


